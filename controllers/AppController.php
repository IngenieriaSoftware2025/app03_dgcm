<?php

namespace Controllers;

use MVC\Router;

class AppController
{
    public static function index(Router $router)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Si no hay sesión, mostrar tienda pública
        if (!isset($_SESSION['user'])) {
            header('Location: /app03_dgcm/tienda');
            exit;
        }

        // Si ya está logueado, dashboard según rol
        $rol = $_SESSION['user']['rol'] ?? '';
        switch ($rol) {
            case 'administrador':
                header('Location: /app03_dgcm/admin');
                break;
            case 'empleado':
                header('Location: /app03_dgcm/empleado');
                break;
            case 'cliente':
                header('Location: /app03_dgcm/tienda');
                break;
            default:
                header('Location: /app03_dgcm/tienda');
                break;
        }
        exit;
    }
}
