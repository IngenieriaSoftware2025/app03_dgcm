<?php

namespace Controllers;

use MVC\Router;

class TiendaController
{
    public static function index(Router $router)
    {
        $router->render('tienda/publico/index', [
            'titulo' => 'Tienda Online - Inicio',
            'usuario_logueado' => isset($_SESSION['user'])
        ], 'tienda_layout');
    }

    public static function categoria(Router $router)
    {
        $categoria = $_GET['cat'] ?? 'todos';

        $router->render('tienda/categoria', [
            'titulo' => 'Categoría: ' . ucfirst($categoria),
            'categoria' => $categoria
        ], 'tienda_layout');
    }

    public static function ofertas(Router $router)
    {
        $router->render('tienda/ofertas', [
            'titulo' => 'Ofertas Especiales'
        ], 'tienda_layout');
    }

    public static function carrito(Router $router)
    {
        $router->render('tienda/carrito', [
            'titulo' => 'Carrito de Compras'
        ], 'tienda_layout');
    }

    public static function contacto(Router $router)
    {
        $router->render('tienda/contacto', [
            'titulo' => 'Contáctanos'
        ], 'tienda_layout');
    }
}
