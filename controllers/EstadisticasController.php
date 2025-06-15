<?php

namespace Controllers;

use MVC\Router;
use Model\Clientes;
use Model\Ventas;
use Model\Reparaciones;
use Model\Celulares;
use Model\DetalleVentas;
use Model\TiposServicios;
use Model\Marcas;

class EstadisticasController
{
    public static function index(Router $router)
    {
        $router->render('estadisticas/index', [], 'layout');
    }

    public static function obtenerDatos()
    {
        $totalClientes = Clientes::SQL("SELECT COUNT(*) AS total FROM clientes")->fetch(PDO::FETCH_ASSOC)['total'];
        $totalVentas = Ventas::SQL("SELECT COUNT(*) AS total FROM ventas")->fetch(PDO::FETCH_ASSOC)['total'];
        $totalReparaciones = Reparaciones::SQL("SELECT COUNT(*) AS total FROM reparaciones")->fetch(PDO::FETCH_ASSOC)['total'];
        $totalInventario = Celulares::SQL("SELECT SUM(stock_actual) AS total FROM celulares")->fetch(PDO::FETCH_ASSOC)['total'];

        $ingresosVentas = Ventas::SQL("SELECT COALESCE(SUM(total), 0) AS total FROM ventas")->fetch(PDO::FETCH_ASSOC)['total'];
        $ingresosReparaciones = Ventas::SQL("SELECT COALESCE(SUM(total), 0) AS total FROM ventas WHERE tipo_venta = 'R'")->fetch(PDO::FETCH_ASSOC)['total'];

        $respuesta = [
            'clientes' => $totalClientes,
            'ventas' => $totalVentas,
            'reparaciones' => $totalReparaciones,
            'inventario' => $totalInventario,
            'ingresosVentas' => $ingresosVentas,
            'ingresosReparaciones' => $ingresosReparaciones,
        ];

        header('Content-Type: application/json');
        echo json_encode(['codigo' => 1, 'data' => $respuesta]);
    }
}
