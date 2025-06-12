<?php
// ARCHIVO: Controllers/ClientesController.php
namespace Controllers;

use Exception;
use MVC\Router;
use Model\Clientes;
use Model\ClientesConfiguracion;
use Model\Usuarios;
use Model\ActiveRecord;

class ClientesController extends ActiveRecord
{
    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function guardarCliente()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $validacion = self::validarRequeridos($_POST, ['nombre1', 'apellido1', 'telefono', 'correo']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            // Iniciar transacción
            self::$db->beginTransaction();

            try {
                // 1. Crear usuario
                $usuario = new Usuarios([
                    'nombre1' => ucwords(strtolower($datos['nombre1'])),
                    'nombre2' => ucwords(strtolower($datos['nombre2'] ?? '')),
                    'apellido1' => ucwords(strtolower($datos['apellido1'])),
                    'apellido2' => ucwords(strtolower($datos['apellido2'] ?? '')),
                    'telefono' => filter_var($datos['telefono'], FILTER_SANITIZE_NUMBER_INT),
                    'dpi' => filter_var($datos['dpi'] ?? '', FILTER_SANITIZE_NUMBER_INT),
                    'correo' => filter_var($datos['correo'], FILTER_SANITIZE_EMAIL),
                    'usuario_clave' => password_hash('123456', PASSWORD_BCRYPT), // Contraseña temporal
                    'token' => uniqid('cliente_', true),
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'fecha_clave' => date('Y-m-d H:i:s'),
                    'rol' => 'cliente',
                    'situacion' => $datos['situacion'] ?? 1
                ]);

                // Validaciones de usuario
                if (strlen($usuario->nombre1) < 2) throw new Exception('El primer nombre debe tener más de 2 caracteres');
                if (strlen($usuario->apellido1) < 2) throw new Exception('El primer apellido debe tener más de 2 caracteres');
                if (strlen($usuario->telefono) != 8) throw new Exception('El teléfono debe tener exactamente 8 dígitos');
                if (!filter_var($usuario->correo, FILTER_VALIDATE_EMAIL)) throw new Exception('El correo electrónico no es válido');
                if (!empty($usuario->dpi) && strlen($usuario->dpi) != 13) throw new Exception('El DPI debe tener exactamente 13 dígitos');

                if (Usuarios::valorExiste('correo', $usuario->correo)) {
                    throw new Exception('El correo ya está registrado en el sistema');
                }
                if (Usuarios::valorExiste('telefono', $usuario->telefono)) {
                    throw new Exception('El teléfono ya está registrado en el sistema');
                }
                if (!empty($usuario->dpi) && Usuarios::valorExiste('dpi', $usuario->dpi)) {
                    throw new Exception('El DPI ya está registrado en el sistema');
                }

                $resultadoUsuario = $usuario->crear();
                if (!$resultadoUsuario['resultado']) {
                    throw new Exception('Error al crear usuario');
                }

                $idUsuario = $resultadoUsuario['id'];

                // 2. Crear cliente
                $cliente = new Clientes([
                    'id_usuario' => $idUsuario,
                    'fecha_registro' => date('Y-m-d H:i:s'),
                    'situacion' => $datos['situacion'] ?? 1
                ]);

                $resultadoCliente = $cliente->crear();
                if (!$resultadoCliente['resultado']) {
                    throw new Exception('Error al crear cliente');
                }

                $idCliente = $resultadoCliente['id'];

                // 3. Crear configuración del cliente
                $configuracion = new ClientesConfiguracion([
                    'id_cliente' => $idCliente,
                    'direccion_principal' => $datos['direccion_principal'] ?? '',
                    'ciudad' => $datos['ciudad'] ?? '',
                    'codigo_postal' => $datos['codigo_postal'] ?? '',
                    'telefono_contacto' => $datos['telefono_contacto'] ?? '',
                    'notificaciones_email' => isset($datos['notificaciones_email']) ? 1 : 0,
                    'notificaciones_sms' => isset($datos['notificaciones_sms']) ? 1 : 0,
                    'newsletter' => isset($datos['newsletter']) ? 1 : 0,
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'fecha_modificacion' => date('Y-m-d H:i:s')
                ]);

                $resultadoConfig = $configuracion->crear();
                if (!$resultadoConfig['resultado']) {
                    throw new Exception('Error al crear configuración del cliente');
                }

                // Confirmar transacción
                self::$db->commit();
                self::respuestaJSON(1, 'Cliente creado exitosamente');
            } catch (Exception $e) {
                self::$db->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaCliente()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $sql = "SELECT 
                        c.id_cliente,
                        u.id_usuario,
                        u.nombre1,
                        u.nombre2,
                        u.apellido1,
                        u.apellido2,
                        u.telefono,
                        u.dpi,
                        u.correo,
                        u.situacion,
                        c.fecha_registro,
                        cc.direccion_principal,
                        cc.ciudad,
                        cc.telefono_contacto,
                        cc.notificaciones_email,
                        cc.notificaciones_sms,
                        cc.newsletter
                    FROM clientes c
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                    LEFT JOIN clientes_configuracion cc ON c.id_cliente = cc.id_cliente
                    WHERE c.situacion = 1
                    ORDER BY u.nombre1, u.apellido1";

            $clientes = self::fetchArray($sql);
            self::respuestaJSON(1, 'Clientes encontrados', $clientes);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al buscar clientes: ' . $e->getMessage(), null, 500);
        }
    }

