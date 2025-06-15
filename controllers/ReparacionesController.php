<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Reparaciones;
use Model\Clientes;
use Model\Celulares;
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
            $validacion = self::validarRequeridos($_POST, [
                'id_cliente',
                'id_celular',
                'motivo'
            ]);

            if ($validacion !== true) {
                self::respuestaJSON(0, $validacion, null, 400);
            }

            $datos = self::sanitizarDatos($_POST);

            $reparacion = new Reparaciones([
                'id_cliente' => filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT),
                'id_empleado_asignado' => !empty($datos['id_empleado_asignado']) ? filter_var($datos['id_empleado_asignado'], FILTER_SANITIZE_NUMBER_INT) : null,
                'id_tipo_servicio' => !empty($datos['id_tipo_servicio']) ? filter_var($datos['id_tipo_servicio'], FILTER_SANITIZE_NUMBER_INT) : null,
                'id_celular' => filter_var($datos['id_celular'], FILTER_SANITIZE_NUMBER_INT),
                'imei' => $datos['imei'] ?? '',
                'motivo' => ucfirst(trim($datos['motivo'])),
                'diagnostico' => $datos['diagnostico'] ?? '',
                'solucion' => $datos['solucion'] ?? '',
                'fecha_ingreso' => date('Y-m-d H:i:s'),
                'fecha_asignacion' => null,
                'fecha_inicio_trabajo' => null,
                'fecha_terminado' => null,
                'fecha_entrega' => null,
                'costo_servicio' => !empty($datos['costo_servicio']) ? floatval($datos['costo_servicio']) : 0.00,
                'costo_repuestos' => !empty($datos['costo_repuestos']) ? floatval($datos['costo_repuestos']) : 0.00,
                'total_cobrado' => !empty($datos['total_cobrado']) ? floatval($datos['total_cobrado']) : 0.00,
                'estado' => $datos['estado'] ?? 'Ingresado',
                'prioridad' => $datos['prioridad'] ?? 'Normal',
                'observaciones' => $datos['observaciones'] ?? '',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'situacion' => 1
            ]);

            $validaciones = [
                function ($reparacion) {
                    // Validar longitud del motivo
                    if (strlen($reparacion->motivo) < 10) return 'El motivo debe tener al menos 10 caracteres';

                    // Validar que el cliente exista
                    if (!Reparaciones::valorExiste('id_cliente', $reparacion->id_cliente, null, 'id_cliente')) {
                        // Verificar en tabla clientes
                        $query = "SELECT COUNT(*) as total FROM clientes WHERE id_cliente = " . self::$db->quote($reparacion->id_cliente);
                        $resultado = self::fetchArray($query);
                        if (!$resultado || $resultado[0]['total'] == 0) {
                            return 'El cliente seleccionado no existe';
                        }
                    }

                    // Validar que el celular exista
                    $query = "SELECT COUNT(*) as total FROM celulares WHERE id_celular = " . self::$db->quote($reparacion->id_celular);
                    $resultado = self::fetchArray($query);
                    if (!$resultado || $resultado[0]['total'] == 0) {
                        return 'El celular seleccionado no existe';
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
                    'tabla'  => 'clientes',
                    'alias'  => 'c',
                    'llave_local'  => 'id_cliente',
                    'llave_foranea' => 'id_cliente',
                    'campos' => [
                        'cliente_nombre' => 'nombres',
                        'cliente_apellido' => 'apellidos'
                    ],
                    'tipo' => 'INNER'
                ],
                [
                    'tabla'  => 'empleados',
                    'alias'    => 'e',
                    'llave_local'  => 'id_empleado_asignado',
                    'llave_foranea' => 'id_empleado',
                    'campos'   => [
                        'empleado_codigo' => 'codigo_empleado'
                    ],
                    'tipo' => 'LEFT'
                ],
                [
                    'tabla'  => 'tipos_servicios',
                    'alias' => 'ts',
                    'llave_local'  => 'id_tipo_servicio',
                    'llave_foranea' => 'id_tipo_servicio',
                    'campos' => [
                        'servicio_desc' => 'descripcion'
                    ],
                    'tipo' => 'LEFT'
                ],
                [
                    'tabla'  => 'celulares',
                    'alias'  => 'cel',
                    'llave_local' => 'id_celular',
                    'llave_foranea' => 'id_celular',
                    'campos'  => [
                        'modelo_celular' => 'modelo'
                    ],
                    'tipo' => 'INNER'
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
                'id_cliente' => !empty($datos['id_cliente']) ? filter_var($datos['id_cliente'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_cliente,
                'id_empleado_asignado' => !empty($datos['id_empleado_asignado']) ? filter_var($datos['id_empleado_asignado'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_empleado_asignado,
                'id_tipo_servicio' => !empty($datos['id_tipo_servicio']) ? filter_var($datos['id_tipo_servicio'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_tipo_servicio,
                'id_celular' => !empty($datos['id_celular']) ? filter_var($datos['id_celular'], FILTER_SANITIZE_NUMBER_INT) : $reparacion->id_celular,
                'imei' => $datos['imei'] ?? $reparacion->imei,
                'motivo' => !empty($datos['motivo']) ? ucfirst(trim($datos['motivo'])) : $reparacion->motivo,
                'diagnostico' => $datos['diagnostico'] ?? $reparacion->diagnostico,
                'solucion' => $datos['solucion'] ?? $reparacion->solucion,
                'fecha_asignacion' => $datos['fecha_asignacion'] ?? $reparacion->fecha_asignacion,
                'fecha_inicio_trabajo' => $datos['fecha_inicio_trabajo'] ?? $reparacion->fecha_inicio_trabajo,
                'fecha_terminado' => $datos['fecha_terminado'] ?? $reparacion->fecha_terminado,
                'fecha_entrega' => $datos['fecha_entrega'] ?? $reparacion->fecha_entrega,
                'costo_servicio' => !empty($datos['costo_servicio']) ? floatval($datos['costo_servicio']) : $reparacion->costo_servicio,
                'costo_repuestos' => !empty($datos['costo_repuestos']) ? floatval($datos['costo_repuestos']) : $reparacion->costo_repuestos,
                'total_cobrado' => !empty($datos['total_cobrado']) ? floatval($datos['total_cobrado']) : $reparacion->total_cobrado,
                'estado' => $datos['estado'] ?? $reparacion->estado,
                'prioridad' => $datos['prioridad'] ?? $reparacion->prioridad,
                'observaciones' => $datos['observaciones'] ?? $reparacion->observaciones
            ];

            $reparacion->sincronizar($datosParaSincronizar);

            $validaciones = [
                function ($reparacion) {
                    if (strlen($reparacion->motivo) < 10) return 'El motivo debe tener al menos 10 caracteres';

                    // Validar que el cliente exista
                    $query = "SELECT COUNT(*) as total FROM clientes WHERE id_cliente = " . self::$db->quote($reparacion->id_cliente);
                    $resultado = self::fetchArray($query);
                    if (!$resultado || $resultado[0]['total'] == 0) {
                        return 'El cliente seleccionado no existe';
                    }

                    // Validar que el celular exista
                    $query = "SELECT COUNT(*) as total FROM celulares WHERE id_celular = " . self::$db->quote($reparacion->id_celular);
                    $resultado = self::fetchArray($query);
                    if (!$resultado || $resultado[0]['total'] == 0) {
                        return 'El celular seleccionado no existe';
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
            // Validar que llegue el ID
            if (empty($_POST['id_reparacion'])) {
                self::respuestaJSON(0, 'ID de reparación requerido', null, 400);
            }

            $id = $_POST['id_reparacion'];

            // Eliminar lógicamente usando helper
            Reparaciones::eliminarLogicoConRespuesta($id, 'id_reparacion');
        } catch (Exception $e) {
            self::respuestaJSON(0, 'Error al eliminar reparación: ' . $e->getMessage(), null, 500);
        }
    }
}
