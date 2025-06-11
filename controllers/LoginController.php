<?php

namespace Controllers;

use Model\Usuarios;
use MVC\Router;

class LoginController
{
    public static function mostrarLogin(Router $router)
    {
        $router->render('login/index', [], 'login');
    }

    public static function procesarLogin()
    {
        // Verificar método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['codigo' => 0, 'mensaje' => 'Método no permitido']);
            exit;
        }

        // Arrancar sesión
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        try {
            // Obtener datos del formulario
            $email = $_POST['usuario_correo'] ?? '';
            $pass = $_POST['usuario_clave'] ?? '';

            // Validaciones básicas
            if (empty($email) || empty($pass)) {
                echo json_encode(['codigo' => 0, 'mensaje' => 'Email y contraseña son obligatorios']);
                exit;
            }

            // Buscar usuario por correo
            $usuarios = Usuarios::where('correo', $email);

            if (empty($usuarios)) {
                echo json_encode(['codigo' => 0, 'mensaje' => 'Usuario no encontrado']);
                exit;
            }

            $user = $usuarios[0];

            // Si es objeto, convertir a array
            if (is_object($user)) {
                $userData = [
                    'id_usuario' => $user->id_usuario ?? null,
                    'correo' => $user->correo ?? '',
                    'nombre1' => $user->nombre1 ?? '',
                    'apellido1' => $user->apellido1 ?? '',
                    'rol' => $user->rol ?? 'cliente',
                    'situacion' => $user->situacion ?? 1,
                    'usuario_clave' => $user->usuario_clave ?? ''
                ];
            } else {
                $userData = $user;
            }

            // Verificar contraseña
            if (!password_verify($pass, $userData['usuario_clave'])) {
                echo json_encode(['codigo' => 0, 'mensaje' => 'Contraseña incorrecta']);
                exit;
            }

            // Verificar que el usuario esté activo
            if (isset($userData['situacion']) && $userData['situacion'] != 1) {
                echo json_encode(['codigo' => 0, 'mensaje' => 'Usuario inactivo']);
                exit;
            }

            // Guardar información en sesión
            $_SESSION['user'] = [
                'id_usuario' => $userData['id_usuario'] ?? null,
                'correo' => $userData['correo'] ?? '',
                'nombre1' => $userData['nombre1'] ?? '',
                'apellido1' => $userData['apellido1'] ?? '',
                'rol' => $userData['rol'] ?? 'cliente',
                'situacion' => $userData['situacion'] ?? 1
            ];

            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Login exitoso',
                'direccionar' => '/app03_dgcm/',
                'datos' => [
                    'rol' => $userData['rol'] ?? 'cliente',
                    'nombre' => $userData['nombre1'] ?? '',
                    'correo' => $userData['correo'] ?? ''
                ]
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error del servidor: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    public static function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $_SESSION = [];
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        header('Location: /app03_dgcm/');
        exit;
    }
}
