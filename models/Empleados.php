<?php

namespace Model;

use Model\ActiveRecord;

class Empleados extends ActiveRecord
{
    public static $tabla = 'empleados';
    public static $idTabla = ['id_empleado'];
    public static $columnasDB = [
        'id_usuario',
        'codigo_empleado',
        'puesto',
        'salario',
        'fecha_ingreso',
        'especialidad',
        'fecha_creacion',
        'situacion'
    ];

    public $id_empleado;
    public $id_usuario;
    public $codigo_empleado;
    public $puesto;
    public $salario;
    public $fecha_ingreso;
    public $especialidad;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_empleado = $args['id_empleado'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->codigo_empleado = $args['codigo_empleado'] ?? '';
        $this->puesto = $args['puesto'] ?? '';
        $this->salario = $args['salario'] ?? 0;
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? null;
        $this->especialidad = $args['especialidad'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
