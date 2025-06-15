<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\TiposServicios;

class TiposServiciosController extends ActiveRecord
{
    public static function mostrarTiposServicios(Router $router)
    {
        $router->render('tipos_servicios/index', [], 'layout');
    }

    public static function guardarTipoServicio()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['descripcion']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $tipoServicio = new TiposServicios([
                'descripcion' => ucfirst(strtolower($datos['descripcion'])),
                'precio_base' => isset($datos['precio_base']) ? filter_var($datos['precio_base'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0,
                'tiempo_estimado' => isset($datos['tiempo_estimado']) ? (int) $datos['tiempo_estimado'] : 0,
                'categoria' => $datos['categoria'] ?? '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($tipoServicio) {
                    if (strlen($tipoServicio->descripcion) < 3) {
                        return 'La descripción debe tener al menos 3 caracteres';
                    }
                    return true;
                }
            ];

            $tipoServicio->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar el tipo de servicio: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarTiposServicios()
    {
        TiposServicios::buscarConRespuesta("situacion = 1", "id_tipo_servicio DESC");
    }

    public static function modificarTipoServicio()
    {
        try {
            if (empty($_POST['id_tipo_servicio'])) {
                self::respuestaJSON(0, 'ID de tipo de servicio requerido', null, 400);
            }

            $id = $_POST['id_tipo_servicio'];
            /** @var \Model\TiposServicios $tipoServicio */
            $tipoServicio = TiposServicios::find(['id_tipo_servicio' => $id]);

            if (!$tipoServicio) {
                self::respuestaJSON(0, 'Tipo de servicio no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'descripcion' => isset($datos['descripcion']) ? ucfirst(strtolower($datos['descripcion'])) : $tipoServicio->descripcion,
                'precio_base' => isset($datos['precio_base']) ? filter_var($datos['precio_base'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : $tipoServicio->precio_base,
                'tiempo_estimado' => isset($datos['tiempo_estimado']) ? (int) $datos['tiempo_estimado'] : $tipoServicio->tiempo_estimado,
                'categoria' => $datos['categoria'] ?? $tipoServicio->categoria,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $tipoServicio->situacion
            ];

            $tipoServicio->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($tipoServicio) {
                    if (strlen($tipoServicio->descripcion) < 3) {
                        return 'La descripción debe tener al menos 3 caracteres';
                    }
                    return true;
                }
            ];

            $tipoServicio->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar el tipo de servicio: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarTipoServicio()
    {
        try {
            if (empty($_POST['id_tipo_servicio'])) {
                self::respuestaJSON(0, 'ID de tipo de servicio requerido', null, 400);
            }

            $tipoServicio = TiposServicios::find(['id_tipo_servicio' => $_POST['id_tipo_servicio']]);

            if (!$tipoServicio) {
                self::respuestaJSON(0, 'Tipo de servicio no encontrado', null, 404);
            }

            $tipoServicio->sincronizar(['situacion' => 0]);
            $tipoServicio->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar el tipo de servicio: ' . $e->getMessage(), null, 500);
        }
    }
}
