<?php

namespace Controllers;

use Model\Usuarios;
use MVC\Router;

class LoginController
{
    public static function mostrarLogin(Router $router)
    {
        $router->render('login/index', [
            'titulo' => 'Iniciar Sesión'
        ], 'layouts/login');
    }
}
