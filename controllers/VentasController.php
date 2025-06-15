<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Ventas;
use Model\Clientes;
use Model\Empleados;

class VentasController extends ActiveRecord
{
    public static function mostrarVentas(Router $router)
    {
        $router->render('ventas/index', [], 'layout');
    }

    public static function guardarVenta()
    {
        try {
            $validacion = self::validarRequeridos($_POST, [
                'id_empleado_vendedor',
                'id_cliente',
                'tipo_venta',
                'subtotal',
                'total'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $venta = new Ventas([
                'id_empleado_vendedor' => filter_var($datos['id_empleado_vendedor'], FILTER_SANITIZE_NUMBER_INT),
                'id_cliente' => filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT),
                'numero_factura' => $datos['numero_factura'] ?? null,
                'fecha_venta' => date('Y-m-d H:i:s'),
                'tipo_venta' => strtoupper($datos['tipo_venta']),
                'subtotal' => floatval($datos['subtotal']),
                'descuento' => isset($datos['descuento']) ? floatval($datos['descuento']) : 0,
                'impuestos' => isset($datos['impuestos']) ? floatval($datos['impuestos']) : 0,
                'total' => floatval($datos['total']),
                'metodo_pago' => $datos['metodo_pago'] ?? 'Efectivo',
                'estado_pago' => $datos['estado_pago'] ?? 'Pagado',
                'observaciones' => $datos['observaciones'] ?? '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($venta) {
                    if (!Clientes::valorExiste('id_cliente', $venta->id_cliente)) {
                        return 'El cliente no existe';
                    }
                    if (!Empleados::valorExiste('id_empleado', $venta->id_empleado_vendedor)) {
                        return 'El empleado vendedor no existe';
                    }
                    if (!in_array($venta->tipo_venta, ['C', 'R', 'M'])) {
                        return 'Tipo de venta inválido';
                    }
                    return true;
                }
            ];

            $venta->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar la venta: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarVentas()
    {
        Ventas::buscarConRelacionMultiplesRespuesta(
            [
                [
                    'tabla' => 'clientes',
                    'alias' => 'c',
                    'llave_local' => 'id_cliente',
                    'llave_foranea' => 'id_cliente',
                    'campos' => [
                        'nombre_cliente' => 'nombres',
                        'apellido_cliente' => 'apellidos',
                        'nit_cliente' => 'nit'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'empleados',
                    'alias' => 'e',
                    'llave_local' => 'id_empleado_vendedor',
                    'llave_foranea' => 'id_empleado',
                    'campos' => [
                        'codigo_empleado' => 'codigo_empleado',
                        'puesto_empleado' => 'puesto'
                    ],
                    'tipo' => 'INNER'
                ]
            ],
            "ventas.situacion = 1",
            "ventas.fecha_venta DESC"
        );
    }

    public static function modificarVenta()
    {
        try {
            if (empty($_POST['id_venta'])) {
                self::respuestaJSON(0, 'ID de venta requerido', null, 400);
            }

            $id = $_POST['id_venta'];
            /** @var \Model\Ventas $venta */
            $venta = Ventas::find(['id_venta' => $id]);

            if (!$venta) {
                self::respuestaJSON(0, 'Venta no encontrada', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'id_empleado_vendedor' => isset($datos['id_empleado_vendedor']) ? filter_var($datos['id_empleado_vendedor'], FILTER_SANITIZE_NUMBER_INT) : $venta->id_empleado_vendedor,
                'id_cliente' => isset($datos['id_cliente']) ? filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT) : $venta->id_cliente,
                'numero_factura' => $datos['numero_factura'] ?? $venta->numero_factura,
                'tipo_venta' => $datos['tipo_venta'] ?? $venta->tipo_venta,
                'subtotal' => isset($datos['subtotal']) ? floatval($datos['subtotal']) : $venta->subtotal,
                'descuento' => isset($datos['descuento']) ? floatval($datos['descuento']) : $venta->descuento,
                'impuestos' => isset($datos['impuestos']) ? floatval($datos['impuestos']) : $venta->impuestos,
                'total' => isset($datos['total']) ? floatval($datos['total']) : $venta->total,
                'metodo_pago' => $datos['metodo_pago'] ?? $venta->metodo_pago,
                'estado_pago' => $datos['estado_pago'] ?? $venta->estado_pago,
                'observaciones' => $datos['observaciones'] ?? $venta->observaciones,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $venta->situacion
            ];

            $venta->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($venta) {
                    if (!Clientes::valorExiste('id_cliente', $venta->id_cliente)) {
                        return 'El cliente no existe';
                    }
                    if (!Empleados::valorExiste('id_empleado', $venta->id_empleado_vendedor)) {
                        return 'El empleado vendedor no existe';
                    }
                    return true;
                }
            ];

            $venta->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar la venta: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarVenta()
    {
        try {
            if (empty($_POST['id_venta'])) {
                self::respuestaJSON(0, 'ID de venta requerido', null, 400);
            }

            $venta = Ventas::find(['id_venta' => $_POST['id_venta']]);

            if (!$venta) {
                self::respuestaJSON(0, 'Venta no encontrada', null, 404);
            }

            $venta->sincronizar(['situacion' => 0]);
            $venta->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar la venta: ' . $e->getMessage(), null, 500);
        }
    }
}
