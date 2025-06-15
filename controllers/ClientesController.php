<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Clientes;

class ClientesController extends ActiveRecord
{
    public static function mostrarClientes(Router $router)
    {
        $router->render('clientes/index', [], 'layout');
    }

    public static function guardarCliente()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['nombres', 'apellidos']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $cliente = new Clientes([
                'nombres' => ucfirst(strtolower($datos['nombres'])),
                'apellidos' => ucfirst(strtolower($datos['apellidos'])),
                'telefono' => $datos['telefono'] ?? '',
                'celular' => $datos['celular'] ?? '',
                'nit' => $datos['nit'] ?? '',
                'correo' => $datos['correo'] ?? '',
                'direccion' => $datos['direccion'] ?? '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($cliente) {
                    if (strlen($cliente->nombres) < 3 || strlen($cliente->apellidos) < 3) {
                        return 'El nombre y apellido deben tener al menos 3 caracteres';
                    }
                    return true;
                }
            ];

            $cliente->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar el cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarClientes()
    {
        Clientes::buscarConRespuesta("situacion = 1", "id_cliente DESC");
    }

    public static function modificarCliente()
    {
        try {
            if (empty($_POST['id_cliente'])) {
                self::respuestaJSON(0, 'ID de cliente requerido', null, 400);
            }

            $id = $_POST['id_cliente'];
            /** @var \Model\Clientes $cliente */
            $cliente = Clientes::find(['id_cliente' => $id]);

            if (!$cliente) {
                self::respuestaJSON(0, 'Cliente no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'nombres' => isset($datos['nombres']) ? ucfirst(strtolower($datos['nombres'])) : $cliente->nombres,
                'apellidos' => isset($datos['apellidos']) ? ucfirst(strtolower($datos['apellidos'])) : $cliente->apellidos,
                'telefono' => $datos['telefono'] ?? $cliente->telefono,
                'celular' => $datos['celular'] ?? $cliente->celular,
                'nit' => $datos['nit'] ?? $cliente->nit,
                'correo' => $datos['correo'] ?? $cliente->correo,
                'direccion' => $datos['direccion'] ?? $cliente->direccion,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $cliente->situacion
            ];

            $cliente->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($cliente) {
                    if (strlen($cliente->nombres) < 3 || strlen($cliente->apellidos) < 3) {
                        return 'El nombre y apellido deben tener al menos 3 caracteres';
                    }
                    return true;
                }
            ];

            $cliente->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar el cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarCliente()
    {
        try {
            if (empty($_POST['id_cliente'])) {
                self::respuestaJSON(0, 'ID de cliente requerido', null, 400);
            }

            $cliente = Clientes::find(['id_cliente' => $_POST['id_cliente']]);

            if (!$cliente) {
                self::respuestaJSON(0, 'Cliente no encontrado', null, 404);
            }

            $cliente->sincronizar(['situacion' => 0]);
            $cliente->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar el cliente: ' . $e->getMessage(), null, 500);
        }
    }
}
