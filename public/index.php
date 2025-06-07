<?php
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;

// Importa mis clases de Controladores
use Controllers\ClienteController;
use Controllers\RolesController;
use Controllers\LoginController;
use Controllers\RegistroController;
use Controllers\AplicacionController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class, 'index']);

// Get en nuestro idioma significa obtener, osea obtiene la vista de la pagina y la muestra al cliente
$router->get('/clientes', [ClienteController::class, 'mostrarPagina']);
$router->get('/busca_cliente', [ClienteController::class, 'buscaCliente']);
$router->post('/elimina_cliente', [ClienteController::class, 'eliminaCliente']);
$router->post('/guarda_cliente', [ClienteController::class, 'guardarCliente']);
$router->post('/modifica_cliente', [ClienteController::class, 'modificaCliente']);

// Rutas para Login
$router->get('/login', [LoginController::class, 'mostrarLogin']);
$router->post('/login', [LoginController::class, 'procesarLogin']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/verificar_sesion', [LoginController::class, 'verificarSesion']);

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

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
