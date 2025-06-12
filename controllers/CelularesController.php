<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\Celulares;
use Model\ActiveRecord;

class CelularesController extends ActiveRecord
{
    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // MÉTODOS DE VISTAS
    public static function mostrarPaginaAdmin(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            header('Location: /app03_dgcm/tienda');
            exit;
        }
        $router->render('admin/celulares/index', [], 'admin_layout');
    }

    public static function mostrarPaginaEmpleado(Router $router)
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            header('Location: /app03_dgcm/tienda');
            exit;
        }
        $router->render('empleado/celulares/index', [], 'empleado_layout');
    }

    public static function mostrarPaginaTienda(Router $router)
    {
        $router->render('tienda/categoria', [
            'titulo' => 'Catálogo de Celulares'
        ], 'tienda_layout');
    }

    // MÉTODOS ADMINISTRATIVOS
    public static function guardarCelular()
    {
        self::initSession();
        // if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
        //     self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
        //     return;
        // }

        try {
            $validacion = self::validarRequeridos($_POST, ['id_marca', 'modelo', 'precio_venta']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $celular = new Celulares([
                'id_marca' => filter_var($datos['id_marca'], FILTER_SANITIZE_NUMBER_INT),
                'modelo' => ucwords(strtolower($datos['modelo'])),
                'descripcion' => $datos['descripcion'] ?? '',
                'precio_compra' => filter_var($datos['precio_compra'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'precio_venta' => filter_var($datos['precio_venta'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'cantidad' => filter_var($datos['cantidad'] ?? 0, FILTER_SANITIZE_NUMBER_INT),
                'situacion' => $datos['situacion'] ?? 1
            ]);

            $validaciones = [
                function ($celular) {
                    if (strlen($celular->modelo) < 2) {
                        return 'El modelo debe tener más de 2 caracteres';
                    }
                    if ($celular->precio_venta <= 0) {
                        return 'El precio de venta debe ser mayor a 0';
                    }
                    if ($celular->precio_compra < 0) {
                        return 'El precio de compra no puede ser negativo';
                    }
                    if ($celular->cantidad < 0) {
                        return 'La cantidad no puede ser negativa';
                    }

                    // Verificar que la marca exista
                    $marcaExiste = self::fetchScalar("SELECT COUNT(*) FROM marcas WHERE id_marca = ? AND situacion = 1", [$celular->id_marca]);
                    if (!$marcaExiste) {
                        return 'La marca seleccionada no existe o está inactiva';
                    }

                    // Verificar modelo único por marca
                    $modeloExiste = self::fetchScalar(
                        "SELECT COUNT(*) FROM celulares WHERE id_marca = ? AND LOWER(modelo) = LOWER(?) AND situacion = 1",
                        [$celular->id_marca, $celular->modelo]
                    );
                    if ($modeloExiste) {
                        return 'Ya existe un celular con este modelo para esta marca';
                    }

                    return true;
                }
            ];

            $celular->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar celular: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaCelular()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        Celulares::buscarConMultiplesRelaciones(
            [
                'marca' => [
                    'tabla' => 'marcas',
                    'llave_local' => 'id_marca',
                    'llave_foranea' => 'id_marca',
                    'tipo' => 'INNER',
                    'campos' => [
                        'marca_nombre' => 'marca_nombre'
                    ]
                ]
            ],
            "celulares.situacion = 1",
            "marcas.marca_nombre, celulares.modelo"
        );
    }

    public static function modificaCelular()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_celular'])) {
                self::respuestaJSON(0, 'ID de celular requerido', null, 400);
            }

            $celular = Celulares::find(['id_celular' => $_POST['id_celular']]);
            if (!$celular) {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $celular->sincronizar([
                'id_marca' => filter_var($datos['id_marca'], FILTER_SANITIZE_NUMBER_INT),
                'modelo' => ucwords(strtolower($datos['modelo'])),
                'descripcion' => $datos['descripcion'] ?? '',
                'precio_compra' => filter_var($datos['precio_compra'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'precio_venta' => filter_var($datos['precio_venta'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'cantidad' => filter_var($datos['cantidad'] ?? 0, FILTER_SANITIZE_NUMBER_INT),
                'situacion' => $datos['situacion'] ?? 1
            ]);

            $validaciones = [
                function ($celular) {
                    if (strlen($celular->modelo) < 2) {
                        return 'El modelo debe tener más de 2 caracteres';
                    }
                    if ($celular->precio_venta <= 0) {
                        return 'El precio de venta debe ser mayor a 0';
                    }
                    if ($celular->precio_compra < 0) {
                        return 'El precio de compra no puede ser negativo';
                    }
                    if ($celular->cantidad < 0) {
                        return 'La cantidad no puede ser negativa';
                    }

                    $marcaExiste = self::fetchScalar("SELECT COUNT(*) FROM marcas WHERE id_marca = ? AND situacion = 1", [$celular->id_marca]);
                    if (!$marcaExiste) {
                        return 'La marca seleccionada no existe o está inactiva';
                    }

                    // Verificar modelo único excluyendo el actual
                    $modeloExiste = self::fetchScalar(
                        "SELECT COUNT(*) FROM celulares WHERE id_marca = ? AND LOWER(modelo) = LOWER(?) AND id_celular != ? AND situacion = 1",
                        [$celular->id_marca, $celular->modelo, $celular->id_celular]
                    );
                    if ($modeloExiste) {
                        return 'Ya existe otro celular con este modelo para esta marca';
                    }

                    return true;
                }
            ];

            $celular->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar celular: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaCelular()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_celular'])) {
                self::respuestaJSON(0, 'ID de celular requerido', null, 400);
            }

            // Verificar si tiene ventas asociadas
            $ventasCount = self::fetchScalar(
                "SELECT COUNT(*) FROM detalle_ventas WHERE id_celular = ?",
                [$_POST['id_celular']]
            ) ?? 0;

            if ($ventasCount > 0) {
                self::respuestaJSON(0, "No se puede eliminar: el celular tiene $ventasCount ventas asociadas", null, 400);
                return;
            }

            Celulares::eliminarLogicoConRespuesta($_POST['id_celular'], 'id_celular');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar celular: ' . $e->getMessage(), null, 500);
        }
    }

    public static function ajustarStock()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $validacion = self::validarRequeridos($_POST, ['id_celular', 'tipo_movimiento', 'cantidad']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $celular = Celulares::find(['id_celular' => $_POST['id_celular']]);
            if (!$celular) {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }

            $cantidad = (int)$_POST['cantidad'];
            $tipo = $_POST['tipo_movimiento'];
            $stockActual = (int)$celular->cantidad;

            switch ($tipo) {
                case 'entrada':
                    $nuevoStock = $stockActual + $cantidad;
                    break;
                case 'salida':
                    if ($cantidad > $stockActual) {
                        self::respuestaJSON(0, 'No hay suficiente stock para la salida', null, 400);
                        return;
                    }
                    $nuevoStock = $stockActual - $cantidad;
                    break;
                case 'ajuste':
                    $nuevoStock = $cantidad;
                    break;
                default:
                    self::respuestaJSON(0, 'Tipo de movimiento inválido', null, 400);
                    return;
            }

            // Actualizar stock
            $celular->cantidad = $nuevoStock;
            $resultado = $celular->actualizar();

            if ($resultado['resultado']) {
                self::respuestaJSON(1, 'Stock actualizado correctamente', [
                    'stock_anterior' => $stockActual,
                    'stock_nuevo' => $nuevoStock,
                    'tipo_movimiento' => $tipo,
                    'cantidad_movida' => $cantidad
                ]);
            } else {
                self::respuestaJSON(0, 'Error al actualizar el stock', null, 400);
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al ajustar stock: ' . $e->getMessage(), null, 500);
        }
    }

    // MÉTODOS PARA EMPLEADOS
    public static function buscaCelularEmpleado()
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            self::respuestaJSON(0, 'Acceso denegado', null, 403);
            return;
        }

        Celulares::buscarConMultiplesRelaciones(
            [
                'marca' => [
                    'tabla' => 'marcas',
                    'llave_local' => 'id_marca',
                    'llave_foranea' => 'id_marca',
                    'tipo' => 'INNER',
                    'campos' => [
                        'marca_nombre' => 'marca_nombre'
                    ]
                ]
            ],
            "celulares.situacion = 1",
            "marcas.marca_nombre, celulares.modelo"
        );
    }

    // MÉTODOS PÚBLICOS PARA TIENDA
    public static function obtenerCelularesDisponibles()
    {
        try {
            $sql = "SELECT c.id_celular, c.modelo, c.descripcion, c.precio_venta, c.cantidad, m.marca_nombre, m.id_marca
                    FROM celulares c
                    INNER JOIN marcas m ON c.id_marca = m.id_marca
                    WHERE c.situacion = 1 AND m.situacion = 1 AND c.cantidad > 0
                    ORDER BY m.marca_nombre, c.modelo";

            $celulares = self::fetchArray($sql);
            self::respuestaJSON(1, 'Celulares disponibles encontrados', $celulares);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener celulares: ' . $e->getMessage(), null, 500);
        }
    }

    public static function obtenerCelularesTienda()
    {
        try {
            $sql = "SELECT c.id_celular, c.modelo, c.descripcion, c.precio_venta, c.cantidad, 
                    m.marca_nombre, m.id_marca
                    FROM celulares c
                    INNER JOIN marcas m ON c.id_marca = m.id_marca
                    WHERE c.situacion = 1 AND m.situacion = 1
                    ORDER BY m.marca_nombre, c.modelo";

            $celulares = self::fetchArray($sql);
            self::respuestaJSON(1, 'Catálogo de celulares obtenido', $celulares);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener catálogo: ' . $e->getMessage(), null, 500);
        }
    }

    public static function obtenerCelularPorId()
    {
        try {
            if (empty($_GET['id'])) {
                self::respuestaJSON(0, 'ID de celular requerido', null, 400);
            }

            $sql = "SELECT c.*, m.marca_nombre
                    FROM celulares c
                    INNER JOIN marcas m ON c.id_marca = m.id_marca
                    WHERE c.id_celular = ? AND c.situacion = 1 AND m.situacion = 1";

            $celular = self::fetchArray($sql, [$_GET['id']]);

            if ($celular && count($celular) > 0) {
                self::respuestaJSON(1, 'Celular encontrado', $celular[0]);
            } else {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener celular: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarCelularesTienda()
    {
        try {
            $busqueda = $_GET['q'] ?? '';
            $marca = $_GET['marca'] ?? '';
            $precioMin = $_GET['precio_min'] ?? '';
            $precioMax = $_GET['precio_max'] ?? '';

            $condiciones = ["c.situacion = 1", "m.situacion = 1"];
            $parametros = [];

            if (!empty($busqueda)) {
                $condiciones[] = "(LOWER(c.modelo) LIKE LOWER(?) OR LOWER(m.marca_nombre) LIKE LOWER(?) OR LOWER(c.descripcion) LIKE LOWER(?))";
                $busquedaParam = "%$busqueda%";
                $parametros[] = $busquedaParam;
                $parametros[] = $busquedaParam;
                $parametros[] = $busquedaParam;
            }

            if (!empty($marca)) {
                $condiciones[] = "m.id_marca = ?";
                $parametros[] = $marca;
            }

            if (!empty($precioMin)) {
                $condiciones[] = "c.precio_venta >= ?";
                $parametros[] = $precioMin;
            }

            if (!empty($precioMax)) {
                $condiciones[] = "c.precio_venta <= ?";
                $parametros[] = $precioMax;
            }

            $whereClause = implode(' AND ', $condiciones);

            $sql = "SELECT c.id_celular, c.modelo, c.descripcion, c.precio_venta, c.cantidad, 
                    m.marca_nombre, m.id_marca
                    FROM celulares c
                    INNER JOIN marcas m ON c.id_marca = m.id_marca
                    WHERE $whereClause
                    ORDER BY m.marca_nombre, c.modelo";

            $stmt = self::$db->prepare($sql);
            $stmt->execute($parametros);
            $celulares = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Convertir encoding
            $data = [];
            foreach ($celulares as $celular) {
                $data[] = array_map(function ($item) {
                    return mb_convert_encoding($item ?? '', 'UTF-8', 'ISO-8859-1');
                }, $celular);
            }

            self::respuestaJSON(1, 'Búsqueda completada', $data);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error en búsqueda: ' . $e->getMessage(), null, 500);
        }
    }

    //MÉTODOS DE ESTADÍSTICAS
    public static function obtenerEstadisticasInventario()
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            self::respuestaJSON(0, 'Acceso denegado', null, 403);
            return;
        }

        try {
            $sql = "SELECT 
                        COUNT(*) as total_productos,
                        SUM(CASE WHEN cantidad > 0 THEN 1 ELSE 0 END) as productos_disponibles,
                        SUM(CASE WHEN cantidad = 0 THEN 1 ELSE 0 END) as productos_agotados,
                        SUM(CASE WHEN cantidad > 0 AND cantidad <= 5 THEN 1 ELSE 0 END) as productos_stock_bajo,
                        SUM(cantidad) as total_unidades,
                        SUM(precio_venta * cantidad) as valor_total_inventario
                    FROM celulares 
                    WHERE situacion = 1";

            $estadisticas = self::fetchFirst($sql);
            self::respuestaJSON(1, 'Estadísticas obtenidas', $estadisticas);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener estadísticas: ' . $e->getMessage(), null, 500);
        }
    }

    public static function obtenerProductosMasVendidos()
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            self::respuestaJSON(0, 'Acceso denegado', null, 403);
            return;
        }

        try {
            $sql = "SELECT c.modelo, m.marca_nombre, SUM(dv.cantidad) as total_vendido
                    FROM detalle_ventas dv
                    INNER JOIN celulares c ON dv.id_celular = c.id_celular
                    INNER JOIN marcas m ON c.id_marca = m.id_marca
                    INNER JOIN ventas v ON dv.id_venta = v.id_venta
                    WHERE v.situacion = 1 AND c.situacion = 1
                    GROUP BY c.id_celular, c.modelo, m.marca_nombre
                    ORDER BY total_vendido DESC
                    LIMIT 10";

            $productos = self::fetchArray($sql);
            self::respuestaJSON(1, 'Productos más vendidos obtenidos', $productos);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener productos más vendidos: ' . $e->getMessage(), null, 500);
        }
    }

    // MÉTODOS AUXILIARES
    public static function verificarStock()
    {
        try {
            if (empty($_POST['id_celular']) || empty($_POST['cantidad_solicitada'])) {
                self::respuestaJSON(0, 'Parámetros requeridos: id_celular, cantidad_solicitada', null, 400);
            }

            $celular = Celulares::find(['id_celular' => $_POST['id_celular']]);
            if (!$celular) {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }

            $cantidadSolicitada = (int)$_POST['cantidad_solicitada'];
            $stockDisponible = (int)$celular->cantidad;

            $respuesta = [
                'stock_disponible' => $stockDisponible,
                'cantidad_solicitada' => $cantidadSolicitada,
                'suficiente_stock' => $stockDisponible >= $cantidadSolicitada,
                'modelo' => $celular->modelo
            ];

            if ($stockDisponible >= $cantidadSolicitada) {
                self::respuestaJSON(1, 'Stock suficiente', $respuesta);
            } else {
                self::respuestaJSON(0, 'Stock insuficiente', $respuesta, 400);
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al verificar stock: ' . $e->getMessage(), null, 500);
        }
    }

    public static function reducirStock()
    {
        self::initSession();
        if (!in_array($_SESSION['user']['rol'] ?? null, ['administrador', 'empleado'])) {
            self::respuestaJSON(0, 'Acceso denegado', null, 403);
            return;
        }

        try {
            $validacion = self::validarRequeridos($_POST, ['id_celular', 'cantidad']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $celular = Celulares::find(['id_celular' => $_POST['id_celular']]);
            if (!$celular) {
                self::respuestaJSON(0, 'Celular no encontrado', null, 404);
            }

            $cantidadReducir = (int)$_POST['cantidad'];
            $stockActual = (int)$celular->cantidad;

            if ($cantidadReducir > $stockActual) {
                self::respuestaJSON(0, 'No hay suficiente stock disponible', null, 400);
                return;
            }

            $nuevoStock = $stockActual - $cantidadReducir;
            $celular->cantidad = $nuevoStock;
            $resultado = $celular->actualizar();

            if ($resultado['resultado']) {
                self::respuestaJSON(1, 'Stock reducido correctamente', [
                    'stock_anterior' => $stockActual,
                    'stock_nuevo' => $nuevoStock,
                    'cantidad_reducida' => $cantidadReducir
                ]);
            } else {
                self::respuestaJSON(0, 'Error al reducir stock', null, 400);
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al reducir stock: ' . $e->getMessage(), null, 500);
        }
    }
}
