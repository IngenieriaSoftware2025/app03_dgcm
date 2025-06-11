<?php

namespace Controllers;

use MVC\Router;

class TiendaController
{
    public static function index(Router $router)
    {
        // PÁGINA PRINCIPAL DE LA TIENDA - ACCESO PÚBLICO
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $router->render('tienda/index', [
            'titulo' => 'Tienda Online - Inicio',
            'usuario_logueado' => isset($_SESSION['user'])
        ], 'tienda');
    }

    public static function categoria(Router $router)
    {
        $categoria = $_GET['cat'] ?? 'todos';

        $router->render('tienda/categoria', [
            'titulo' => 'Categoría: ' . ucfirst($categoria),
            'categoria' => $categoria
        ], 'tienda');
    }

    public static function ofertas(Router $router)
    {
        $router->render('tienda/ofertas', [
            'titulo' => 'Ofertas Especiales'
        ], 'tienda');
    }

    public static function carrito(Router $router)
    {
        $router->render('tienda/carrito', [
            'titulo' => 'Carrito de Compras'
        ], 'tienda');
    }

    public static function contacto(Router $router)
    {
        $router->render('tienda/contacto', [
            'titulo' => 'Contáctanos'
        ], 'tienda');
    }
}