    public static function modificaCliente()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_cliente'])) {
                self::respuestaJSON(0, 'ID de cliente requerido', null, 400);
            }

            $cliente = Clientes::find(['id_cliente' => $_POST['id_cliente']]);
            if (!$cliente) {
                self::respuestaJSON(0, 'Cliente no encontrado', null, 404);
            }

            $usuario = Usuarios::find(['id_usuario' => $cliente->id_usuario]);
            if (!$usuario) {
                self::respuestaJSON(0, 'Usuario del cliente no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            // Iniciar transacción
            self::$db->beginTransaction();

            try {
                // Actualizar usuario
                $usuario->sincronizar([
                    'nombre1' => ucwords(strtolower($datos['nombre1'])),
                    'nombre2' => ucwords(strtolower($datos['nombre2'] ?? '')),
                    'apellido1' => ucwords(strtolower($datos['apellido1'])),
                    'apellido2' => ucwords(strtolower($datos['apellido2'] ?? '')),
                    'telefono' => filter_var($datos['telefono'], FILTER_SANITIZE_NUMBER_INT),
                    'dpi' => filter_var($datos['dpi'] ?? '', FILTER_SANITIZE_NUMBER_INT),
                    'correo' => filter_var($datos['correo'], FILTER_SANITIZE_EMAIL),
                    'situacion' => $datos['situacion'] ?? 1
                ]);

                // Validaciones
                if (strlen($usuario->nombre1) < 2) throw new Exception('El primer nombre debe tener más de 2 caracteres');
                if (strlen($usuario->apellido1) < 2) throw new Exception('El primer apellido debe tener más de 2 caracteres');
                if (strlen($usuario->telefono) != 8) throw new Exception('El teléfono debe tener exactamente 8 dígitos');
                if (!filter_var($usuario->correo, FILTER_VALIDATE_EMAIL)) throw new Exception('El correo electrónico no es válido');

                if (Usuarios::valorExiste('correo', $usuario->correo, $usuario->id_usuario, 'id_usuario')) {
                    throw new Exception('El correo ya está en uso por otro usuario');
                }
                if (Usuarios::valorExiste('telefono', $usuario->telefono, $usuario->id_usuario, 'id_usuario')) {
                    throw new Exception('El teléfono ya está en uso por otro usuario');
                }

                $resultadoUsuario = $usuario->actualizar();
                if (!$resultadoUsuario['resultado']) {
                    throw new Exception('Error al actualizar usuario');
                }

                // Actualizar configuración del cliente
                $configuracion = ClientesConfiguracion::find(['id_cliente' => $cliente->id_cliente]);
                if ($configuracion) {
                    $configuracion->sincronizar([
                        'direccion_principal' => $datos['direccion_principal'] ?? '',
                        'ciudad' => $datos['ciudad'] ?? '',
                        'codigo_postal' => $datos['codigo_postal'] ?? '',
                        'telefono_contacto' => $datos['telefono_contacto'] ?? '',
                        'notificaciones_email' => isset($datos['notificaciones_email']) ? 1 : 0,
                        'notificaciones_sms' => isset($datos['notificaciones_sms']) ? 1 : 0,
                        'newsletter' => isset($datos['newsletter']) ? 1 : 0,
                        'fecha_modificacion' => date('Y-m-d H:i:s')
                    ]);
                    $configuracion->actualizar();
                }

                // Actualizar cliente
                $cliente->situacion = $datos['situacion'] ?? 1;
                $cliente->actualizar();

                self::$db->commit();
                self::respuestaJSON(1, 'Cliente actualizado exitosamente');
            } catch (Exception $e) {
                self::$db->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaCliente()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_cliente'])) {
                self::respuestaJSON(0, 'ID de cliente requerido', null, 400);
            }

            // Verificar si tiene ventas asociadas
            $ventasCount = self::fetchScalar(
                "SELECT COUNT(*) FROM ventas WHERE id_cliente = ?",
                [$_POST['id_cliente']]
            ) ?? 0;

            if ($ventasCount > 0) {
                self::respuestaJSON(0, "No se puede eliminar: el cliente tiene $ventasCount ventas asociadas", null, 400);
                return;
            }

            // Verificar si tiene reparaciones asociadas
            $reparacionesCount = self::fetchScalar(
                "SELECT COUNT(*) FROM reparaciones WHERE id_cliente = ?",
                [$_POST['id_cliente']]
            ) ?? 0;

            if ($reparacionesCount > 0) {
                self::respuestaJSON(0, "No se puede eliminar: el cliente tiene $reparacionesCount reparaciones asociadas", null, 400);
                return;
            }

            Clientes::eliminarLogicoConRespuesta($_POST['id_cliente'], 'id_cliente');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar cliente: ' . $e->getMessage(), null, 500);
        }
    }

    public static function obtenerClientesActivos()
    {
        try {
            $sql = "SELECT 
                        c.id_cliente,
                        CONCAT(u.nombre1, ' ', u.apellido1) as nombre_completo,
                        u.telefono,
                        u.correo
                    FROM clientes c
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                    WHERE c.situacion = 1 AND u.situacion = 1
                    ORDER BY u.nombre1, u.apellido1";

            $clientes = self::fetchArray($sql);
            self::respuestaJSON(1, 'Clientes activos encontrados', $clientes);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener clientes: ' . $e->getMessage(), null, 500);
        }
    }
}
