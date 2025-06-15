<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\DetalleVentas;
use Model\Ventas;
use Model\Celulares;
use Model\Reparaciones;

class DetalleVentasController extends ActiveRecord
{
    public static function mostrarDetalles(Router $router)
    {
        $router->render('detalle_ventas/index', [], 'layout');
    }

    public static function guardarDetalle()
    {
        try {
            $validacion = self::validarRequeridos($_POST, [
                'id_venta',
                'descripcion',
                'cantidad',
                'precio_unitario',
                'subtotal_item'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $detalle = new DetalleVentas([
                'id_venta' => filter_var($datos['id_venta'], FILTER_SANITIZE_NUMBER_INT),
                'id_celular' => isset($datos['id_celular']) ? filter_var($datos['id_celular'], FILTER_SANITIZE_NUMBER_INT) : null,
                'id_reparacion' => isset($datos['id_reparacion']) ? filter_var($datos['id_reparacion'], FILTER_SANITIZE_NUMBER_INT) : null,
                'descripcion' => $datos['descripcion'],
                'cantidad' => intval($datos['cantidad']),
                'precio_unitario' => floatval($datos['precio_unitario']),
                'descuento_item' => isset($datos['descuento_item']) ? floatval($datos['descuento_item']) : 0,
                'subtotal_item' => floatval($datos['subtotal_item']),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($detalle) {
                    if (!Ventas::valorExiste('id_venta', $detalle->id_venta)) {
                        return 'La venta no existe';
                    }
                    if ($detalle->id_celular && !Celulares::valorExiste('id_celular', $detalle->id_celular)) {
                        return 'El celular no existe';
                    }
                    if ($detalle->id_reparacion && !Reparaciones::valorExiste('id_reparacion', $detalle->id_reparacion)) {
                        return 'La reparación no existe';
                    }
                    if ($detalle->cantidad <= 0) {
                        return 'La cantidad debe ser mayor a 0';
                    }
                    if ($detalle->subtotal_item <= 0) {
                        return 'El subtotal debe ser mayor a 0';
                    }
                    return true;
                }
            ];

            $detalle->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar el detalle de venta: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarDetalles()
    {
        DetalleVentas::buscarConRelacionMultiplesRespuesta(
            [
                [
                    'tabla' => 'ventas',
                    'alias' => 'v',
                    'llave_local' => 'id_venta',
                    'llave_foranea' => 'id_venta',
                    'campos' => [
                        'numero_factura' => 'numero_factura',
                        'tipo_venta' => 'tipo_venta'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'celulares',
                    'alias' => 'c',
                    'llave_local' => 'id_celular',
                    'llave_foranea' => 'id_celular',
                    'campos' => [
                        'modelo_celular' => 'modelo',
                        'color_celular' => 'color'
                    ],
                    'tipo' => 'LEFT'
                ],
                [
                    'tabla' => 'reparaciones',
                    'alias' => 'r',
                    'llave_local' => 'id_reparacion',
                    'llave_foranea' => 'id_reparacion',
                    'campos' => [
                        'tipo_celular_rep' => 'tipo_celular',
                        'motivo_rep' => 'motivo'
                    ],
                    'tipo' => 'LEFT'
                ]
            ],
            "detalle_ventas.situacion = 1",
            "detalle_ventas.id_detalle DESC"
        );
    }

    public static function modificarDetalle()
    {
        try {
            if (empty($_POST['id_detalle'])) {
                self::respuestaJSON(0, 'ID de detalle requerido', null, 400);
            }

            $id = $_POST['id_detalle'];
            /** @var \Model\DetalleVentas $detalle */
            $detalle = DetalleVentas::find(['id_detalle' => $id]);

            if (!$detalle) {
                self::respuestaJSON(0, 'Detalle de venta no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'id_venta' => isset($datos['id_venta']) ? filter_var($datos['id_venta'], FILTER_SANITIZE_NUMBER_INT) : $detalle->id_venta,
                'id_celular' => isset($datos['id_celular']) ? filter_var($datos['id_celular'], FILTER_SANITIZE_NUMBER_INT) : $detalle->id_celular,
                'id_reparacion' => isset($datos['id_reparacion']) ? filter_var($datos['id_reparacion'], FILTER_SANITIZE_NUMBER_INT) : $detalle->id_reparacion,
                'descripcion' => $datos['descripcion'] ?? $detalle->descripcion,
                'cantidad' => isset($datos['cantidad']) ? intval($datos['cantidad']) : $detalle->cantidad,
                'precio_unitario' => isset($datos['precio_unitario']) ? floatval($datos['precio_unitario']) : $detalle->precio_unitario,
                'descuento_item' => isset($datos['descuento_item']) ? floatval($datos['descuento_item']) : $detalle->descuento_item,
                'subtotal_item' => isset($datos['subtotal_item']) ? floatval($datos['subtotal_item']) : $detalle->subtotal_item,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $detalle->situacion
            ];

            $detalle->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($detalle) {
                    if (!Ventas::valorExiste('id_venta', $detalle->id_venta)) {
                        return 'La venta no existe';
                    }
                    if ($detalle->id_celular && !Celulares::valorExiste('id_celular', $detalle->id_celular)) {
                        return 'El celular no existe';
                    }
                    if ($detalle->id_reparacion && !Reparaciones::valorExiste('id_reparacion', $detalle->id_reparacion)) {
                        return 'La reparación no existe';
                    }
                    return true;
                }
            ];

            $detalle->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar el detalle: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarDetalle()
    {
        try {
            if (empty($_POST['id_detalle'])) {
                self::respuestaJSON(0, 'ID de detalle requerido', null, 400);
            }

            $detalle = DetalleVentas::find(['id_detalle' => $_POST['id_detalle']]);

            if (!$detalle) {
                self::respuestaJSON(0, 'Detalle no encontrado', null, 404);
            }

            $detalle->sincronizar(['situacion' => 0]);
            $detalle->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar el detalle: ' . $e->getMessage(), null, 500);
        }
    }
}
