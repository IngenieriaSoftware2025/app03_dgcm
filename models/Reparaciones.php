<?php

namespace Model;

use Model\ActiveRecord;

class Reparaciones extends ActiveRecord
{
    public static $tabla = 'reparaciones';
    public static $idTabla = ['id_reparacion'];
    public static $columnasDB = [
        'id_cliente',
        'id_empleado_asignado',
        'id_tipo_servicio',
        'tipo_celular',
        'marca_celular',
        'modelo_celular',
        'imei',
        'motivo',
        'diagnostico',
        'solucion',
        'fecha_ingreso',
        'fecha_asignacion',
        'fecha_inicio_trabajo',
        'fecha_terminado',
        'fecha_entrega',
        'costo_servicio',
        'costo_repuestos',
        'total_cobrado',
        'estado',
        'prioridad',
        'observaciones',
        'fecha_creacion',
        'situacion'
    ];

    public $id_reparacion;
    public $id_cliente;
    public $id_empleado_asignado;
    public $id_tipo_servicio;
    public $tipo_celular;
    public $marca_celular;
    public $modelo_celular;
    public $imei;
    public $motivo;
    public $diagnostico;
    public $solucion;
    public $fecha_ingreso;
    public $fecha_asignacion;
    public $fecha_inicio_trabajo;
    public $fecha_terminado;
    public $fecha_entrega;
    public $costo_servicio;
    public $costo_repuestos;
    public $total_cobrado;
    public $estado;
    public $prioridad;
    public $observaciones;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_reparacion = $args['id_reparacion'] ?? null;
        $this->id_cliente = $args['id_cliente'] ?? '';
        $this->id_empleado_asignado = $args['id_empleado_asignado'] ?? null;
        $this->id_tipo_servicio = $args['id_tipo_servicio'] ?? null;
        $this->tipo_celular = $args['tipo_celular'] ?? '';
        $this->marca_celular = $args['marca_celular'] ?? '';
        $this->modelo_celular = $args['modelo_celular'] ?? '';
        $this->imei = $args['imei'] ?? '';
        $this->motivo = $args['motivo'] ?? '';
        $this->diagnostico = $args['diagnostico'] ?? '';
        $this->solucion = $args['solucion'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? null;
        $this->fecha_asignacion = $args['fecha_asignacion'] ?? null;
        $this->fecha_inicio_trabajo = $args['fecha_inicio_trabajo'] ?? null;
        $this->fecha_terminado = $args['fecha_terminado'] ?? null;
        $this->fecha_entrega = $args['fecha_entrega'] ?? null;
        $this->costo_servicio = $args['costo_servicio'] ?? 0;
        $this->costo_repuestos = $args['costo_repuestos'] ?? 0;
        $this->total_cobrado = $args['total_cobrado'] ?? 0;
        $this->estado = $args['estado'] ?? 'Ingresado';
        $this->prioridad = $args['prioridad'] ?? 'Normal';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
