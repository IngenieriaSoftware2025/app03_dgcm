<?php

namespace Controllers;

use Model\Roles;
use MVC\Router;

class RolesController
{

    public static function mostrarPagina(Router $router)
    {
        $roles = Roles::obtenerRolesActivos();

        $router->render(
            'roles/index',
            [],
            'layouts/layout'
        );
    }

    // Busca un rol 
    public static function buscaRol(Router $router)
    {

        $id = $_GET['id'] ?? '';
        $rol = null;

        if ($id) {
            $rol = Roles::find($id);
        }

        echo json_encode($rol);
    }

    // Guarda un rol
    public static function guardarRol(Router $router)
    {
        $rol = new Roles($_POST['id_rol']);
        $rol->sincronizar($_POST);

        // Validar el rol
        $alertas = $rol->validarRolUnico();

        if (empty($alertas)) {
            $resultado = $rol->guardar();

            if ($resultado['resultado']) {
                echo json_encode([
                    'resultado' => true,
                    'mensaje' => 'Rol guardado correctamente',
                    'rol' => $rol
                ]);
            } else {
                echo json_encode([
                    'resultado' => false,
                    'mensaje' => 'Error al guardar el rol',
                    'alertas' => $rol->getAlertas()
                ]);
            }
        } else {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'Error al guardar el rol',
                'alertas' => $alertas
            ]);
        }
    }

    // Modifica un rol
    public static function modificarRol(Router $router)
    {
        $rol = new Roles($_POST['id_rol']);
        $rol->sincronizar($_POST);

        // Validar el rol
        $alertas = $rol->validarRolUnico();

        if (empty($alertas)) {
            $resultado = $rol->guardar();
            if ($resultado['resultado']) {
                echo json_encode([
                    'resultado' => true,
                    'mensaje' => 'Rol modificado correctamente',
                    'rol' => $rol
                ]);
            } else {
                echo json_encode([
                    'resultado' => false,
                    'mensaje' => 'Error al modificar el rol',
                    'alertas' => $rol->getAlertas()
                ]);
            }
        } else {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'Error al modificar el rol',
                'alertas' => $alertas
            ]);
        }
    }

    // Elimina un rol
    public static function eliminarRol(Router $router)
    {
        $rol = new Roles($_POST['id_rol']);
        $rol->situacion = 0;
        $resultado = $rol->guardar();

        if ($resultado['resultado']) {
            echo json_encode([
                'resultado' => true,
                'mensaje' => 'Rol eliminado correctamente',
                'rol' => $rol
            ]);
        } else {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'Error al eliminar el rol',
                'alertas' => $rol->getAlertas()
            ]);
        }
    }

    // Roles activos
    public static function obtenerRolesActivos(Router $router)
    {
        $roles =  Roles::obtenerRolesActivos();
        echo json_encode($roles);
    }
}
