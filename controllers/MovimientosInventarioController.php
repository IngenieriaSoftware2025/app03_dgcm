<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\MovimientosInventario;
use Model\Celulares;
use Model\Empleados;

class MovimientosInventarioController extends ActiveRecord
{
    public static function mostrarMovimientos(Router $router)
    {
        $router->render('inventario/movimientos', [], 'layout');
    }

    public static function guardarMovimiento()
    {
        try {
            $validacion = self::validarRequeridos($_POST, [
                'id_celular',
                'id_empleado',
                'tipo_movimiento',
                'cantidad'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            // Obtener stock actual antes del movimiento
            $stockActual = Celulares::obtenerValor('stock_actual', 'id_celular', $datos['id_celular']);

            if ($stockActual === null) {
                self::respuestaJSON(0, 'El celular no existe en inventario', null, 400);
            }

            $cantidad = intval($datos['cantidad']);
            $tipo = strtolower($datos['tipo_movimiento']);
            $nuevoStock = $stockActual;

            if ($tipo === 'entrada') {
                $nuevoStock += $cantidad;
            } elseif (in_array($tipo, ['salida', 'venta', 'ajuste'])) {
                $nuevoStock -= $cantidad;
                if ($nuevoStock < 0) {
                    self::respuestaJSON(0, 'No hay suficiente stock para realizar el movimiento', null, 400);
                }
            } else {
                self::respuestaJSON(0, 'Tipo de movimiento inválido', null, 400);
            }

            $movimiento = new MovimientosInventario([
                'id_celular' => filter_var($datos['id_celular'], FILTER_SANITIZE_NUMBER_INT),
                'id_empleado' => filter_var($datos['id_empleado'], FILTER_SANITIZE_NUMBER_INT),
                'tipo_movimiento' => ucfirst($tipo),
                'cantidad' => $cantidad,
                'stock_anterior' => $stockActual,
                'stock_nuevo' => $nuevoStock,
                'motivo' => $datos['motivo'] ?? '',
                'referencia' => $datos['referencia'] ?? '',
                'fecha_movimiento' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($movimiento) {
                    if (!Celulares::valorExiste('id_celular', $movimiento->id_celular)) {
                        return 'El celular no existe';
                    }
                    if (!Empleados::valorExiste('id_empleado', $movimiento->id_empleado)) {
                        return 'El empleado no existe';
                    }
                    return true;
                }
            ];

            // Registrar movimiento
            $movimiento->crearConRespuesta($validaciones);

            // Actualizar el stock actual en tabla celulares
            Celulares::SQL("UPDATE celulares SET stock_actual = {$nuevoStock} WHERE id_celular = {$movimiento->id_celular}");
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar el movimiento: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarMovimientos()
    {
        MovimientosInventario::buscarConRelacionMultiplesRespuesta(
            [
                [
                    'tabla' => 'celulares',
                    'alias' => 'c',
                    'llave_local' => 'id_celular',
                    'llave_foranea' => 'id_celular',
                    'campos' => [
                        'modelo_celular' => 'modelo',
                        'color_celular' => 'color',
                        'almacenamiento' => 'almacenamiento'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'empleados',
                    'alias' => 'e',
                    'llave_local' => 'id_empleado',
                    'llave_foranea' => 'id_empleado',
                    'campos' => [
                        'codigo_empleado' => 'codigo_empleado',
                        'puesto_empleado' => 'puesto'
                    ],
                    'tipo' => 'INNER'
                ]
            ],
            "movimientos_inventario.situacion = 1",
            "movimientos_inventario.fecha_movimiento DESC"
        );
    }

    public static function eliminarMovimiento()
    {
        try {
            if (empty($_POST['id_movimiento'])) {
                self::respuestaJSON(0, 'ID de movimiento requerido', null, 400);
            }

            $movimiento = MovimientosInventario::find(['id_movimiento' => $_POST['id_movimiento']]);

            if (!$movimiento) {
                self::respuestaJSON(0, 'Movimiento no encontrado', null, 404);
            }

            $movimiento->sincronizar(['situacion' => 0]);
            $movimiento->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar el movimiento: ' . $e->getMessage(), null, 500);
        }
    }
}
