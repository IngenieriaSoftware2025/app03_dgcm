<?php
// ARCHIVO: Controllers/AdminController.php
namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Usuarios;
use Model\Ventas;
use Model\Celulares;
use Model\Reparaciones;

class AdminController extends ActiveRecord
{
    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function dashboard(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }

        try {
            // Estadísticas para el dashboard
            $usuariosCount = self::fetchScalar("SELECT COUNT(*) FROM usuarios WHERE situacion = 1") ?? 0;
            $ventasHoy = self::fetchScalar("SELECT COALESCE(SUM(total), 0) FROM ventas WHERE DATE(fecha_venta) = CURRENT_DATE") ?? 0;
            $cantidadVentasHoy = self::fetchScalar("SELECT COUNT(*) FROM ventas WHERE DATE(fecha_venta) = CURRENT_DATE") ?? 0;
            $inventarioCount = self::fetchScalar("SELECT COUNT(*) FROM celulares WHERE situacion = 1") ?? 0;
            $stockBajo = self::fetchScalar("SELECT COUNT(*) FROM celulares WHERE cantidad < 5 AND situacion = 1") ?? 0;
            $reparacionesPendientes = self::fetchScalar("SELECT COUNT(*) FROM reparaciones WHERE estado IN ('Ingresado', 'En Proceso')") ?? 0;

            // Actividad reciente
            $actividadReciente = self::fetchArray("
                SELECT 'Venta' as tipo, 
                    CONCAT('Venta #', id_venta, ' por Q.', total) as descripcion,
                    'usuario' as usuario,
                    fecha_venta as tiempo
                FROM ventas 
                WHERE DATE(fecha_venta) = CURRENT_DATE
                ORDER BY fecha_venta DESC 
                LIMIT 8
            ") ?? [];

            // Alertas del sistema
            $alertasSistema = [];
            if ($stockBajo > 0) {
                $alertasSistema[] = [
                    'tipo' => 'warning',
                    'icono' => 'exclamation-triangle',
                    'mensaje' => "$stockBajo productos con stock bajo",
                    'fecha' => date('Y-m-d H:i')
                ];
            }

            $router->render('admin/dashboard/index', [
                'title' => 'Panel Administrativo',
                'usuariosCount' => $usuariosCount,
                'ventasHoy' => $ventasHoy,
                'cantidadVentasHoy' => $cantidadVentasHoy,
                'inventarioCount' => $inventarioCount,
                'stockBajo' => $stockBajo,
                'reparacionesPendientes' => $reparacionesPendientes,
                'actividadReciente' => $actividadReciente,
                'alertasSistema' => $alertasSistema
            ], 'admin_layout');
        } catch (Exception $e) {
            $router->render('admin/dashboard/index', [
                'title' => 'Panel Administrativo',
                'usuariosCount' => 0,
                'ventasHoy' => 0,
                'cantidadVentasHoy' => 0,
                'inventarioCount' => 0,
                'stockBajo' => 0,
                'reparacionesPendientes' => 0,
                'actividadReciente' => [],
                'alertasSistema' => []
            ], 'admin_layout');
        }
    }

    public static function usuarios(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/usuarios/index', ['title' => 'Gestión de Usuarios'], 'admin_layout');
    }

    public static function marcas(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/marcas/index', ['title' => 'Gestión de Marcas'], 'admin_layout');
    }

    public static function roles(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/roles/index', ['title' => 'Gestión de Roles'], 'admin_layout');
    }

    public static function permisos(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/permisos/index', ['title' => 'Gestión de Permisos'], 'admin_layout');
    }

    public static function clientes(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/clientes/index', ['title' => 'Gestión de Clientes'], 'admin_layout');
    }

    public static function celulares(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/celulares/index', ['title' => 'Gestión de Inventario'], 'admin_layout');
    }

    public static function ventas(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/ventas/index', ['title' => 'Gestión de Ventas'], 'admin_layout');
    }

    public static function reparaciones(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/reparaciones/index', ['title' => 'Gestión de Reparaciones'], 'admin_layout');
    }

    public static function estadisticas(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/login');
            exit;
        }
        $router->render('admin/estadisticas/index', ['title' => 'Estadísticas y Reportes'], 'admin_layout');
    }
}
