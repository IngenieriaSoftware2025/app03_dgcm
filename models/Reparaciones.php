<?php

namespace Model;

use Model\ActiveRecord;

class Reparaciones extends ActiveRecord
{
    public static $tabla = 'reparaciones';
    public static $idTabla = ['id_reparacion'];
    public static $columnasDB = [
        'id_cliente',
        'id_celular',
        'id_tipo_servicio',
        'id_empleado_asignado',
        'motivo',
        'fecha_ingreso',
        'fecha_entrega',
        'costo_servicio',
        'estado'
    ];

    public $id_reparacion;
    public $id_cliente;
    public $id_celular;
    public $id_tipo_servicio;
    public $id_empleado_asignado;
    public $motivo;
    public $fecha_ingreso;
    public $fecha_entrega;
    public $costo_servicio;
    public $estado;

    public function __construct($reparacion = [])
    {
        $this->id_reparacion = $reparacion['id_reparacion'] ?? null;
        $this->id_cliente = $reparacion['id_cliente'] ?? null;
        $this->id_celular = $reparacion['id_celular'] ?? null;
        $this->id_tipo_servicio = $reparacion['id_tipo_servicio'] ?? null;
        $this->id_empleado_asignado = $reparacion['id_empleado_asignado'] ?? null;
        $this->motivo = $reparacion['motivo'] ?? '';
        $this->fecha_ingreso = $reparacion['fecha_ingreso'] ?? null;
        $this->fecha_entrega = $reparacion['fecha_entrega'] ?? null;
        $this->costo_servicio = $reparacion['costo_servicio'] ?? 0.00;
        $this->estado = $reparacion['estado'] ?? 'Ingresado';
    }
}
