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
        $router->render('pages/index', [], 'layout');
    }
}
