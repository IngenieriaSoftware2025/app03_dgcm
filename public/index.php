<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;

// Importa mis clases de Controladores
use Controllers\ClienteController;
use Controllers\RolesController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

// Get en nuestro idioma significa obtener, osea obtiene la vista de la pagina y la muestra al cliente
$router->get('/clientes', [ClienteController::class,'mostrarPagina']);
$router->get('/busca_cliente', [ClienteController::class,'buscaCliente']);
$router->post('/elimina_cliente', [ClienteController::class,'eliminaCliente']);
$router->post('/guarda_cliente', [ClienteController::class,'guardarCliente']);
$router->post('/modifica_cliente', [ClienteController::class,'modificaCliente']);

// Rutas para los roles
$router->get('/roles', [RolesController::class,'mostrarPagina']);
$router->get('/busca_rol', [RolesController::class,'buscaRol']);
$router->post('/guarda_rol', [RolesController::class,'guardarRol']);
$router->post('/elimina_rol', [RolesController::class,'eliminarRol']);
$router->post('/modifica_rol', [RolesController::class,'modificarRol']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
