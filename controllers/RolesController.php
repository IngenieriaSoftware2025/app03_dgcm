<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\Roles;
use Model\ActiveRecord;

class RolesController extends ActiveRecord
{

    public static function mostrarPagina(Router $router)
    {
        $router->render('roles/roles', [], 'layout');
    }

    public static function guardarRol()
    {
        try {
            // Validar campos requeridos usando helper
            $validacion = self::validarRequeridos($_POST, [
                'rol_nombre'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            // Sanitizar datos usando helper
            $datos = self::sanitizarDatos($_POST);

            // Crear rol con validaciones personalizadas
            $rol = new Roles([
                'rol_nombre' => ucwords(strtolower($datos['rol_nombre'])),
                'descripcion' => $datos['descripcion'] ?? '',
                'situacion' => 1
            ]);

            // Definir validaciones específicas de rol
            $validaciones = [
                // Validar longitud de rol_nombre
                function ($rol) {
                    if (strlen($rol->rol_nombre) < 3) {
                        return 'Nombre de rol debe tener más de 2 caracteres';
                    }
                    return true;
                },
                function ($rol) {
                    if (Roles::valorExiste('rol_nombre', $rol->rol_nombre)) {
                        return 'El nombre del rol ya está registrado en el sistema';
                    }
                    return true;
                }
            ];

            // Crear con validaciones y respuesta automática
            $rol->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar rol: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaRol()
    {
        // Usando el helper para buscar Roles activos
        Roles::buscarConRespuesta("situacion = 1", "rol_nombre, descripcion");
    }

    public static function modificaRol()
    {
        try {

            // Validar que llegue el ID
            if (empty($_POST['id_rol'])) {
                self::respuestaJSON(0, 'ID de rol requerido', null, 400);
            }

            $id = $_POST['id_rol'];

            // Buscar rol existente
            $rol = Roles::find(['id_rol' => $id]);
            if (!$rol) {
                self::respuestaJSON(0, 'rol no encontrado', null, 404);
            }

            // Sanitizar nuevos datos
            $datos = self::sanitizarDatos($_POST);

            // Preparar TODOS los datos para sincronizar
            $datosParaSincronizar = [
                'rol_nombre' => ucwords(strtolower($datos['rol_nombre'])),
                'descripcion' => $datos['descripcion'] ?? ''
            ];

            $rol->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($validar) {
                    if (strlen($validar->rol_nombre) < 3) {
                        return 'El nombre del rol debe tener más de 2 caracteres';
                    }
                    if (Roles::valorExiste('rol_nombre', $validar->rol_nombre, $validar->id_rol, 'id_rol')) {
                        return 'El nombre del rol ya está en uso por otro rol';
                    }
                    return true;
                }
            ];
            // Actualizar con validaciones automáticas
            $rol->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar rol: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaRol()
    {
        try {
            if (empty($_POST['id_rol'])) {
                self::respuestaJSON(0, 'ID de rol requerido', null, 400);
            }
            // Usamos el helper logico para eliminar el rol
            Roles::eliminarLogicoConRespuesta($_POST['id_rol'], 'id_rol');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar rol: ' . $e->getMessage(), null, 500);
        }
    }
}
