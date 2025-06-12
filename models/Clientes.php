<?php

namespace Model;

use Model\ActiveRecord;

class Clientes extends ActiveRecord
{
    public static $tabla = 'clientes';
    public static $idTabla = ['id_cliente'];
    public static $columnasDB = [
        'id_usuario',
        'fecha_registro',
        'situacion'
    ];

    public $id_cliente;
    public $id_usuario;
    public $fecha_registro;
    public $situacion;

    public function __construct($cliente = [])
    {
        $this->id_cliente = $cliente['id_cliente'] ?? null;
        $this->id_usuario = $cliente['id_usuario'] ?? null;
        $this->fecha_registro = $cliente['fecha_registro'] ?? null;
        $this->situacion = $cliente['situacion'] ?? 1;
    }
}
