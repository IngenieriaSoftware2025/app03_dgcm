<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;

// Importa TODOS los controladores
use Controllers\AdminController;
use Controllers\RolesController;
use Controllers\LoginController;
use Controllers\RegistroController;
use Controllers\PermisoController;
use Controllers\TiendaController;
use Controllers\EmpleadoController;
use Controllers\MarcasController;
use Controllers\CelularesController;
use Controllers\ClientesController;
use Controllers\VentasController;
use Controllers\EstadisticasController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

// RUTA PRINCIPAL
$router->get('/', [AppController::class, 'index']);

// RUTAS DE TIENDA (PÚBLICAS)
$router->get('/tienda', [TiendaController::class, 'index']);
$router->get('/tienda/categoria', [TiendaController::class, 'categoria']);
$router->get('/tienda/ofertas', [TiendaController::class, 'ofertas']);
$router->get('/tienda/carrito', [TiendaController::class, 'carrito']);
$router->get('/tienda/contacto', [TiendaController::class, 'contacto']);
$router->get('/tienda/celulares', [CelularesController::class, 'mostrarPaginaTienda']);

// RUTAS DE AUTENTICACIÓN
$router->get('/login', [LoginController::class, 'mostrarLogin']);
$router->post('/procesar_login', [LoginController::class, 'procesarLogin']);
$router->get('/logout', [LoginController::class, 'logout']);

// RUTAS DE EMPLEADO
$router->get('/empleado', [EmpleadoController::class, 'dashboard']);
$router->get('/empleado/celulares', [CelularesController::class, 'mostrarPaginaEmpleado']);
$router->get('/empleado/productos', [EmpleadoController::class, 'productos']);
$router->get('/empleado/categorias', [EmpleadoController::class, 'categorias']);
$router->get('/empleado/pedidos', [EmpleadoController::class, 'pedidos']);
$router->get('/empleado/clientes', [EmpleadoController::class, 'clientes']);
$router->get('/empleado/perfil', [EmpleadoController::class, 'perfil']);

// RUTAS ADMINISTRATIVAS - VISTAS
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
$router->get('/admin/marcas', [AdminController::class, 'marcas']);
$router->get('/admin/celulares', [CelularesController::class, 'mostrarPaginaAdmin']);
$router->get('/admin/celulares', [AdminController::class, 'celulares']);
$router->get('/admin/clientes', [AdminController::class, 'clientes']);
$router->get('/admin/ventas', [AdminController::class, 'ventas']);
$router->get('/admin/reparaciones', [AdminController::class, 'reparaciones']);
$router->get('/admin/estadisticas', [AdminController::class, 'estadisticas']);

// RUTAS DE ADMINISTRACIÓN - PÁGINAS ESPECÍFICAS

// Gestión de Usuarios 
$router->get('/registro', [RegistroController::class, 'mostrarPaginaRegistro']);
$router->get('/busca_usuario', [RegistroController::class, 'buscaUsuario']);
$router->post('/guarda_usuario', [RegistroController::class, 'guardarUsuario']);
$router->post('/modifica_usuario', [RegistroController::class, 'modificaUsuario']);
$router->post('/elimina_usuario', [RegistroController::class, 'eliminaUsuario']);


// Gestión de Permisos 
$router->get('/permisos', [PermisoController::class, 'mostrarPermisos']);
$router->get('/busca_permiso', [PermisoController::class, 'buscaPermiso']);
$router->post('/guarda_permiso', [PermisoController::class, 'guardarPermiso']);
$router->post('/modifica_permiso', [PermisoController::class, 'modificaPermiso']);
$router->post('/elimina_permiso', [PermisoController::class, 'eliminaPermiso']);
$router->get('/obtener_usuarios', [PermisoController::class, 'obtenerUsuarios']);
$router->get('/obtener_roles', [PermisoController::class, 'obtenerRoles']);

// RUTAS DE ADMINISTRACIÓN - PÁGINAS ESPECÍFICAS (continuación)
$router->get('/api/celulares/tienda', [CelularesController::class, 'obtenerCelularesTienda']);
$router->get('/api/celulares/producto', [CelularesController::class, 'obtenerCelularPorId']);
$router->get('/api/celulares/buscar-tienda', [CelularesController::class, 'buscarCelularesTienda']);

// APIs ADMINISTRATIVAS - MARCAS
$router->post('/api/marcas/guardar', [MarcasController::class, 'guardarMarca']);
$router->get('/api/marcas/buscar', [MarcasController::class, 'buscaMarca']);
$router->post('/api/marcas/modificar', [MarcasController::class, 'modificaMarca']);
$router->post('/api/marcas/eliminar', [MarcasController::class, 'eliminaMarca']);
$router->get('/api/marcas/activas', [MarcasController::class, 'obtenerMarcasActivas']);

