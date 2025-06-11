<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;

class EmpleadoController extends ActiveRecord
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

        // Verificar que el usuario sea empleado
        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'empleado') {
            header('Location: /app03_dgcm/login');
            exit;
        }

        try {
            // Obtener estadísticas para el dashboard
            $productosCount = self::obtenerConteo('productos', 'situacion = 1');
            $categoriasCount = self::obtenerConteo('categorias', 'situacion = 1');
            $pedidosCount = self::obtenerConteo('pedidos', 'situacion = 1');
            $clientesCount = self::obtenerConteo('usuarios', 'rol = "cliente" AND situacion = 1');

            // Obtener estadísticas adicionales
            $ventasHoy = self::obtenerVentasHoy();
            $productosStock = self::obtenerProductosEnStock();
            $pedidosPendientes = self::obtenerConteo('pedidos', 'estado = "pendiente"');
            $clientesActivos = self::obtenerConteo('usuarios', 'rol = "cliente" AND situacion = 1');

            // Obtener últimos pedidos
            $ultimosPedidos = self::obtenerUltimosPedidos();

            $router->render('dashboard/empleado', [
                'title' => 'Panel Empleado',
                'productosCount' => $productosCount,
                'categoriasCount' => $categoriasCount,
                'pedidosCount' => $pedidosCount,
                'clientesCount' => $clientesCount,
                'ventasHoy' => $ventasHoy,
                'productosStock' => $productosStock,
                'pedidosPendientes' => $pedidosPendientes,
                'clientesActivos' => $clientesActivos,
                'ultimosPedidos' => $ultimosPedidos
            ], 'empleado');
        } catch (Exception $e) {
            $router->render('dashboard/empleado', [
                'title' => 'Panel Empleado',
                'productosCount' => 0,
                'categoriasCount' => 0,
                'pedidosCount' => 0,
                'clientesCount' => 0,
                'ventasHoy' => 0,
                'productosStock' => 0,
                'pedidosPendientes' => 0,
                'clientesActivos' => 0,
                'ultimosPedidos' => []
            ], 'empleado');
        }
    }

    public static function productos(Router $router)
    {
        self::initSession();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'empleado') {
            header('Location: /app03_dgcm/login');
            exit;
        }

        $router->render('empleado/productos', [
            'title' => 'Gestión de Productos'
        ], 'empleado');
    }

    public static function categorias(Router $router)
    {
        self::initSession();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'empleado') {
            header('Location: /app03_dgcm/login');
            exit;
        }

        $router->render('empleado/categorias', [
            'title' => 'Gestión de Categorías'
        ], 'empleado');
    }

    public static function pedidos(Router $router)
    {
        self::initSession();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'empleado') {
            header('Location: /app03_dgcm/login');
            exit;
        }

        $router->render('empleado/pedidos', [
            'title' => 'Gestión de Pedidos'
        ], 'empleado');
    }

    public static function clientes(Router $router)
    {
        self::initSession();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'empleado') {
            header('Location: /app03_dgcm/login');
            exit;
        }

        $router->render('empleado/clientes', [
            'title' => 'Gestión de Clientes'
        ], 'empleado');
    }

    public static function perfil(Router $router)
    {
        self::initSession();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'empleado') {
            header('Location: /app03_dgcm/login');
            exit;
        }

        $router->render('empleado/perfil', [
            'title' => 'Mi Perfil'
        ], 'empleado');
    }

    // Métodos auxiliares para estadísticas
    private static function obtenerConteo($tabla, $condicion = '1=1')
    {
        try {
            $sql = "SELECT COUNT(*) FROM {$tabla} WHERE {$condicion}";
            return self::fetchScalar($sql) ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    private static function obtenerVentasHoy()
    {
        try {
            $sql = "SELECT COUNT(*) FROM pedidos WHERE DATE(fecha_creacion) = CURDATE() AND estado = 'completado'";
            return self::fetchScalar($sql) ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    private static function obtenerProductosEnStock()
    {
        try {
            $sql = "SELECT COUNT(*) FROM productos WHERE stock > 0 AND situacion = 1";
            return self::fetchScalar($sql) ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    private static function obtenerUltimosPedidos()
    {
        try {
            $sql = "SELECT p.id_pedido as id, 
                        CONCAT(u.nombre1, ' ', u.apellido1) as cliente_nombre,
                        p.total,
                        p.fecha_creacion
                    FROM pedidos p 
                    INNER JOIN usuarios u ON p.id_usuario = u.id_usuario 
                    WHERE p.situacion = 1 
                    ORDER BY p.fecha_creacion DESC 
                    LIMIT 10";

            return self::fetchArray($sql) ?? [];
        } catch (Exception $e) {
            return [];
        }
    }
}
