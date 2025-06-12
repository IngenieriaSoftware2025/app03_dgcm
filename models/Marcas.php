<?php

namespace Model;

use Model\ActiveRecord;

class Marcas extends ActiveRecord
{
    public static $tabla = 'marcas';
    public static $idTabla = ['id_marca'];
    public static $columnasDB = [
        'marca_nombre',
        'situacion'
    ];

    public $id_marca;
    public $marca_nombre;
    public $situacion;

    public function __construct($marca = [])
    {
        $this->id_marca = $marca['id_marca'] ?? null;
        $this->marca_nombre = $marca['marca_nombre'] ?? '';
        $this->situacion = $marca['situacion'] ?? 1;
    }
}
