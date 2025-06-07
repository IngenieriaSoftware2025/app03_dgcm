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
        $router->render('clientes/clientes', [], 'layout');
    }

    public static function guardarCliente()
    {
        try {
            // Validar campos requeridos usando helper
            $validacion = self::validarRequeridos($_POST, [
                'nombres',
                'apellidos',
                'telefono',
                'correo'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            // Sanitizar datos usando helper
            $datos = self::sanitizarDatos($_POST);

            // Crear cliente con validaciones personalizadas
            $cliente = new Clientes([
                'nombres' => ucwords(strtolower($datos['nombres'])),
                'apellidos' => ucwords(strtolower($datos['apellidos'])),
                'telefono' => filter_var($datos['telefono'], FILTER_SANITIZE_NUMBER_INT),
                'sar' => filter_var($datos['sar'] ?? '', FILTER_SANITIZE_NUMBER_INT),
                'correo' => filter_var($datos['correo'], FILTER_SANITIZE_EMAIL),
                'situacion' => 1
            ]);

            // Definir validaciones específicas de cliente
            $validaciones = [
                // Validar longitud de nombres
                function ($cliente) {
                    if (strlen($cliente->nombres) < 3) {
                        return 'Nombre debe tener más de 2 caracteres';
                    }
                    if (strlen($cliente->apellidos) < 3) {
                        return 'Apellido debe tener más de 2 caracteres';
                    }
                    return true;
                },

                // Validar teléfono
                function ($cliente) {
                    if (strlen($cliente->telefono) != 8) {
                        return 'Teléfono debe tener exactamente 8 dígitos';
                    }
                    return true;
                },

                // Validar correo
                function ($cliente) {
                    if (!filter_var($cliente->correo, FILTER_VALIDATE_EMAIL)) {
                        return 'El correo electrónico no es válido';
                    }
                    return true;
                },

                // Validar correo único
                function ($cliente) {
                    if (Clientes::valorExiste('correo', $cliente->correo)) {
                        return 'El correo ya está registrado en el sistema';
                    }
                    return true;
                }
            ];

            // Crear con validaciones y respuesta automática
            $cliente->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaCliente()
    {
        // Usando el helper para buscar clientes activos
        Clientes::buscarConRespuesta("situacion = 1", "nombres, apellidos");
    }

    public static function modificaCliente()
    {
        try {

            // Validar que llegue el ID
            if (empty($_POST['id_cliente'])) {
                self::respuestaJSON(0, 'ID de cliente requerido', null, 400);
            }

            $id = $_POST['id_cliente'];

            // Buscar cliente existente
            $cliente = Clientes::find(['id_cliente' => $id]);
            if (!$cliente) {
                self::respuestaJSON(0, 'Cliente no encontrado', null, 404);
            }

            // Sanitizar nuevos datos
            $datos = self::sanitizarDatos($_POST);

            // Preparar TODOS los datos para sincronizar
            $datosParaSincronizar = [
                'nombres' => ucwords(strtolower($datos['nombres'])),
                'apellidos' => ucwords(strtolower($datos['apellidos'])),
                'telefono' => filter_var($datos['telefono'], FILTER_SANITIZE_NUMBER_INT),
                'sar' => filter_var($datos['sar'] ?? '', FILTER_SANITIZE_NUMBER_INT),
                'correo' => filter_var($datos['correo'], FILTER_SANITIZE_EMAIL),
                'situacion' => 1
            ];

            // Usar sincronizar una sola vez con todos los datos
            $cliente->sincronizar($datosParaSincronizar);

            // alidaciones excluyendo el registro actual
            $validaciones = [
                function ($cliente) {
                    if (strlen($cliente->nombres) < 3) return 'Nombre debe tener más de 2 caracteres';
                    if (strlen($cliente->apellidos) < 3) return 'Apellido debe tener más de 2 caracteres';
                    if (strlen($cliente->telefono) != 8) return 'Teléfono debe tener exactamente 8 dígitos';
                    if (!filter_var($cliente->correo, FILTER_VALIDATE_EMAIL)) return 'El correo electrónico no es válido';

                    // Validar unicidad excluyendo el registro actual
                    if (Clientes::valorExiste('correo', $cliente->correo, $cliente->id_cliente, 'id_cliente')) {
                        return 'El correo ya está en uso por otro cliente';
                    }

                    return true;
                }
            ];
            // Actualizar con validaciones automáticas
            $cliente->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaCliente()
    {
        try {
            if (empty($_POST['id_cliente'])) {
                self::respuestaJSON(0, 'ID de cliente requerido', null, 400);
            }
            // Usamos el helper logico para eliminar el cliente
            Clientes::eliminarLogicoConRespuesta($_POST['id_cliente'], 'id_cliente');
        } catch (Exception $e) {
            http_response_code(400);
            self::respuestaJSON(0, 'Error al eliminar cliente: ' . $e->getMessage(), null, 500);
        }
    }
}
