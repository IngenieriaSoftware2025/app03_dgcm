<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\AsigPermisos;
use Model\Permisos;
use Model\Aplicacion;
use Model\Usuarios;
use Model\PermisoAplicacion;

class AsigPermisosController extends ActiveRecord
{
    public static function mostrarAsignaciones(Router $router)
    {
        $router->render('asignaciones/asig_permiso', [], 'layout');
    }

    public static function guardarAsignacion()
    {
        try {
            // Validar campos requeridos usando helper
            $validacion = self::validarRequeridos($_POST, [
                'id_usuario',
                'id_permiso_app',
                'motivo'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            // Sanitizar datos usando helper
            $datos = self::sanitizarDatos($_POST);

            // Crear asignación con validaciones personalizadas
            $asignacion = new AsigPermisos([
                'id_usuario' => filter_var($datos['id_usuario'], FILTER_SANITIZE_NUMBER_INT),
                'id_permiso_app' => filter_var($datos['id_permiso_app'], FILTER_SANITIZE_NUMBER_INT),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_expiro' => null,
                'usuario_asigno' => $_SESSION['id_usuario'] ?? 0,
                'motivo' => ucfirst(strtolower($datos['motivo'])),
                'situacion' => 1
            ]);

            // Definir validaciones específicas de asignación
            $validaciones = [

                // Funcion para validar que el usuario exista
                function ($asignacion) {
                    if (!Usuarios::valorExiste('id_usuario', $asignacion->id_usuario)) {
                        return 'El usuario no existe';
                    }
                    return true;
                },

                // Validar que el permiso exista
                function ($asignacion) {
                    if (!PermisoAplicacion::valorExiste('id_permiso_app', $asignacion->id_permiso_app)) {
                        return 'El permiso-aplicación no existe';
                    }
                    return true;
                },

                // Validar que el usuario no tenga la asignación ya existente
                function ($asignacion) {
                    if (strlen($asignacion->motivo) < 5) {
                        return 'El motivo debe tener más de 5 caracteres';
                    }
                    return true;
                }
            ];

            // Guardar asignación en la base de datos
            $asignacion->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar la asignación: ' . $e->getMessage(), null, 500);
        }
    }

    // Funcion para buscar asiganciones de permisos
    public static function buscarAsignaciones()
    {

        AsigPermisos::buscarConRelacionMultiplesRespuesta(
            [
                [
                    'tabla' => 'usuarios',
                    'alias' => 'u',
                    'llave_local' => 'id_usuario',
                    'llave_foranea' => 'id_usuario',
                    'campos' => [
                        'nombre_usuario' => 'nombre1',
                        'apellido_usuario' => 'apellido1',
                        'dpi_usuario' => 'dpi'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'permiso_aplicacion',
                    'alias' => 'pa',
                    'llave_local' => 'id_permiso_app',
                    'llave_foranea' => 'id_permiso_app',
                    'campos' => [],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'permisos',
                    'alias' => 'p',
                    'from' => 'pa',
                    'llave_local' => 'id_permiso',
                    'llave_foranea' => 'id_permiso',
                    'campos' => [
                        'permiso' => 'nombre_permiso',
                        'descripcion_permiso' => 'descripcion'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'aplicacion',
                    'alias' => 'a',
                    'from' => 'pa',
                    'llave_local' => 'id_app',
                    'llave_foranea' => 'id_app',
                    'campos' => [
                        'nombre_aplicacion' => 'nombre_app_md'
                    ],
                    'tipo' => 'INNER'
                ]
            ],
            "asig_permisos.situacion = 1",
            "asig_permisos.fecha_creacion DESC"
        );
    }

    // Funcion para modificar asignaciones de permisos
    public static function modificarAsignacion()
    {
        try {
            // validar que se envíe el ID de la asignación
            if (empty($_POST['id_asig_permiso'])) {
                self::respuestaJSON(0, 'ID de asignación requerido', null, 400);
            }

            $id = $_POST['id_asig_permiso'];

            // Buscar permiso existente
            /** @var \Model\AsigPermisos $permisosAsig */
            $permisosAsig = AsigPermisos::find(['id_asig_permiso' => $id]);

            if (!$permisosAsig) {
                self::respuestaJSON(0, 'Asignación de permiso no encontrada', null, 404);
            }

            // Sanitizar nuevos datos
            $datos = self::sanitizarDatos($_POST);

            //  preparar los datos para sincronizar
            $datosParaSincronizar = [
                'id_usuario' => isset($datos['id_usuario']) ? filter_var($datos['id_usuario'], FILTER_SANITIZE_NUMBER_INT) : $permisosAsig->id_usuario,
                'id_permiso_app' => isset($datos['id_permiso_app']) ? filter_var($datos['id_permiso_app'], FILTER_SANITIZE_NUMBER_INT) : $permisosAsig->id_permiso_app,
                'usuario_asigno' => $_SESSION['id_usuario'] ?? $permisosAsig->usuario_asigno,
                'motivo' => isset($datos['motivo']) ? ucfirst(strtolower($datos['motivo'])) : $permisosAsig->motivo,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $permisosAsig->situacion
            ];

            //Usar sincronizar una sola vez con todos los datos
            $permisosAsig->sincronizar($datosParaSincronizar);

            // Validaciones solo de los campos que se van a modificar
            $validaciones = [
                function ($asignacion) use ($datosParaSincronizar) {
                    if (isset($datosParaSincronizar['id_usuario']) && !AsigPermisos::valorExiste('id_usuario', $asignacion->id_usuario)) {
                        return 'El usuario no existe';
                    }
                    return true;
                },
                function ($asignacion) use ($datosParaSincronizar) {
                    if (isset($datosParaSincronizar['id_permiso_app']) && !Permisos::valorExiste('id_permiso_app', $asignacion->id_permiso_app)) {
                        return 'El permiso no existe';
                    }
                    return true;
                },
                function ($asignacion) use ($datosParaSincronizar) {
                    if (isset($datosParaSincronizar['motivo']) && strlen($asignacion->motivo) < 5) {
                        return 'El motivo debe tener más de 5 caracteres';
                    }
                    return true;
                }
            ];

            // Guardar asignación modificada en la base de datos
            $permisosAsig->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar asignacion permiso: ' . $e->getMessage(), null, 500);
        }
    }

    // Funcion para eliminar asignaciones de permisos
    public static function eliminarAsignacion()
    {
        try {
            if (empty($_POST['id_asig_permiso'])) {
                self::respuestaJSON(0, 'ID de asignación requerido', null, 400);
            }

            $permisoAsig = AsigPermisos::find(['id_asig_permiso' => $_POST['id_asig_permiso']]);

            if (!$permisoAsig) {
                self::respuestaJSON(0, 'Asignación de permiso no encontrada', null, 404);
            }

            // Aquí está el cambio clave
            $permisoAsig->sincronizar([
                'situacion' => 0,
                'fecha_expiro' => date('Y-m-d H:i:s')
            ]);

            $permisoAsig->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar asignación: ' . $e->getMessage(), null, 500);
        }
    }
}
