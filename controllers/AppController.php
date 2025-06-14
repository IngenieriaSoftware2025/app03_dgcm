<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class AppController
{
    public static function index(Router $router)
    {
        // $router->render('login/index', [], 'login');
        // $router->render('pages/index', [], 'layout');

        session_start();

        if (isset($_SESSION['login']) && $_SESSION['login']) {
            $router->render('pages/index', [], 'layout');
        } else {
            $router->render('login/index', [], 'login');
        }
    }
}
