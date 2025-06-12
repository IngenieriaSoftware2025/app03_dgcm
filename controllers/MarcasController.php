<?php
// ARCHIVO: Controllers/MarcasController.php
namespace Controllers;

use Exception;
use MVC\Router;
use Model\Marcas;
use Model\ActiveRecord;

class MarcasController extends ActiveRecord
{
    protected static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function guardarMarca()
    {
        self::initSession();
        // if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
        //     self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
        //     return;
        // }

        try {
            $validacion = self::validarRequeridos($_POST, ['marca_nombre']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $marca = new Marcas([
                'marca_nombre' => ucwords(strtolower($datos['marca_nombre'])),
                'situacion' => $datos['situacion'] ?? 1
            ]);

            $validaciones = [
                function ($marca) {
                    if (strlen($marca->marca_nombre) < 2) {
                        return 'El nombre de la marca debe tener más de 2 caracteres';
                    }
                    if (Marcas::valorExiste('marca_nombre', $marca->marca_nombre)) {
                        return 'Esta marca ya está registrada en el sistema';
                    }
                    return true;
                }
            ];

            $marca->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar marca: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscaMarca()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        Marcas::buscarConRespuesta("situacion = 1", "marca_nombre");
    }

    public static function modificaMarca()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_marca'])) {
                self::respuestaJSON(0, 'ID de marca requerido', null, 400);
            }

            $marca = Marcas::find(['id_marca' => $_POST['id_marca']]);
            if (!$marca) {
                self::respuestaJSON(0, 'Marca no encontrada', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $marca->sincronizar([
                'marca_nombre' => ucwords(strtolower($datos['marca_nombre'])),
                'situacion' => $datos['situacion'] ?? 1
            ]);

            $validaciones = [
                function ($marca) {
                    if (strlen($marca->marca_nombre) < 2) {
                        return 'El nombre de la marca debe tener más de 2 caracteres';
                    }
                    if (Marcas::valorExiste('marca_nombre', $marca->marca_nombre, $marca->id_marca, 'id_marca')) {
                        return 'Esta marca ya está registrada por otra entrada';
                    }
                    return true;
                }
            ];

            $marca->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar marca: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminaMarca()
    {
        self::initSession();
        if ((($_SESSION['user']['rol'] ?? null) !== 'administrador')) {
            self::respuestaJSON(0, 'Acceso denegado - Solo administradores', null, 403);
            return;
        }

        try {
            if (empty($_POST['id_marca'])) {
                self::respuestaJSON(0, 'ID de marca requerido', null, 400);
            }

            // Verificar si tiene celulares asociados
            $celularesCount = self::fetchScalar(
                "SELECT COUNT(*) FROM celulares WHERE id_marca = ? AND situacion = 1",
                [$_POST['id_marca']]
            ) ?? 0;

            if ($celularesCount > 0) {
                self::respuestaJSON(0, "No se puede eliminar: la marca tiene $celularesCount celulares asociados", null, 400);
                return;
            }

            Marcas::eliminarLogicoConRespuesta($_POST['id_marca'], 'id_marca');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar marca: ' . $e->getMessage(), null, 500);
        }
    }

    public static function obtenerMarcasActivas()
    {
        try {
            $marcas = self::fetchArray("SELECT id_marca, marca_nombre FROM marcas WHERE situacion = 1 ORDER BY marca_nombre");
            self::respuestaJSON(1, 'Marcas encontradas', $marcas);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al obtener marcas: ' . $e->getMessage(), null, 500);
        }
    }
}
