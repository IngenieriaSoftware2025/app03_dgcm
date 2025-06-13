<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\PermisoAplicacion;
use Model\Permisos;
use Model\Aplicacion;

class PermisoAplicacionController extends ActiveRecord
{
    public static function mostrarVista(Router $router)
    {
        $router->render('permisos/permiso_aplicacion', [], 'layout');
    }

    public static function guardarRelacion()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['id_permiso', 'id_app']);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $registro = new PermisoAplicacion([
                'id_permiso' => filter_var($datos['id_permiso'], FILTER_SANITIZE_NUMBER_INT),
                'id_app' => filter_var($datos['id_app'], FILTER_SANITIZE_NUMBER_INT),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $registro->crearConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarRelaciones()
    {
        PermisoAplicacion::buscarConRelacionMultiplesRespuesta(
            [
                [
                    'tabla' => 'permisos',
                    'alias' => 'p',
                    'llave_local' => 'id_permiso',
                    'llave_foranea' => 'id_permiso',
                    'campos' => [
                        'nombre_permiso' => 'nombre_permiso',
                        'clave_permiso' => 'clave_permiso',
                        'descripcion_permiso' => 'descripcion'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'aplicacion',
                    'alias' => 'a',
                    'llave_local' => 'id_app',
                    'llave_foranea' => 'id_app',
                    'campos' => [
                        'nombre_aplicacion' => 'nombre_app_md'
                    ],
                    'tipo' => 'INNER'
                ]
            ],
            "permiso_aplicacion.situacion = 1",
            "permiso_aplicacion.fecha_creacion DESC"
        );
    }

    public static function eliminarRelacion()
    {
        try {
            if (empty($_POST['id_permiso_app'])) {
                self::respuestaJSON(0, 'ID de relación requerido', null, 400);
            }
            PermisoAplicacion::eliminarLogicoConRespuesta($_POST['id_permiso_app'], 'id_permiso_app');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar: ' . $e->getMessage(), null, 500);
        }
    }
}
