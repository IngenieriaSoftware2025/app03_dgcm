<?php

namespace Controllers;

use Model\Ventas;
use Model\Productos;
use Model\Clientes;
use MVC\Router;
use Model\ActiveRecord;

class GraficasController extends ActiveRecord
{
    public static function renderizarGraficas(Router $router)
    {
        $router->render('graficas/index', []);
    }

    public static function obtenerDatosGraficas()
    {
        getHeadersApi();
        try {
            // Consulta de productos más vendidos
            $sqlProductos = "SELECT producto_id, producto_nombre, SUM(cantidad) AS cantidad_total
                             FROM detalle_ventas
                             GROUP BY producto_id
                             ORDER BY cantidad_total DESC";
            $productos = self::fetchArray($sqlProductos);

            // Consulta de ventas por mes
            $sqlVentasMeses = "SELECT YEAR(fecha_venta) as anio, MONTH(fecha_venta) as mes, SUM(total) as ingresos
                               FROM ventas
                               GROUP BY anio, mes
                               ORDER BY anio DESC, mes DESC";
            $ventasMeses = self::fetchArray($sqlVentasMeses);

            // Consulta de clientes con más productos comprados
            $sqlClientes = "SELECT c.cliente_nombre, SUM(dv.cantidad) as total_productos
                            FROM detalle_ventas dv
                            INNER JOIN clientes c ON dv.id_cliente = c.id_cliente
                            GROUP BY c.id_cliente
                            ORDER BY total_productos DESC";
            $clientes = self::fetchArray($sqlClientes);

            echo json_encode([
                'codigo' => 1,
                'productos' => $productos,
                'ventasMeses' => $ventasMeses,
                'clientes' => $clientes
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los datos de gráficas',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}
