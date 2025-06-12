<?php

// ARCHIVO: Controllers/VentasController.php
namespace Controllers;

use Exception;
use MVC\Router;
use Model\Ventas;
use Model\DetalleVentas;
use Model\Celulares;
use Model\ActiveRecord;

class VentasController extends ActiveRecord
{
    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function guardarVenta()
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            self::respuestaJSON(0, 'Acceso denegado', null, 403);
            return;
        }

        try {
            $validacion = self::validarRequeridos($_POST, ['id_cliente', 'tipo', 'total']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            // Obtener ID del empleado vendedor
            $idEmpleadoVendedor = self::fetchScalar(
                "SELECT e.id_empleado FROM empleados e 
                 INNER JOIN usuarios u ON e.id_usuario = u.id_usuario 
                 WHERE u.id_usuario = ? AND u.situacion = 1",
                [$_SESSION['user']['id_usuario']]
            );

            if (!$idEmpleadoVendedor) {
                self::respuestaJSON(0, 'No se encontró información del empleado', null, 400);
                return;
            }

            // Iniciar transacción
            self::$db->beginTransaction();

            try {
                // 1. Crear venta
                $venta = new Ventas([
                    'id_empleado_vendedor' => $idEmpleadoVendedor,
                    'id_cliente' => filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT),
                    'fecha_venta' => date('Y-m-d H:i:s'),
                    'tipo' => $datos['tipo'],
                    'total' => filter_var($datos['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'situacion' => 1
                ]);

                $resultadoVenta = $venta->crear();
                if (!$resultadoVenta['resultado']) {
                    throw new Exception('Error al crear la venta');
                }

                $idVenta = $resultadoVenta['id'];

                // 2. Procesar detalle según el tipo
                if ($datos['tipo'] === 'C' && !empty($datos['id_celular'])) {
                    // Venta de celular
                    $celular = Celulares::find(['id_celular' => $datos['id_celular']]);
                    if (!$celular) {
                        throw new Exception('Celular no encontrado');
                    }

                    $cantidad = (int)($datos['cantidad'] ?? 1);
                    if ($celular->cantidad < $cantidad) {
                        throw new Exception('Stock insuficiente');
                    }

                    // Crear detalle
                    $detalle = new DetalleVentas([
                        'id_venta' => $idVenta,
                        'id_celular' => $datos['id_celular'],
                        'cantidad' => $cantidad,
                        'precio_unitario' => $celular->precio_venta
                    ]);

                    $resultadoDetalle = $detalle->crear();
                    if (!$resultadoDetalle['resultado']) {
                        throw new Exception('Error al crear detalle de venta');
                    }

                    // Actualizar stock
                    $celular->cantidad -= $cantidad;
                    $celular->actualizar();
                } elseif ($datos['tipo'] === 'R' && !empty($datos['id_reparacion'])) {
                    // Venta de reparación
                    $reparacionExiste = self::fetchScalar(
                        "SELECT COUNT(*) FROM reparaciones WHERE id_reparacion = ? AND estado = 'Terminado'",
                        [$datos['id_reparacion']]
                    );

                    if (!$reparacionExiste) {
                        throw new Exception('La reparación no existe o no está terminada');
                    }

                    // Crear detalle
                    $detalle = new DetalleVentas([
                        'id_venta' => $idVenta,
                        'id_reparacion' => $datos['id_reparacion'],
                        'cantidad' => 1,
                        'precio_unitario' => $datos['total']
                    ]);

                    $resultadoDetalle = $detalle->crear();
                    if (!$resultadoDetalle['resultado']) {
                        throw new Exception('Error al crear detalle de venta');
                    }

                    // Actualizar estado de reparación a Entregado
                    self::$db->exec("UPDATE reparaciones SET estado = 'Entregado' WHERE id_reparacion = " .
                        self::$db->quote($datos['id_reparacion']));
                }

                self::$db->commit();
                self::respuestaJSON(1, 'Venta procesada exitosamente', ['id_venta' => $idVenta]);
            } catch (Exception $e) {
                self::$db->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al procesar venta: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaVenta()
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            self::respuestaJSON(0, 'Acceso denegado', null, 403);
            return;
        }

        try {
            $sql = "SELECT 
                        v.id_venta,
                        v.fecha_venta,
                        v.tipo,
                        v.total,
                        CONCAT(uc.nombre1, ' ', uc.apellido1) as cliente_nombre,
                        CONCAT(ue.nombre1, ' ', ue.apellido1) as empleado_nombre,
                        CASE 
                            WHEN v.tipo = 'C' THEN CONCAT(m.marca_nombre, ' ', c.modelo)
                            WHEN v.tipo = 'R' THEN 'Reparación'
                        END as producto
                    FROM ventas v
                    INNER JOIN clientes cl ON v.id_cliente = cl.id_cliente
                    INNER JOIN usuarios uc ON cl.id_usuario = uc.id_usuario
                    INNER JOIN empleados e ON v.id_empleado_vendedor = e.id_empleado
                    INNER JOIN usuarios ue ON e.id_usuario = ue.id_usuario
                    LEFT JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
                    LEFT JOIN celulares c ON dv.id_celular = c.id_celular
                    LEFT JOIN marcas m ON c.id_marca = m.id_marca
                    WHERE v.situacion = 1
                    ORDER BY v.fecha_venta DESC";

            $ventas = self::fetchArray($sql);
            self::respuestaJSON(1, 'Ventas encontradas', $ventas);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al buscar ventas: ' . $e->getMessage(), null, 500);
        }
    }

    public static function obtenerReparacionesTerminadas()
    {
        try {
            $sql = "SELECT 
                        r.id_reparacion,
                        CONCAT(u.nombre1, ' ', u.apellido1) as cliente_nombre,
                        r.motivo,
                        r.costo_servicio,
                        ts.descripcion as tipo_servicio
                    FROM reparaciones r
                    INNER JOIN clientes c ON r.id_cliente = c.id_cliente
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                    INNER JOIN tipo_servicio ts ON r.id_tipo_servicio = ts.id_tipo_servicio
                    WHERE r.estado = 'Terminado'
                    ORDER BY r.fecha_ingreso DESC";

            $reparaciones = self::fetchArray($sql);
            self::respuestaJSON(1, 'Reparaciones terminadas encontradas', $reparaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener reparaciones: ' . $e->getMessage(), null, 500);
        }
    }
}
