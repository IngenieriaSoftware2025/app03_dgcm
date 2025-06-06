<?php

namespace Controllers;

use Exception;
use Model\Usuarios;
use Model\ActiveRecord;
use MVC\Router;

class RegistroController extends ActiveRecord
{
    public static function mostrarPaginaRegistro(Router $router)
    {
        $router->render('registro/index', [], 'layouts/layout');
    }

    public static function buscaUsuario()
    {
        // usando helper de ActiveRecord
        Usuarios::buscarConRespuesta("situacion = 1", "nombre1, apellido1");
    }

    public static function guardarUsuario()
    {
        try {
            // Validar campos requeridos usando helper
            $validacion = self::validarRequeridos($_POST, [
                'nombre1',
                'apellido1',
                'telefono',
                'correo',
                'usuario_clave'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            // Sanitizar datos usando helper
            $datos = self::sanitizarDatos($_POST);

            // Procesar fotografía si se envió
            $rutaFotografia = '';
            if (isset($_FILES['fotografia']) && !empty($_FILES['fotografia']['tmp_name'])) {
                $resultadoImagen = self::subirImagen($_FILES['fotografia'], 'usuarios');

                if (!$resultadoImagen['success']) {
                    self::respuestaJSON(0, $resultadoImagen['mensaje'], null, 400);
                }

                $rutaFotografia = $resultadoImagen['ruta'];
            }

            // Crear usuario con validaciones personalizadas
            $usuario = new Usuarios([
                'nombre1' => ucwords(strtolower($datos['nombre1'])),
                'nombre2' => ucwords(strtolower($datos['nombre2'] ?? '')),
                'apellido1' => ucwords(strtolower($datos['apellido1'])),
                'apellido2' => ucwords(strtolower($datos['apellido2'] ?? '')),
                'telefono' => filter_var($datos['telefono'], FILTER_SANITIZE_NUMBER_INT),
                'dpi' => filter_var($datos['dpi'] ?? '', FILTER_SANITIZE_NUMBER_INT),
                'correo' => filter_var($datos['correo'], FILTER_SANITIZE_EMAIL),
                'usuario_clave' => password_hash($datos['usuario_clave'], PASSWORD_BCRYPT, ['cost' => 10]),
                'token' => uniqid('user_', true),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_clave' => date('Y-m-d H:i:s'),
                'fotografia' => $rutaFotografia,
                'situacion' => 1
            ]);

            // Definir validaciones específicas de usuario
            $validaciones = [
                // Validar longitud de nombres
                function ($usuario) {
                    if (strlen($usuario->nombre1) < 2) {
                        return 'El primer nombre debe tener más de 2 caracteres';
                    }
                    if (strlen($usuario->apellido1) < 2) {
                        return 'El primer apellido debe tener más de 2 caracteres';
                    }
                    return true;
                },

                // Validar teléfono
                function ($usuario) {
                    if (strlen($usuario->telefono) != 8) {
                        return 'El teléfono debe tener exactamente 8 dígitos';
                    }
                    return true;
                },

                // Validar correo
                function ($usuario) {
                    if (!filter_var($usuario->correo, FILTER_VALIDATE_EMAIL)) {
                        return 'El correo electrónico no es válido';
                    }
                    return true;
                },

                // Validar DPI si existe
                function ($usuario) {
                    if (!empty($usuario->dpi) && strlen($usuario->dpi) != 13) {
                        return 'El DPI debe tener exactamente 13 dígitos';
                    }
                    return true;
                },

                // Validar correo único
                function ($usuario) {
                    if (Usuarios::valorExiste('correo', $usuario->correo)) {
                        return 'El correo ya está registrado en el sistema';
                    }
                    return true;
                },

                // Validar DPI único (si existe)
                function ($usuario) {
                    if (!empty($usuario->dpi) && Usuarios::valorExiste('dpi', $usuario->dpi)) {
                        return 'El DPI ya está registrado en el sistema';
                    }
                    return true;
                }
            ];

            // Crear con validaciones y respuesta automática
            $usuario->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar usuario: ' . $e->getMessage(), null, 500);
        }
    }

    public static function modificaUsuario()
    {
        try {
            // Validar que llegue el ID
            if (empty($_POST['id_usuario'])) {
                self::respuestaJSON(0, 'ID de usuario requerido', null, 400);
            }

            $id = $_POST['id_usuario'];

            // Buscar usuario existente
            $usuario = Usuarios::find(['id_usuario' => $id]);
            if (!$usuario) {
                self::respuestaJSON(0, 'Usuario no encontrado', null, 404);
            }

            // Sanitizar nuevos datos
            $datos = self::sanitizarDatos($_POST);

            //USAR HELPER: Obtener fotografía actual
            $rutaFotografia = Usuarios::obtenerValor('fotografia', 'id_usuario', $id) ?? '';

            if (isset($_FILES['fotografia']) && !empty($_FILES['fotografia']['tmp_name'])) {
                $resultadoImagen = self::subirImagen($_FILES['fotografia'], 'usuarios');

                if (!$resultadoImagen['success']) {
                    self::respuestaJSON(0, $resultadoImagen['mensaje'], null, 400);
                }

                // Eliminar imagen anterior si existe
                if (!empty($usuario->fotografia)) {
                    self::eliminarImagen($rutaFotografia);
                }

                $rutaFotografia = $resultadoImagen['ruta'];
            }
            // Actualizar propiedades
            $datosParaSincronizar = [
                'nombre1' => ucwords(strtolower($datos['nombre1'])),
                'nombre2' => ucwords(strtolower($datos['nombre2'] ?? '')),
                'apellido1' => ucwords(strtolower($datos['apellido1'])),
                'apellido2' => ucwords(strtolower($datos['apellido2'] ?? '')),
                'telefono' => filter_var($datos['telefono'], FILTER_SANITIZE_NUMBER_INT),
                'dpi' => filter_var($datos['dpi'] ?? '', FILTER_SANITIZE_NUMBER_INT),
                'correo' => filter_var($datos['correo'], FILTER_SANITIZE_EMAIL),
                'fotografia' => $rutaFotografia,
            ];

            // Si hay nueva contraseña, actualizarla
            if (!empty($datos['usuario_clave'])) {
                $datosParaSincronizar['usuario_clave'] = password_hash($datos['usuario_clave'], PASSWORD_BCRYPT, ['cost' => 10]);
                $datosParaSincronizar['fecha_clave'] = date('Y-m-d H:i:s');
            }

            // Sincronizar datos al usuario
            $usuario->sincronizar($datosParaSincronizar);


            $validaciones = [
                function ($usuario) {
                    if (strlen($usuario->nombre1) < 2) return 'El primer nombre debe tener más de 2 caracteres';
                    if (strlen($usuario->apellido1) < 2) return 'El primer apellido debe tener más de 2 caracteres';
                    if (strlen($usuario->telefono) != 8) return 'El teléfono debe tener exactamente 8 dígitos';
                    if (!filter_var($usuario->correo, FILTER_VALIDATE_EMAIL)) return 'El correo electrónico no es válido';
                    if (!empty($usuario->dpi) && strlen($usuario->dpi) != 13) return 'El DPI debe tener exactamente 13 dígitos';

                    // Validar unicidad excluyendo el registro actual
                    if (Usuarios::valorExiste('correo', $usuario->correo, $usuario->id_usuario, 'id_usuario')) {
                        return 'El correo ya está en uso por otro usuario';
                    }
                    if (!empty($usuario->dpi) && Usuarios::valorExiste('dpi', $usuario->dpi, $usuario->id_usuario, 'id_usuario')) {
                        return 'El DPI ya está en uso por otro usuario';
                    }

                    return true;
                }
            ];

            // Actualizar con validaciones automáticas
            $usuario->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar usuario: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaUsuario()
    {
        try {
            // Validar que llegue el ID
            if (empty($_POST['id_usuario'])) {
                self::respuestaJSON(0, 'ID de usuario requerido', null, 400);
            }

            $id =  $_POST['id_usuario'];

            //USAR HELPER: Obtener fotografía para eliminar
            $rutaFotografia = Usuarios::obtenerValor('fotografia', 'id_usuario', $id) ?? '';

            if (!empty($rutaFotografia)) {
                self::eliminarImagen($rutaFotografia);
            }

            // Eliminar lógicamente usando helper
            Usuarios::eliminarLogicoConRespuesta($id, 'id_usuario');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar usuario: ' . $e->getMessage(), null, 500);
        }
    }
}
