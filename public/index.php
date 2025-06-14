<?php
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;

// Importa mis clases de Controladores
use Controllers\ClientesController;
use Controllers\LoginController;
use Controllers\RegistroController;
use Controllers\AplicacionController;
use Controllers\PermisoController;
use Controllers\AsigPermisosController;
use Controllers\PermisoAplicacionController;


use Controllers\MapaController;
use Controllers\EstadisticasController;
use Controllers\MarcasController;
use Controllers\CelularesController;
use Controllers\EmpleadosController;
use Controllers\TiposServiciosController;
use Controllers\ReparacionesController;
use Controllers\VentasController;
use Controllers\DetalleVentasController;
use Controllers\MovimientosInventarioController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class, 'index']);

// Rutas para Login
$router->get('/login', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/inicio', [LoginController::class, 'renderInicio']);
$router->get('/logout', [LoginController::class, 'logout']);


// Get en nuestro idioma significa obtener, osea obtiene la vista de la pagina y la muestra al cliente
$router->get('/clientes', [ClientesController::class, 'mostrarClientes']);
$router->get('/busca_cliente', [ClientesController::class, 'buscarClientes']);
$router->post('/elimina_cliente', [ClientesController::class, 'eliminarCliente']);
$router->post('/guarda_cliente', [ClientesController::class, 'guardarCliente']);
$router->post('/modifica_cliente', [ClientesController::class, 'modificarCliente']);

// Rutas para el registro de usuario
$router->get('/registro', [RegistroController::class, 'mostrarPaginaRegistro']);
$router->get('/busca_usuario', [RegistroController::class, 'buscaUsuario']);
$router->post('/guarda_usuario', [RegistroController::class, 'guardarUsuario']);
$router->post('/modifica_usuario', [RegistroController::class, 'modificaUsuario']);
$router->post('/elimina_usuario', [RegistroController::class, 'eliminaUsuario']);

// Ruta para aplicaciones
$router->get('/aplicaciones', [AplicacionController::class, 'mostrarAplicaciones']);
$router->get('/busca_aplicacion', [AplicacionController::class, 'buscaAplicacion']);
$router->post('/guarda_aplicacion', [AplicacionController::class, 'guardarAplicacion']);
$router->post('/modifica_aplicacion', [AplicacionController::class, 'modificaAplicacion']);
$router->post('/elimina_aplicacion', [AplicacionController::class, 'eliminaAplicacion']);

// Rutas para los permisos
$router->get('/permisos', [PermisoController::class, 'mostrarPermisos']);
$router->get('/busca_permiso', [PermisoController::class, 'buscaPermiso']);
$router->post('/guarda_permiso', [PermisoController::class, 'guardarPermiso']);
$router->post('/modifica_permiso', [PermisoController::class, 'modificaPermiso']);
$router->post('/elimina_permiso', [PermisoController::class, 'eliminaPermiso']);

// Rutas para los permisos de las aplicaciones
$router->get('/permiso_aplicacion', [PermisoAplicacionController::class, 'mostrarVista']);
$router->get('/busca_permiso_aplicacion', [PermisoAplicacionController::class, 'buscarRelaciones']);
$router->post('/guarda_permiso_aplicacion', [PermisoAplicacionController::class, 'guardarRelacion']);
$router->post('/elimina_permiso_aplicacion', [PermisoAplicacionController::class, 'eliminarRelacion']);

// Rutas para Asignación de Permisos
$router->get('/asignacion_permisos', [AsigPermisosController::class, 'mostrarAsignaciones']);
$router->get('/busca_asig_permiso', [AsigPermisosController::class, 'buscarAsignaciones']);
$router->post('/guarda_asig_permiso', [AsigPermisosController::class, 'guardarAsignacion']);
$router->post('/modifica_asig_permiso', [AsigPermisosController::class, 'modificarAsignacion']);
$router->post('/elimina_asig_permiso', [AsigPermisosController::class, 'eliminarAsignacion']);



// Rutas para Marcas
$router->get('/marcas', [MarcasController::class, 'mostrarMarcas']);
$router->post('/guarda_marca', [MarcasController::class, 'guardarMarca']);
$router->get('/busca_marca', [MarcasController::class, 'buscarMarcas']);
$router->post('/modifica_marca', [MarcasController::class, 'modificarMarca']);
$router->post('/elimina_marca', [MarcasController::class, 'eliminarMarca']);

// Rutas para Celulares
$router->get('/celulares', [CelularesController::class, 'mostrarCelulares']);
$router->post('/guarda_celular', [CelularesController::class, 'guardarCelular']);
$router->get('/busca_celular', [CelularesController::class, 'buscarCelulares']);
$router->post('/modifica_celular', [CelularesController::class, 'modificarCelular']);
$router->post('/elimina_celular', [CelularesController::class, 'eliminarCelular']);

// Rutas para Empleados
$router->get('/empleados', [EmpleadosController::class, 'mostrarEmpleados']);
$router->post('/guarda_empleado', [EmpleadosController::class, 'guardarEmpleado']);
$router->get('/busca_empleado', [EmpleadosController::class, 'buscarEmpleados']);
$router->post('/modifica_empleado', [EmpleadosController::class, 'modificarEmpleado']);
$router->post('/elimina_empleado', [EmpleadosController::class, 'eliminarEmpleado']);

// Rutas para TiposServicios
$router->get('/tipos_servicios', [TiposServiciosController::class, 'mostrarTiposServicios']);
$router->post('/guarda_tipo_servicio', [TiposServiciosController::class, 'guardarTipoServicio']);
$router->get('/busca_tipo_servicio', [TiposServiciosController::class, 'buscarTiposServicios']);
$router->post('/modifica_tipo_servicio', [TiposServiciosController::class, 'modificarTipoServicio']);
$router->post('/elimina_tipo_servicio', [TiposServiciosController::class, 'eliminarTipoServicio']);

// Rutas para Reparaciones
$router->get('/reparaciones', [ReparacionesController::class, 'mostrarReparaciones']);
$router->get('/busca_reparacion', [ReparacionesController::class, 'buscarReparaciones']);
$router->post('/guarda_reparacion', [ReparacionesController::class, 'guardarReparacion']);
$router->post('/modifica_reparacion', [ReparacionesController::class, 'modificarReparacion']);
$router->post('/elimina_reparacion', [ReparacionesController::class, 'eliminarReparacion']);

// Rutas para Ventas
$router->get('/ventas', [VentasController::class, 'mostrarVentas']);
$router->post('/guarda_venta', [VentasController::class, 'guardarVenta']);
$router->get('/busca_venta', [VentasController::class, 'buscarVentas']);
$router->post('/modifica_venta', [VentasController::class, 'modificarVenta']);
$router->post('/elimina_venta', [VentasController::class, 'eliminarVenta']);

// Rutas para DetalleVentas
$router->get('/detalle_ventas', [DetalleVentasController::class, 'mostrarDetalles']);
$router->post('/guarda_detalle_venta', [DetalleVentasController::class, 'guardarDetalle']);
$router->get('/busca_detalle_venta', [DetalleVentasController::class, 'buscarDetalles']);
$router->post('/modifica_detalle_venta', [DetalleVentasController::class, 'modificarDetalle']);
$router->post('/elimina_detalle_venta', [DetalleVentasController::class, 'eliminarDetalle']);

// Rutas para MovimientosInventario
$router->get('/movimientos_inventario', [MovimientosInventarioController::class, 'mostrarMovimientos']);
$router->post('/guarda_movimiento_inventario', [MovimientosInventarioController::class, 'guardarMovimiento']);
$router->get('/busca_movimiento_inventario', [MovimientosInventarioController::class, 'buscarMovimientos']);
$router->post('/modifica_movimiento_inventario', [MovimientosInventarioController::class, 'modificarMovimiento']);
$router->post('/elimina_movimiento_inventario', [MovimientosInventarioController::class, 'eliminarMovimiento']);

// Rutas para el Mapa
$router->get('/mapa', [MapaController::class, 'renderizarMapa']);

// Rutas para Estadísticas
$router->get('/estadisticas', [EstadisticasController::class, 'index']);
$router->get('/estadisticas/obtenerDetalleEstadistica', [EstadisticasController::class, 'obtenerDatos']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
