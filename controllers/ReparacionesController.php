<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Reparaciones;
use Model\Clientes;
use Model\Empleados;
use Model\TiposServicios;

class ReparacionesController extends ActiveRecord
{
    public static function mostrarReparaciones(Router $router)
    {
        $router->render('reparaciones/index', [], 'layout');
    }

    public static function guardarReparacion()
    {
        try {
            $validacion = self::validarRequeridos($_POST, ['id_cliente', 'motivo']);
            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $reparacion = new Reparaciones([
                'id_cliente' => filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT),
                'id_empleado_asignado' => isset($datos['id_empleado_asignado']) ? filter_var($datos['id_empleado_asignado'], FILTER_SANITIZE_NUMBER_INT) : null,
                'id_tipo_servicio' => isset($datos['id_tipo_servicio']) ? filter_var($datos['id_tipo_servicio'], FILTER_SANITIZE_NUMBER_INT) : null,
                'tipo_celular' => $datos['tipo_celular'] ?? '',
                'marca_celular' => $datos['marca_celular'] ?? '',
                'modelo_celular' => $datos['modelo_celular'] ?? '',
                'imei' => $datos['imei'] ?? '',
                'motivo' => ucfirst($datos['motivo']),
                'diagnostico' => $datos['diagnostico'] ?? '',
                'solucion' => $datos['solucion'] ?? '',
                'fecha_ingreso' => date('Y-m-d H:i:s'),
                'fecha_asignacion' => null,
                'fecha_inicio_trabajo' => null,
                'fecha_terminado' => null,
                'fecha_entrega' => null,
                'costo_servicio' => isset($datos['costo_servicio']) ? floatval($datos['costo_servicio']) : 0,
                'costo_repuestos' => isset($datos['costo_repuestos']) ? floatval($datos['costo_repuestos']) : 0,
                'total_cobrado' => isset($datos['total_cobrado']) ? floatval($datos['total_cobrado']) : 0,
                'estado' => $datos['estado'] ?? 'Ingresado',
                'prioridad' => $datos['prioridad'] ?? 'Normal',
                'observaciones' => $datos['observaciones'] ?? '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($reparacion) {
                    if (!Clientes::valorExiste('id_cliente', $reparacion->id_cliente)) {
                        return 'El cliente no existe';
                    }
                    return true;
                }
            ];

            $reparacion->crearConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al guardar la reparación: ' . $e->getMessage(), null, 500);
        }
    }

    public static function buscarReparaciones()
    {
        Reparaciones::buscarConRelacionMultiplesRespuesta(
            [
                [
                    'tabla' => 'clientes',
                    'alias' => 'c',
                    'llave_local' => 'id_cliente',
                    'llave_foranea' => 'id_cliente',
                    'campos' => [
                        'nombre_cliente' => 'nombres',
                        'apellido_cliente' => 'apellidos',
                        'nit_cliente' => 'nit'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla' => 'empleados',
                    'alias' => 'e',
                    'llave_local' => 'id_empleado_asignado',
                    'llave_foranea' => 'id_empleado',
                    'campos' => [
                        'codigo_empleado' => 'codigo_empleado',
                        'puesto_empleado' => 'puesto'
                    ],
                    'tipo' => 'LEFT'
                ],
                [
                    'tabla' => 'tipos_servicios',
                    'alias' => 'ts',
                    'llave_local' => 'id_tipo_servicio',
                    'llave_foranea' => 'id_tipo_servicio',
                    'campos' => [
                        'desc_servicio' => 'descripcion',
                        'categoria_servicio' => 'categoria'
                    ],
                    'tipo' => 'LEFT'
                ]
            ],
            "reparaciones.situacion = 1",
            "reparaciones.id_reparacion DESC"
        );
    }

    public static function modificarReparacion()
    {
        try {
            if (empty($_POST['id_reparacion'])) {
                self::respuestaJSON(0, 'ID de reparación requerido', null, 400);
            }

            $id = $_POST['id_reparacion'];
            /** @var \Model\Reparaciones $reparacion */
            $reparacion = Reparaciones::find(['id_reparacion' => $id]);

            if (!$reparacion) {
                self::respuestaJSON(0, 'Reparación no encontrada', null, 404);
            }

            $datos = self::sanitizarDatos($_POST);

            $datosParaSincronizar = [
                'id_cliente' => isset($datos['id_cliente']) ? filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_cliente,
                'id_empleado_asignado' => isset($datos['id_empleado_asignado']) ? filter_var($datos['id_empleado_asignado'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_empleado_asignado,
                'id_tipo_servicio' => isset($datos['id_tipo_servicio']) ? filter_var($datos['id_tipo_servicio'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_tipo_servicio,
                'tipo_celular' => $datos['tipo_celular'] ?? $reparacion->tipo_celular,
                'marca_celular' => $datos['marca_celular'] ?? $reparacion->marca_celular,
                'modelo_celular' => $datos['modelo_celular'] ?? $reparacion->modelo_celular,
                'imei' => $datos['imei'] ?? $reparacion->imei,
                'motivo' => $datos['motivo'] ?? $reparacion->motivo,
                'diagnostico' => $datos['diagnostico'] ?? $reparacion->diagnostico,
                'solucion' => $datos['solucion'] ?? $reparacion->solucion,
                'fecha_asignacion' => $datos['fecha_asignacion'] ?? $reparacion->fecha_asignacion,
                'fecha_inicio_trabajo' => $datos['fecha_inicio_trabajo'] ?? $reparacion->fecha_inicio_trabajo,
                'fecha_terminado' => $datos['fecha_terminado'] ?? $reparacion->fecha_terminado,
                'fecha_entrega' => $datos['fecha_entrega'] ?? $reparacion->fecha_entrega,
                'costo_servicio' => isset($datos['costo_servicio']) ? floatval($datos['costo_servicio']) : $reparacion->costo_servicio,
                'costo_repuestos' => isset($datos['costo_repuestos']) ? floatval($datos['costo_repuestos']) : $reparacion->costo_repuestos,
                'total_cobrado' => isset($datos['total_cobrado']) ? floatval($datos['total_cobrado']) : $reparacion->total_cobrado,
                'estado' => $datos['estado'] ?? $reparacion->estado,
                'prioridad' => $datos['prioridad'] ?? $reparacion->prioridad,
                'observaciones' => $datos['observaciones'] ?? $reparacion->observaciones,
                'situacion' => isset($datos['situacion']) ? $datos['situacion'] : $reparacion->situacion
            ];

            $reparacion->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($reparacion) {
                    if (!Clientes::valorExiste('id_cliente', $reparacion->id_cliente)) {
                        return 'El cliente no existe';
                    }
                    return true;
                }
            ];

            $reparacion->actualizarConRespuesta($validaciones);
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al modificar la reparación: ' . $e->getMessage(), null, 500);
        }
    }

    public static function eliminarReparacion()
    {
        try {
            if (empty($_POST['id_reparacion'])) {
                self::respuestaJSON(0, 'ID de reparación requerido', null, 400);
            }

            $reparacion = Reparaciones::find(['id_reparacion' => $_POST['id_reparacion']]);

            if (!$reparacion) {
                self::respuestaJSON(0, 'Reparación no encontrada', null, 404);
            }

            $reparacion->sincronizar(['situacion' => 0]);
            $reparacion->guardarConRespuesta();
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar la reparación: ' . $e->getMessage(), null, 500);
        }
    }
}
