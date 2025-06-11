<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Permisos;

class PermisoController extends ActiveRecord
{

    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function mostrarPermisos(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/dashboard');
            exit;
        }
        $router->render('permisos/permisos', [], 'layout');
    }

    public static function guardarPermiso()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            // Validar campos requeridos usando helper
            $validacion = self::validarRequeridos($_POST, [
                'id_usuario',
                'id_rol',
                'descripcion'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            // Sanitizar datos usando helper
            $datos = self::sanitizarDatos($_POST);

            // Crear permiso con validaciones personalizadas
            $permiso = new Permisos([
                'id_usuario' => filter_var($datos['id_usuario'], FILTER_SANITIZE_NUMBER_INT),
                'id_rol' => filter_var($datos['id_rol'], FILTER_SANITIZE_NUMBER_INT),
                'descripcion' => ucfirst(strtolower($datos['descripcion'])),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            // Definir validaciones específicas de permiso
            $validaciones = [
                // Validar que usuario y rol existan
                function ($permiso) {
                    if (empty($permiso->id_usuario)) {
                        return 'ID de usuario requerido';
                    }
                    if (empty($permiso->id_rol)) {
                        return 'ID de rol requerido';
                    }
                    return true;
                },

                // Validar descripción
                function ($permiso) {
                    if (strlen($permiso->descripcion) < 5) {
                        return 'Descripción debe tener más de 5 caracteres';
                    }
                    if (strlen($permiso->descripcion) > 255) {
                        return 'Descripción no puede exceder 255 caracteres';
                    }
                    return true;
                },

                // Validar que no exista ya la asignación usuario-rol
                function ($permiso) {
                    $sql   = "SELECT COUNT(*) FROM usuario_rol 
                                WHERE id_usuario = ? AND id_rol = ? AND situacion = 1";
                    $total = Permisos::fetchScalar($sql, [
                        $permiso->id_usuario,
                        $permiso->id_rol
                    ]);

                    if ($total > 0) {
                        return 'El usuario ya tiene asignado este rol';
                    }
                    return true;
                },

                // Validar que usuario exista
                function ($permiso) {
                    $sql    = "SELECT COUNT(*) FROM usuarios 
                                WHERE id_usuario = ? AND situacion = 1";
                    $exists = Permisos::fetchScalar($sql, [$permiso->id_usuario]);

                    if ($exists == 0) {
                        return 'El usuario seleccionado no existe o está inactivo';
                    }
                    return true;
                },

                // Validar que rol exista
                function ($permiso) {
                    $sql    = "SELECT COUNT(*) FROM roles 
                                WHERE id_rol = ? AND situacion = 1";
                    $exists = Permisos::fetchScalar($sql, [$permiso->id_rol]);

                    if ($exists == 0) {
                        return 'El rol seleccionado no existe o está inactivo';
                    }
                    return true;
                }
            ];

            // Crear con validaciones y respuesta automática
            $permiso->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar permiso: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaPermiso()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        Permisos::buscarConMultiplesRelaciones(
            [
                // Relación con usuarios
                'usuario' => [
                    'tabla' => 'usuarios',
                    'llave_local' => 'id_usuario',
                    'llave_foranea' => 'id_usuario',
                    'tipo' => 'INNER',
                    'campos' => [
                        'usuario_nombre' => 'nombre1',
                        'usuario_apellido' => 'apellido1',
                        'usuario_correo' => 'correo'
                    ]
                ],
                // Relación con roles
                'rol' => [
                    'tabla' => 'roles',
                    'llave_local' => 'id_rol',
                    'llave_foranea' => 'id_rol',
                    'tipo' => 'INNER',
                    'campos' => [
                        'rol_nombre' => 'rol_nombre',
                        'rol_descripcion' => 'descripcion'
                    ]
                ]
            ],
            "usuario_rol.situacion = 1",                    // Condiciones
            "usuarios.nombre1, roles.rol_nombre"            // Orden
        );
    }

    public static function modificaPermiso()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            // Validar que llegue el ID
            if (empty($_POST['id_usuario_rol'])) {
                self::respuestaJSON(0, 'ID de asignación requerido', null, 400);
            }

            $id = $_POST['id_usuario_rol'];

            // Buscar permiso existente
            $permiso = Permisos::find(['id_usuario_rol' => $id]);
            if (!$permiso) {
                self::respuestaJSON(0, 'Asignación no encontrada', null, 404);
            }

            // Sanitizar nuevos datos
            $datos = self::sanitizarDatos($_POST);

            // Preparar TODOS los datos para sincronizar
            $datosParaSincronizar = [
                'id_usuario' => filter_var($datos['id_usuario'], FILTER_SANITIZE_NUMBER_INT),
                'id_rol' => filter_var($datos['id_rol'], FILTER_SANITIZE_NUMBER_INT),
                'descripcion' => ucfirst(strtolower($datos['descripcion'])),
                'situacion' => 1
            ];

            // Usar sincronizar una sola vez con todos los datos
            $permiso->sincronizar($datosParaSincronizar);

            // Validaciones excluyendo el registro actual
            $validaciones = [
                function ($permiso) {
                    // Validar campos requeridos
                    if (empty($permiso->id_usuario)) return 'ID de usuario requerido';
                    if (empty($permiso->id_rol)) return 'ID de rol requerido';

                    // Validar descripción
                    if (strlen($permiso->descripcion) < 5) return 'Descripción debe tener más de 5 caracteres';
                    if (strlen($permiso->descripcion) > 255) return 'Descripción no puede exceder 255 caracteres';

                    // Validar unicidad excluyendo el registro actual
                    $sql   = "SELECT COUNT(*) FROM usuario_rol 
                    WHERE id_usuario = ? AND id_rol = ? AND situacion = 1 
                    AND id_usuario_rol != ?";
                    $total = Permisos::fetchScalar($sql, [
                        $permiso->id_usuario,
                        $permiso->id_rol,
                        $permiso->id_usuario_rol
                    ]);

                    if ($total > 0) {
                        return 'El usuario ya tiene asignado este rol';
                    }

                    // Validar que usuario exista
                    $sql    = "SELECT COUNT(*) FROM usuarios 
                                WHERE id_usuario = ? AND situacion = 1";
                    $exists = Permisos::fetchScalar($sql, [$permiso->id_usuario]);
                    if ($exists == 0) {
                        return 'El usuario seleccionado no existe o está inactivo';
                    }

                    // Validar que rol exista
                    $sql    = "SELECT COUNT(*) FROM roles 
                                WHERE id_rol = ? AND situacion = 1";
                    $exists = Permisos::fetchScalar($sql, [$permiso->id_rol]);
                    if ($exists == 0) {
                        return 'El rol seleccionado no existe o está inactivo';
                    }

                    return true;
                }
            ];

            // Actualizar con validaciones automáticas
            $permiso->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar permiso: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaPermiso()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            // Validar que llegue el ID
            if (empty($_POST['id_usuario_rol'])) {
                self::respuestaJSON(0, 'ID de asignación requerido', null, 400);
            }

            // Usamos el helper lógico para eliminar el permiso
            Permisos::eliminarLogicoConRespuesta($_POST['id_usuario_rol'], 'id_usuario_rol');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar permiso: ' . $e->getMessage(), null, 500);
        }
    }

    // Para cargar datos en selects
    public static function obtenerUsuarios()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $sql = "SELECT id_usuario, 
                    (nombre1 || ' ' || NVL(apellido1, '')) AS nombre_completo, 
                    correo 
                FROM usuarios 
                WHERE situacion = 1 
                ORDER BY nombre1, apellido1";

            // Usamos fetchArray para obtener arrays
            $usuarios = Permisos::fetchArray($sql);
            self::respuestaJSON(1, 'Usuarios encontrados', $usuarios);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener usuarios: ' . $e->getMessage(), null, 500);
        }
    }


    public static function obtenerRoles()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $sql = "SELECT id_rol, rol_nombre, descripcion 
                    FROM roles 
                    WHERE situacion = 1 
                    ORDER BY rol_nombre";

            $roles = Permisos::fetchArray($sql);
            self::respuestaJSON(1, 'Roles encontrados', $roles);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener roles: ' . $e->getMessage(), null, 500);
        }
    }
}
