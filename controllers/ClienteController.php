<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Clientes;

class ClienteController extends ActiveRecord
{

    public static function mostrarPagina(Router $router)
    {
        $router->render('clientes/clientes', []);
    }

    public static function guardarCliente()
    {
        getHeadersApi();
        echo json_encode($_POST);

        // Sanitizar el nombre y validar
        $_POST['nombres'] = ucwords(strtolower(trim(htmlspecialchars($_POST['nombres']))));
        $cantidad_nombre = strlen($_POST['nombres']);
        if ($cantidad_nombre < 3) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre debe tener mas de 2 caracteres'
            ]);
            return;
        }

        $_POST['apellidos'] = ucwords(strtolower(trim(htmlspecialchars($_POST['apellidos']))));
        $cantidad_apellido = strlen($_POST['apellidos']);
        if ($cantidad_apellido < 3) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Apellido debe tener mas de 2 caracteres'
            ]);
            return;
        }

        $_POST['telefono'] = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Telefono debe tener 8 numeros'
            ]);
            return;
        }

        $_POST['sar'] = filter_var($_POST['sar'], FILTER_SANITIZE_NUMBER_INT);

        $_POST['correo'] = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico no es válido'
            ]);
            return;
        }

        // Despues de sanitizar se envian los datos a guardar
        try {
            $cliente = new Clientes(
                [
                    'nombres' => $_POST['nombres'],
                    'apellidos' => $_POST['apellidos'],
                    'telefono' => $_POST['telefono'],
                    'sar' => $_POST['sar'],
                    'correo' => $_POST['correo'],
                    'situacion' => 1
                ]
            );

            $crear = $cliente->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Exito al guardar cliente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar cliente',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function buscaCliente()
    {
        try {
            $consulta = "SELECT * FROM clientes WHERE situacion  = 1 ORDER BY nombres";
            $cliente =  self::fetchArray($consulta);

            if (count($cliente) > 0) {
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Exito al buscar clientes',
                    'data' => $cliente
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al buscar clientes',
                    'detalle' => 'No hay clientes'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error en el servidor',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function modificaCliente()
    {
        getHeadersApi();
        $id = $_POST['id_cliente'];

        // Sanitizar el nombre y validar
        $_POST['nombres'] = ucwords(strtolower(trim(htmlspecialchars($_POST['nombres']))));
        $cantidad_nombre = strlen($_POST['nombres']);
        if ($cantidad_nombre < 3) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre debe tener mas de 2 caracteres'
            ]);
            return;
        }

        $_POST['apellidos'] = ucwords(strtolower(trim(htmlspecialchars($_POST['apellidos']))));
        $cantidad_apellido = strlen($_POST['apellidos']);
        if ($cantidad_apellido < 3) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Apellido debe tener mas de 2 caracteres'
            ]);
            return;
        }

        $_POST['telefono'] = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Telefono debe tener 8 numeros'
            ]);
            return;
        }

        $_POST['sar'] = filter_var($_POST['sar'], FILTER_SANITIZE_NUMBER_INT);

        $_POST['correo'] = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico no es válido'
            ]);
            return;
        }

        try {
            $data = Clientes::find($id);
            $data->sincronizar(
                [
                    'nombres' => $_POST['nombres'],
                    'apellidos' => $_POST['apellidos'],
                    'telefono' => $_POST['telefono'],
                    'sar' => $_POST['sar'],
                    'correo' => $_POST['correo'],
                    'situacion' => 1
                ]
            );

            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Exito al actualizar'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al actualizar',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}
