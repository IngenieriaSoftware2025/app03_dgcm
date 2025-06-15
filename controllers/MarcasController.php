<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Marcas;

class MarcasController extends ActiveRecord
{
    public static function mostrarMarcas(Router $router)
    {
        $router->render('marcas/index', [], 'layout');
    }

    public static function guardarMarca()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['nombre_marca']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $marca = new Marcas([
                'nombre_marca' => ucfirst(strtolower($datos['nombre_marca'])),
                'pais_origen' => isset($datos['pais_origen']) ? ucfirst(strtolower($datos['pais_origen'])) : '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($marca) {
                    if (strlen($marca->nombre_marca) < 2) {
                        return 'El nombre de la marca debe tener al menos 2 caracteres';
                    }
                    return true;
                },
                function ($marca) {
                    if (Marcas::valorExiste('nombre_marca', $marca->nombre_marca)) {
                        return 'El nombre de la marca ya existe';
                    }
                    return true;
                }
            ];

            $marca->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar la marca: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarMarcas()
    {
        Marcas::buscarConRespuesta("situacion = 1", "id_marca DESC");
    }

    public static function modificarMarca()
    {
        try {
            if (empty($_POST['id_marca'])) {
                self::respuestaJSON(0, 'ID de marca requerido', null, 400);
            }

            $id = $_POST['id_marca'];
            /** @var \Model\Marcas $marca */
            $marca = Marcas::find(['id_marca' => $id]);

            if (!$marca) {
                self::respuestaJSON(0, 'Marca no encontrada', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'nombre_marca' => isset($datos['nombre_marca']) ? ucfirst(strtolower($datos['nombre_marca'])) : $marca->nombre_marca,
                'pais_origen' => isset($datos['pais_origen']) ? ucfirst(strtolower($datos['pais_origen'])) : $marca->pais_origen,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $marca->situacion
            ];

            $marca->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($marca) use ($id) {
                    if (strlen($marca->nombre_marca) < 2) {
                        return 'El nombre de la marca debe tener al menos 2 caracteres';
                    }
                    if (Marcas::valorExiste('nombre_marca', $marca->nombre_marca, $id, 'id_marca')) {
                        return 'El nombre de la marca ya existe';
                    }
                    return true;
                }
            ];

            $marca->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar la marca: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarMarca()
    {
        try {
            if (empty($_POST['id_marca'])) {
                self::respuestaJSON(0, 'ID de marca requerido', null, 400);
            }

            $marca = Marcas::find(['id_marca' => $_POST['id_marca']]);

            if (!$marca) {
                self::respuestaJSON(0, 'Marca no encontrada', null, 404);
            }

            $marca->sincronizar(['situacion' => 0]);
            $marca->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar la marca: ' . $e->getMessage(), null, 500);
        }
    }
}
