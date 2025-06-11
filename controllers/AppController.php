<?php

namespace Controllers;

use MVC\Router;

class AppController
{
    public static function index(Router $router)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Si no hay sesión, mostrar página de inicio o login
        if (!isset($_SESSION['user'])) {
            header('Location: /app03_dgcm/tienda');
            exit;
        }

        // Si ya está logueado, mostrar dashboard según rol
        $rol = $_SESSION['user']['rol'] ?? '';
        $usuario = $_SESSION['user'];

        switch ($rol) {
            case 'administrador':
                $router->render('dashboard/admin', [
                    'titulo' => 'Panel Administrativo',
                    'usuario' => $usuario
                ], 'layout');
                break;

            case 'empleado':
                $router->render('dashboard/empleado', [
                    'titulo' => 'Panel Empleado',
                    'usuario' => $usuario
                ], 'empleado');
                break;

            case 'cliente':
                $router->render('dashboard/cliente', [
                    'titulo' => 'Panel Cliente',
                    'usuario' => $usuario
                ], 'cliente');
                break;

            default:
                $router->render('inicio/index', [], 'layout');
                break;
        }
    }
}
