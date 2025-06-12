<?php

namespace Model;

use Model\ActiveRecord;

class Empleados extends ActiveRecord
{
    public static $tabla = 'empleados';
    public static $idTabla = ['id_empleado'];
    public static $columnasDB = [
        'id_usuario',
        'departamento',
        'puesto',
        'fecha_ingreso',
        'situacion'
    ];

    public $id_empleado;
    public $id_usuario;
    public $departamento;
    public $puesto;
    public $fecha_ingreso;
    public $situacion;

    public function __construct($empleado = [])
    {
        $this->id_empleado = $empleado['id_empleado'] ?? null;
        $this->id_usuario = $empleado['id_usuario'] ?? null;
        $this->departamento = $empleado['departamento'] ?? '';
        $this->puesto = $empleado['puesto'] ?? '';
        $this->fecha_ingreso = $empleado['fecha_ingreso'] ?? null;
        $this->situacion = $empleado['situacion'] ?? 1;
    }
}
