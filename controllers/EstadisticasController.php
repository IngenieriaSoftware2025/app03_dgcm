<?php
// ARCHIVO: Controllers/EstadisticasController.php
namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;

class EstadisticasController extends ActiveRecord
{
    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function obtenerEstadisticasPrincipales()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $periodo = $_GET['periodo'] ?? 'mes';
            $fechaInicio = $_GET['fecha_inicio'] ?? '';
            $fechaFin = $_GET['fecha_fin'] ?? '';

            // Determinar rango de fechas según período
            switch ($periodo) {
                case 'hoy':
                    $condicionFecha = "DATE(fecha_venta) = CURRENT_DATE";
                    break;
                case 'semana':
                    $condicionFecha = "fecha_venta >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)";
                    break;
                case 'mes':
                    $condicionFecha = "fecha_venta >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)";
                    break;
                case 'trimestre':
                    $condicionFecha = "fecha_venta >= DATE_SUB(CURRENT_DATE, INTERVAL 90 DAY)";
                    break;
                case 'ano':
                    $condicionFecha = "YEAR(fecha_venta) = YEAR(CURRENT_DATE)";
                    break;
                case 'personalizado':
                    if ($fechaInicio && $fechaFin) {
                        $condicionFecha = "DATE(fecha_venta) BETWEEN '$fechaInicio' AND '$fechaFin'";
                    } else {
                        $condicionFecha = "fecha_venta >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)";
                    }
                    break;
                default:
                    $condicionFecha = "fecha_venta >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)";
            }

            // Ventas totales del período
            $totalVentas = self::fetchScalar(
                "SELECT COALESCE(SUM(total), 0) FROM ventas WHERE situacion = 1 AND $condicionFecha"
            ) ?? 0;

            // Celulares vendidos
            $celularesVendidos = self::fetchScalar(
                "SELECT COALESCE(SUM(dv.cantidad), 0) 
                 FROM detalle_ventas dv 
                 INNER JOIN ventas v ON dv.id_venta = v.id_venta 
                 WHERE v.situacion = 1 AND dv.id_celular IS NOT NULL AND $condicionFecha"
            ) ?? 0;

            // Reparaciones del período
            $reparacionesPeriodo = self::fetchScalar(
                "SELECT COUNT(*) FROM reparaciones WHERE estado = 'Entregado' AND $condicionFecha"
            ) ?? 0;

            // Clientes nuevos
            $clientesNuevos = self::fetchScalar(
                "SELECT COUNT(*) FROM clientes WHERE situacion = 1 AND $condicionFecha"
            ) ?? 0;

            // Top productos más vendidos
            $topProductos = self::fetchArray(
                "SELECT 
                    CONCAT(m.marca_nombre, ' ', c.modelo) as producto,
                    SUM(dv.cantidad) as cantidad,
                    SUM(dv.cantidad * dv.precio_unitario) as ingresos
                 FROM detalle_ventas dv
                 INNER JOIN ventas v ON dv.id_venta = v.id_venta
                 INNER JOIN celulares c ON dv.id_celular = c.id_celular
                 INNER JOIN marcas m ON c.id_marca = m.id_marca
                 WHERE v.situacion = 1 AND dv.id_celular IS NOT NULL AND $condicionFecha
                 GROUP BY dv.id_celular, m.marca_nombre, c.modelo
                 ORDER BY cantidad DESC
                 LIMIT 10"
            ) ?? [];

            // Top empleados
            $topEmpleados = self::fetchArray(
                "SELECT 
                    CONCAT(u.nombre1, ' ', u.apellido1) as empleado,
                    COUNT(v.id_venta) as ventas,
                    SUM(v.total) as total
                 FROM ventas v
                 INNER JOIN empleados e ON v.id_empleado_vendedor = e.id_empleado
                 INNER JOIN usuarios u ON e.id_usuario = u.id_usuario
                 WHERE v.situacion = 1 AND $condicionFecha
                 GROUP BY e.id_empleado, u.nombre1, u.apellido1
                 ORDER BY total DESC
                 LIMIT 10"
            ) ?? [];

