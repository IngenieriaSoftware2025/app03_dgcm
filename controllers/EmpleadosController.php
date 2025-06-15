<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Empleados;
use Model\Usuarios;

class EmpleadosController extends ActiveRecord
{
    public static function mostrarEmpleados(Router $router)
    {
        $router->render('empleados/index', [], 'layout');
    }

    public static function guardarEmpleado()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['id_usuario', 'codigo_empleado']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $empleado = new Empleados([
                'id_usuario' => filter_var($datos['id_usuario'], FILTER_SANITIZE_NUMBER_INT),
                'codigo_empleado' => strtoupper($datos['codigo_empleado']),
                'puesto' => $datos['puesto'] ?? '',
                'salario' => isset($datos['salario']) ? filter_var($datos['salario'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0,
                'fecha_ingreso' => $datos['fecha_ingreso'] ?? date('Y-m-d'),
                'especialidad' => $datos['especialidad'] ?? '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($empleado) {
                    if (!Usuarios::valorExiste('id_usuario', $empleado->id_usuario)) {
                        return 'El usuario no existe';
                    }
                    if (strlen($empleado->codigo_empleado) < 3) {
                        return 'El código del empleado debe tener al menos 3 caracteres';
                    }
                    if (Empleados::valorExiste('codigo_empleado', $empleado->codigo_empleado)) {
                        return 'El código de empleado ya existe';
                    }
                    return true;
                }
            ];

            $empleado->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar el empleado: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarEmpleados()
    {
        Empleados::buscarConRelacionRespuesta(
            'usuarios',
            'id_usuario',
            'id_usuario',
            [
                'nombre_usuario' => 'nombre1',
                'apellido_usuario' => 'apellido1',
                'correo_usuario' => 'correo'
            ],
            "empleados.situacion = 1",
            "empleados.id_empleado DESC"
        );
    }

    public static function modificarEmpleado()
    {
        try {
            if (empty($_POST['id_empleado'])) {
                self::respuestaJSON(0, 'ID de empleado requerido', null, 400);
            }

            $id = $_POST['id_empleado'];
            /** @var \Model\Empleados $empleado */
            $empleado = Empleados::find(['id_empleado' => $id]);

            if (!$empleado) {
                self::respuestaJSON(0, 'Empleado no encontrado', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'id_usuario' => isset($datos['id_usuario']) ? filter_var($datos['id_usuario'], FILTER_SANITIZE_NUMBER_INT) : $empleado->id_usuario,
                'codigo_empleado' => isset($datos['codigo_empleado']) ? strtoupper($datos['codigo_empleado']) : $empleado->codigo_empleado,
                'puesto' => $datos['puesto'] ?? $empleado->puesto,
                'salario' => isset($datos['salario']) ? filter_var($datos['salario'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : $empleado->salario,
                'fecha_ingreso' => $datos['fecha_ingreso'] ?? $empleado->fecha_ingreso,
                'especialidad' => $datos['especialidad'] ?? $empleado->especialidad,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $empleado->situacion
            ];

            $empleado->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($empleado) use ($id) {
                    if (!Usuarios::valorExiste('id_usuario', $empleado->id_usuario)) {
                        return 'El usuario no existe';
                    }
                    if (strlen($empleado->codigo_empleado) < 3) {
                        return 'El código del empleado debe tener al menos 3 caracteres';
                    }
                    if (Empleados::valorExiste('codigo_empleado', $empleado->codigo_empleado, $id, 'id_empleado')) {
                        return 'El código de empleado ya existe';
                    }
                    return true;
                }
            ];

            $empleado->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar el empleado: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarEmpleado()
    {
        try {
            if (empty($_POST['id_empleado'])) {
                self::respuestaJSON(0, 'ID de empleado requerido', null, 400);
            }

            $empleado = Empleados::find(['id_empleado' => $_POST['id_empleado']]);

            if (!$empleado) {
                self::respuestaJSON(0, 'Empleado no encontrado', null, 404);
            }

            $empleado->sincronizar(['situacion' => 0]);
            $empleado->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar el empleado: ' . $e->getMessage(), null, 500);
        }
    }
}
