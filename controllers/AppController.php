<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class AppController
{
    public static function index(Router $router)
    {
        session_start();

        if (isset($_SESSION['login']) && $_SESSION['login']) {
            $router->render('pages/index', ['pagina' => 'inicio'], 'layout');
        } else {
            $router->render('login/index', [], 'login');
        }
    }
}
