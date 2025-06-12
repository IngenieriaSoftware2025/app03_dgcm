<?php

namespace Controllers;

use Exception;
use Model\Usuarios;
use Model\ActiveRecord;
use MVC\Router;

class RegistroController extends ActiveRecord
{

    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function mostrarPaginaRegistro(Router $router)
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            // Redirigir según el rol
            $rol = $_SESSION['user']['rol'] ?? 'cliente';
            switch ($rol) {
                case 'empleado':
                    header('Location: /app03_dgcm/empleado');
                    break;
                case 'cliente':
                    header('Location: /app03_dgcm/tienda');
                    break;
                default:
                    header('Location: /app03_dgcm/login');
            }
            exit;
        }

        $router->render('admin/usuarios/index', [], 'tienda_layout');
    }

    public static function buscaUsuario()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        Usuarios::buscarConRespuesta("situacion = 1", "nombre1, apellido1");
    }

    public static function guardarUsuario()
    {
        self::initSession();
        // if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
        //     self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
        //     return;
        // }

        try {
            // Validar campos requeridos usando helper
            $validacion = self::validarRequeridos($_POST, [
                'nombre1',
                'apellido1',
                'telefono',
                'correo',
                'usuario_clave',
                'rol'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            // Sanitizar datos usando helper
            $datos = self::sanitizarDatos($_POST);

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
                'rol' => $datos['rol'],
                'situacion' => 1
            ]);

            // PROCESAR FOTOGRAFIA CON DPI COMO NOMBRE
            if (isset($_FILES['fotografia']) && !empty($_FILES['fotografia']['tmp_name'])) {
                // Verificar que tenga DPI para usar como nombre
                if (empty($datos['dpi'])) {
                    self::respuestaJSON(0, 'Se requiere DPI para subir fotografía', null, 400);
                    return;
                }

                $resultadoImagen = self::subirImagen($_FILES['fotografia'], 'usuarios', 2097152, $datos['dpi']);

                if ($resultadoImagen['success']) {
                    $usuario->fotografia = $resultadoImagen['ruta'];
                } else {
                    self::respuestaJSON(0, $resultadoImagen['mensaje'], null, 400);
                    return;
                }
            }

            // Definir validaciones específicas de usuario
            $validaciones = [
                function ($usuario) {
                    // Validar longitud
                    if (strlen($usuario->nombre1) < 2) return 'El primer nombre debe tener más de 2 caracteres';
                    if (strlen($usuario->apellido1) < 2) return 'El primer apellido debe tener más de 2 caracteres';
                    if (strlen($usuario->telefono) != 8) return 'El teléfono debe tener exactamente 8 dígitos';
                    if (!filter_var($usuario->correo, FILTER_VALIDATE_EMAIL)) return 'El correo electrónico no es válido';
                    if (!empty($usuario->dpi) && strlen($usuario->dpi) != 13) return 'El DPI debe tener exactamente 13 dígitos';

                    // VALIDAR UNICIDAD
                    if (Usuarios::valorExiste('correo', $usuario->correo)) {
                        return 'El correo ya está registrado en el sistema';
                    }

                    // Validar teléfono 
                    if (Usuarios::valorExiste('telefono', $usuario->telefono)) {
                        return 'El teléfono ya está registrado en el sistema';
                    }

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
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

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

            // PROCESAR NUEVA FOTOGRAFIA SI SE SUBIÓ
            if (isset($_FILES['fotografia']) && !empty($_FILES['fotografia']['tmp_name'])) {

                // Eliminar imagen anterior si existe
                if (!empty($usuario->fotografia)) {
                    self::eliminarImagen($usuario->fotografia);
                }

                // Subir nueva imagen con DPI como nombre
                $resultadoImagen = self::subirImagen($_FILES['fotografia'], 'usuarios', 2097152, $usuario->dpi);

                if ($resultadoImagen['success']) {
                    $usuario->fotografia = $resultadoImagen['ruta'];
                } else {
                    self::respuestaJSON(0, $resultadoImagen['mensaje'], null, 400);
                    return;
                }
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
                'rol' => $datos['rol']
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
                    if (Usuarios::valorExiste('telefono', $usuario->telefono, $usuario->id_usuario, 'id_usuario')) {
                        return 'El teléfono ya está en uso por otro usuario';
                    }
                    if (!empty($usuario->dpi) && Usuarios::valorExiste('dpi', $usuario->dpi, $usuario->id_usuario, 'id_usuario')) {
                        return 'El DPI ya está en uso por otro usuario';
                    }
                    // Si todo es válido, retornar true
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
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

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

    public static function estadisticasUsuarios()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $sql = "
                SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN rol = 'administrador' THEN 1 ELSE 0 END) as admins,
                    SUM(CASE WHEN rol = 'empleado' THEN 1 ELSE 0 END) as empleados,
                    SUM(CASE WHEN rol = 'cliente' THEN 1 ELSE 0 END) as clientes,
                    SUM(CASE WHEN situacion = 1 THEN 1 ELSE 0 END) as activos,
                    SUM(CASE WHEN situacion = 0 THEN 1 ELSE 0 END) as inactivos
                FROM usuarios
            ";
            $stats = self::consultarSQL($sql)[0];
            self::respuestaJSON(1, 'Estadísticas obtenidas exitosamente', $stats);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener estadísticas: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarConFiltros()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            $condiciones = ["1=1"]; // Condición base
            $parametros = [];

            // Filtro por rol
            if (!empty($_GET['rol'])) {
                $condiciones[] = "rol = ?";
                $parametros[] = $_GET['rol'];
            }

            // Filtro por estado
            if (isset($_GET['situacion']) && $_GET['situacion'] !== '') {
                $condiciones[] = "situacion = ?";
                $parametros[] = $_GET['situacion'];
            }

            // Filtro por fecha desde
            if (!empty($_GET['fecha_desde'])) {
                $condiciones[] = "DATE(fecha_creacion) >= ?";
                $parametros[] = $_GET['fecha_desde'];
            }

            // Filtro por fecha hasta
            if (!empty($_GET['fecha_hasta'])) {
                $condiciones[] = "DATE(fecha_creacion) <= ?";
                $parametros[] = $_GET['fecha_hasta'];
            }

            // Filtro por búsqueda general
            if (!empty($_GET['buscar'])) {
                $buscar = '%' . $_GET['buscar'] . '%';
                $condiciones[] = "(nombre1 LIKE ? OR apellido1 LIKE ? OR correo LIKE ? OR telefono LIKE ?)";
                $parametros[] = $buscar;
                $parametros[] = $buscar;
                $parametros[] = $buscar;
                $parametros[] = $buscar;
            }

            $whereClause = implode(' AND ', $condiciones);
            $orderBy = "ORDER BY fecha_creacion DESC";

            // Construir consulta completa
            $sql = "SELECT * FROM " . Usuarios::$tabla . " WHERE " . $whereClause . " " . $orderBy;
            $usuarios = Usuarios::fetchArray($sql);

            self::respuestaJSON(1, 'Usuarios filtrados obtenidos', $usuarios);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al filtrar usuarios: ' . $e->getMessage(), null, 500);
        }
    }

    public static function cambiarEstadoUsuario()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_usuario']) || !isset($_POST['nuevo_estado'])) {
                self::respuestaJSON(0, 'ID de usuario y estado requeridos', null, 400);
                return;
            }

            $id = $_POST['id_usuario'];
            $nuevoEstado = $_POST['nuevo_estado'];

            // Validar que el estado sea válido
            if (!in_array($nuevoEstado, ['0', '1'])) {
                self::respuestaJSON(0, 'Estado inválido', null, 400);
                return;
            }

            $usuario = Usuarios::find(['id_usuario' => $id]);
            if (!$usuario) {
                self::respuestaJSON(0, 'Usuario no encontrado', null, 404);
                return;
            }

            $usuario->situacion = $nuevoEstado;

            if ($usuario->guardar()) {
                $estadoTexto = $nuevoEstado == 1 ? 'activado' : 'desactivado';
                self::respuestaJSON(1, "Usuario {$estadoTexto} exitosamente", null);
            } else {
                self::respuestaJSON(0, 'Error al cambiar estado del usuario', null, 500);
            }
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al cambiar estado: ' . $e->getMessage(), null, 500);
        }
    }
}