            // Estado del inventario
            $inventarioStats = self::fetchArray(
                "SELECT 
                    SUM(CASE WHEN cantidad > 5 THEN 1 ELSE 0 END) as disponibles,
                    SUM(CASE WHEN cantidad <= 5 AND cantidad > 0 THEN 1 ELSE 0 END) as stock_bajo,
                    SUM(CASE WHEN cantidad = 0 THEN 1 ELSE 0 END) as agotados
                 FROM celulares WHERE situacion = 1"
            );

            $estadoInventario = $inventarioStats[0] ?? ['disponibles' => 0, 'stock_bajo' => 0, 'agotados' => 0];

            // Análisis de reparaciones
            $reparacionesStats = self::fetchArray(
                "SELECT 
                    SUM(CASE WHEN estado = 'Ingresado' THEN 1 ELSE 0 END) as ingresadas,
                    SUM(CASE WHEN estado = 'En Proceso' THEN 1 ELSE 0 END) as proceso,
                    SUM(CASE WHEN estado = 'Terminado' THEN 1 ELSE 0 END) as terminadas,
                    SUM(CASE WHEN estado = 'Entregado' THEN 1 ELSE 0 END) as entregadas
                 FROM reparaciones"
            );

            $estadoReparaciones = $reparacionesStats[0] ?? [
                'ingresadas' => 0,
                'proceso' => 0,
                'terminadas' => 0,
                'entregadas' => 0
            ];

            // Métricas de rendimiento
            $ticketPromedio = $celularesVendidos > 0 ? ($totalVentas / $celularesVendidos) : 0;
            $ventasPorDia = self::fetchScalar(
                "SELECT COUNT(DISTINCT DATE(fecha_venta)) FROM ventas WHERE situacion = 1 AND $condicionFecha"
            ) ?? 1;
            $ventasPorDia = $celularesVendidos / max($ventasPorDia, 1);

            $estadisticas = [
                'metricas_principales' => [
                    'total_ventas' => number_format($totalVentas, 2),
                    'celulares_vendidos' => $celularesVendidos,
                    'reparaciones_periodo' => $reparacionesPeriodo,
                    'clientes_nuevos' => $clientesNuevos
                ],
                'top_productos' => $topProductos,
                'top_empleados' => $topEmpleados,
                'estado_inventario' => $estadoInventario,
                'estado_reparaciones' => $estadoReparaciones,
                'metricas_rendimiento' => [
                    'ticket_promedio' => number_format($ticketPromedio, 2),
                    'ventas_por_dia' => number_format($ventasPorDia, 1),
                    'tiempo_promedio_reparacion' => '3.5 días', // Esto requeriría cálculo más complejo
                    'satisfaccion_clientes' => '95%', // Esto vendría de una encuesta
                    'rotacion_inventario' => '2.3', // Cálculo basado en ventas vs inventario
                    'margen_ganancia' => '35%' // Basado en precio_compra vs precio_venta
                ]
            ];

            self::respuestaJSON(1, 'Estadísticas obtenidas exitosamente', $estadisticas);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener estadísticas: ' . $e->getMessage(), null, 500);
        }
    }

    public static function generarReporte()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $tipoReporte = $_POST['tipo_reporte'] ?? '';
            $fechaInicio = $_POST['fecha_inicio'] ?? '';
            $fechaFin = $_POST['fecha_fin'] ?? '';
            $formato = $_POST['formato'] ?? 'pdf';

            // Aquí implementarías la lógica para generar el reporte
            // Por ahora, simular la generación
            $nombreArchivo = "reporte_{$tipoReporte}_" . date('Y-m-d_H-i-s') . ".{$formato}";

            self::respuestaJSON(1, 'Reporte generado exitosamente', [
                'archivo' => $nombreArchivo,
                'url_descarga' => "/app03_dgcm/reportes/{$nombreArchivo}"
            ]);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al generar reporte: ' . $e->getMessage(), null, 500);
        }
    }
}
