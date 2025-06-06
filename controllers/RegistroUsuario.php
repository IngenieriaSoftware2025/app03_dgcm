<?php

namespace Controllers;

use Model\Usuarios;
use MVC\Router;

class RegistroUsuario
{
    public static function mostrarPaginaRegistro(Router $router)
    {
        $router->render('registro/index', [
            'titulo' => 'Registrar usuario'
        ], 'layouts/layout');
    }
}
