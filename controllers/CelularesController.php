<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Celulares;
use Model\Marcas;

class CelularesController extends ActiveRecord
{
    public static function mostrarCelulares(Router $router)
    {
        $router->render('celulares/index', [], 'layout');
    }

    public static function guardarCelular()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['id_marca', 'modelo', 'precio_compra', 'precio_venta']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $celular = new Celulares([
                'id_marca' => filter_var($datos['id_marca'], FILTER_SANITIZE_NUMBER_INT),
                'modelo' => ucfirst(strtolower($datos['modelo'])),
                'precio_compra' => filter_var($datos['precio_compra'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'precio_venta' => filter_var($datos['precio_venta'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'stock_actual' => isset($datos['stock_actual']) ? (int) $datos['stock_actual'] : 0,
                'stock_minimo' => isset($datos['stock_minimo']) ? (int) $datos['stock_minimo'] : 5,
                'color' => $datos['color'] ?? '',
                'almacenamiento' => $datos['almacenamiento'] ?? '',
                'ram' => $datos['ram'] ?? '',
                'estado' => $datos['estado'] ?? 'Nuevo',
                'fecha_ingreso' => $datos['fecha_ingreso'] ?? date('Y-m-d'),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($celular) {
                    if (!Marcas::valorExiste('id_marca', $celular->id_marca)) {
                        return 'La marca no existe';
                    }
                    if (strlen($celular->modelo) < 2) {
                        return 'El modelo debe tener al menos 2 caracteres';
                    }
                    return true;
                }
            ];

            $celular->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar el celular: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarCelulares()
    {
        Celulares::buscarConRelacionRespuesta(
            'marcas',
            'id_marca',
            'id_marca',
            [
                'nombre_marca' => 'nombre_marca',
                'pais_origen' => 'pais_origen'
            ],
            "celulares.situacion = 1",
            "celulares.id_celular DESC"
        );
    }

    public static function modificarCelular()
    {
        try {
            if (empty($_POST['id_celular'])) {
                self::respuestaJSON(0, 'ID de celular requerido', null, 400);
            }

            $id = $_POST['id_celular'];
            /** @var \Model\Celulares $celular */
            $celular = Celulares::find(['id_celular' => $id]);

            if (!$celular) {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'id_marca' => isset($datos['id_marca']) ? filter_var($datos['id_marca'], FILTER_SANITIZE_NUMBER_INT) : $celular->id_marca,
                'modelo' => isset($datos['modelo']) ? ucfirst(strtolower($datos['modelo'])) : $celular->modelo,
                'precio_compra' => isset($datos['precio_compra']) ? filter_var($datos['precio_compra'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : $celular->precio_compra,
                'precio_venta' => isset($datos['precio_venta']) ? filter_var($datos['precio_venta'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : $celular->precio_venta,
                'stock_actual' => isset($datos['stock_actual']) ? (int) $datos['stock_actual'] : $celular->stock_actual,
                'stock_minimo' => isset($datos['stock_minimo']) ? (int) $datos['stock_minimo'] : $celular->stock_minimo,
                'color' => $datos['color'] ?? $celular->color,
                'almacenamiento' => $datos['almacenamiento'] ?? $celular->almacenamiento,
                'ram' => $datos['ram'] ?? $celular->ram,
                'estado' => $datos['estado'] ?? $celular->estado,
                'fecha_ingreso' => $datos['fecha_ingreso'] ?? $celular->fecha_ingreso,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $celular->situacion
            ];

            $celular->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($celular) {
                    if (!Marcas::valorExiste('id_marca', $celular->id_marca)) {
                        return 'La marca no existe';
                    }
                    if (strlen($celular->modelo) < 2) {
                        return 'El modelo debe tener al menos 2 caracteres';
                    }
                    return true;
                }
            ];

            $celular->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar el celular: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarCelular()
    {
        try {
            if (empty($_POST['id_celular'])) {
                self::respuestaJSON(0, 'ID de celular requerido', null, 400);
            }

            $celular = Celulares::find(['id_celular' => $_POST['id_celular']]);

            if (!$celular) {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }

            $celular->sincronizar(['situacion' => 0]);
            $celular->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar el celular: ' . $e->getMessage(), null, 500);
        }
    }
}
