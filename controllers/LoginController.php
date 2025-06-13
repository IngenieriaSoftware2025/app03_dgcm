<?php

namespace Controllers;

use Model\Usuarios;
use MVC\Router;
use Model\ActiveRecord;

class LoginController extends ActiveRecord
{
    public static function index(Router $router)
    {
        // $router->render('login/index', [], 'login');
        $router->render('login/index', [], 'login');
    }

    public static function login()
    {
        getHeadersApi();

        try {
            $correo = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
            $clave = $_POST['usuario_clave'] ?? '';

            $query = "SELECT id_usuario, usuario_clave FROM usuarios WHERE correo = '$correo' AND situacion = 1";
            $usuario = Usuarios::fetchFirst($query);

            if ($usuario) {
                if (password_verify($clave, $usuario['usuario_clave'])) {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];

                    Usuarios::respuestaJSON(1, 'usuario logueado existosamente');
                } else {
                    Usuarios::respuestaJSON(0, 'La contraseña que ingresó es incorrecta');
                }
            } else {
                Usuarios::respuestaJSON(0, 'El usuario que intenta loguearse no existe');
            }
        } catch (\Exception $e) {
            Usuarios::respuestaJSON(0, 'Error al intentar loguearse', null, 500);
        }
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        Usuarios::respuestaJSON(1, 'Sesión finalizada');
    }

    public static function verificarSesion()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            Usuarios::respuestaJSON(1, 'Sesión activa');
        } else {
            Usuarios::respuestaJSON(0, 'Sin sesión');
        }
    }

    public static function renderInicio(Router $router)
    {

        $router->render('pages/index', [], 'layout');
    }
}
