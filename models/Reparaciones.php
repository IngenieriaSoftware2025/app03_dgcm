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
        'id_celular',
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
    public $id_celular;
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
        $this->id_reparacion = $reparacion['id_reparacion'] ?? null;
        $this->id_cliente = $reparacion['id_cliente'] ?? '';
        $this->id_empleado_asignado = $reparacion['id_empleado_asignado'] ?? null;
        $this->id_tipo_servicio = $reparacion['id_tipo_servicio'] ?? null;
        $this->id_celular = $reparacion['id_celular'] ?? null;
        $this->imei = $reparacion['imei'] ?? '';
        $this->motivo = $reparacion['motivo'] ?? '';
        $this->diagnostico = $reparacion['diagnostico'] ?? '';
        $this->solucion = $reparacion['solucion'] ?? '';
        $this->fecha_ingreso = $reparacion['fecha_ingreso'] ?? null;
        $this->fecha_asignacion = $reparacion['fecha_asignacion'] ?? null;
        $this->fecha_inicio_trabajo = $reparacion['fecha_inicio_trabajo'] ?? null;
        $this->fecha_terminado = $reparacion['fecha_terminado'] ?? null;
        $this->fecha_entrega = $reparacion['fecha_entrega'] ?? null;
        $this->costo_servicio = $reparacion['costo_servicio'] ?? 0.00;
        $this->costo_repuestos = $reparacion['costo_repuestos'] ?? 0.00;
        $this->total_cobrado = $reparacion['total_cobrado'] ?? 0.00;
        $this->estado = $reparacion['estado'] ?? 'Ingresado';
        $this->prioridad = $reparacion['prioridad'] ?? 'Normal';
        $this->observaciones = $reparacion['observaciones'] ?? '';
        $this->fecha_creacion = $reparacion['fecha_creacion'] ?? null;
        $this->situacion = $reparacion['situacion'] ?? 1;
    }

    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            $columna = strtolower($columna);

            // Solo agregar si la propiedad existe y no es null
            if (property_exists($this, $columna)) {
                $atributos[$columna] = $this->$columna;
            }
        }
        return $atributos;
    }
}
