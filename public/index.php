<?php
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;

// Importa mis clases de Controladores
use Controllers\RolesController;
use Controllers\LoginController;
use Controllers\RegistroController;
use Controllers\AplicacionController;
use Controllers\PermisoController;
use Controllers\TiendaController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);
$router->get('/', [AppController::class, 'index']);


// RUTAS DE TIENDA (PÚBLICAS)
$router->get('/tienda', [TiendaController::class, 'index']);
$router->get('/tienda/categoria', [TiendaController::class, 'categoria']);
$router->get('/tienda/ofertas', [TiendaController::class, 'ofertas']);
$router->get('/tienda/carrito', [TiendaController::class, 'carrito']);
$router->get('/tienda/contacto', [TiendaController::class, 'contacto']);

// Rutas para roles
$router->get('/roles', [RolesController::class, 'mostrarPagina']);
$router->get('/busca_rol', [RolesController::class, 'buscaRol']);
$router->post('/elimina_rol', [RolesController::class, 'eliminaRol']);
$router->post('/guarda_rol', [RolesController::class, 'guardarRol']);
$router->post('/modifica_rol', [RolesController::class, 'modificaRol']);

// Rutas para Login
$router->get('/login', [LoginController::class, 'mostrarLogin']);
$router->post('/procesar_login', [LoginController::class, 'procesarLogin']);
$router->get('/logout', [LoginController::class, 'logout']);

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

$router->get('/obtener_usuarios', [PermisoController::class, 'obtenerUsuarios']);
$router->get('/obtener_roles', [PermisoController::class, 'obtenerRoles']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
