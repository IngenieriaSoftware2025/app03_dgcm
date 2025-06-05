<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;

// Importa la clase ClienteController
use Controllers\ClienteController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

// Get en nuestro idioma significa obtener, osea obtiene la vista de la pagina y la muestra al cliente
$router->get('/clientes', [ClienteController::class,'mostrarPagina']);
$router->get('/busca_cliente', [ClienteController::class,'buscaCliente']);
$router->post('/elimina_cliente', [ClienteController::class,'eliminaCliente']);
$router->post('/guarda_cliente', [ClienteController::class,'guardarCliente']);
$router->post('/modifica_cliente', [ClienteController::class,'modificaCliente']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
