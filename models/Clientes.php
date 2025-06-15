<?php

namespace Model;

use Model\ActiveRecord;

class Clientes extends ActiveRecord
{
    public static $tabla = 'clientes';
    public static $idTabla = ['id_cliente'];
    public static $columnasDB = [
        'nombres',
        'apellidos',
        'telefono',
        'celular',
        'nit',
        'correo',
        'direccion',
        'fecha_creacion',
        'situacion'
    ];

    public $id_cliente;
    public $nombres;
    public $apellidos;
    public $telefono;
    public $celular;
    public $nit;
    public $correo;
    public $direccion;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_cliente = $args['id_cliente'] ?? null;
        $this->nombres = $args['nombres'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->celular = $args['celular'] ?? '';
        $this->nit = $args['nit'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