// APIs ADMINISTRATIVAS - CELULARES/INVENTARIO
$router->post('/api/celulares/guardar', [CelularesController::class, 'guardarCelular']);
$router->get('/api/celulares/buscar', [CelularesController::class, 'buscaCelular']);
$router->post('/api/celulares/modificar', [CelularesController::class, 'modificaCelular']);
$router->post('/api/celulares/eliminar', [CelularesController::class, 'eliminaCelular']);
$router->post('/api/celulares/ajustar-stock', [CelularesController::class, 'ajustarStock']);
$router->get('/api/celulares/disponibles', [CelularesController::class, 'obtenerCelularesDisponibles']);
$router->get('/api/celulares/buscar-empleado', [CelularesController::class, 'buscaCelularEmpleado']);

// APIs ADMINISTRATIVAS - CLIENTES
$router->post('/api/clientes/guardar', [ClientesController::class, 'guardarCliente']);
$router->get('/api/clientes/buscar', [ClientesController::class, 'buscaCliente']);
$router->post('/api/clientes/modificar', [ClientesController::class, 'modificaCliente']);
$router->post('/api/clientes/eliminar', [ClientesController::class, 'eliminaCliente']);
$router->get('/api/clientes/activos', [ClientesController::class, 'obtenerClientesActivos']);

// APIs ADMINISTRATIVAS - VENTAS
$router->post('/api/ventas/guardar', [VentasController::class, 'guardarVenta']);
$router->get('/api/ventas/buscar', [VentasController::class, 'buscaVenta']);
$router->get('/api/ventas/reparaciones-terminadas', [VentasController::class, 'obtenerReparacionesTerminadas']);
$router->get('/api/celulares/estadisticas', [CelularesController::class, 'obtenerEstadisticasInventario']);
$router->get('/api/celulares/mas-vendidos', [CelularesController::class, 'obtenerProductosMasVendidos']);

// APIs ADMINISTRATIVAS - ESTADÍSTICAS Y REPORTES
$router->get('/api/estadisticas/principales', [EstadisticasController::class, 'obtenerEstadisticasPrincipales']);
$router->post('/api/estadisticas/reporte', [EstadisticasController::class, 'generarReporte']);

// APIs de Usuarios (alternativas a las rutas legacy)
$router->get('/api/usuarios/buscar', [RegistroController::class, 'buscaUsuario']);
$router->post('/api/usuarios/guardar', [RegistroController::class, 'guardarUsuario']);
$router->post('/api/usuarios/modificar', [RegistroController::class, 'modificaUsuario']);
$router->post('/api/usuarios/eliminar', [RegistroController::class, 'eliminaUsuario']);

$router->get('/app03_dgcm/estadisticas_usuarios', [RegistroController::class, 'estadisticasUsuarios']);
$router->get('/app03_dgcm/buscar_usuarios_filtros', [RegistroController::class, 'buscarConFiltros']);
$router->post('/app03_dgcm/cambiar_estado_usuario', [RegistroController::class, 'cambiarEstadoUsuario']);

// APIs de Roles (alternativas a las rutas legacy)
$router->get('/api/roles/buscar', [RolesController::class, 'buscaRol']);
$router->post('/api/roles/guardar', [RolesController::class, 'guardarRol']);
$router->post('/api/roles/modificar', [RolesController::class, 'modificaRol']);
$router->post('/api/roles/eliminar', [RolesController::class, 'eliminaRol']);

// APIs de Permisos (alternativas a las rutas legacy)
$router->get('/api/permisos/buscar', [PermisoController::class, 'buscaPermiso']);
$router->post('/api/permisos/guardar', [PermisoController::class, 'guardarPermiso']);
$router->post('/api/permisos/modificar', [PermisoController::class, 'modificaPermiso']);
$router->post('/api/permisos/eliminar', [PermisoController::class, 'eliminaPermiso']);
$router->get('/api/permisos/usuarios', [PermisoController::class, 'obtenerUsuarios']);
$router->get('/api/permisos/roles', [PermisoController::class, 'obtenerRoles']);

// Métodos auxiliares
$router->post('/api/celulares/verificar-stock', [CelularesController::class, 'verificarStock']);
$router->post('/api/celulares/reducir-stock', [CelularesController::class, 'reducirStock']);

// VERIFICACIÓN Y EJECUCIÓN DE RUTAS
$router->comprobarRutas();
