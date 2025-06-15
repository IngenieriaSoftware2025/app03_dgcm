<?php

namespace Model;

use Model\ActiveRecord;

class Marcas extends ActiveRecord
{
    public static $tabla = 'marcas';
    public static $idTabla = ['id_marca'];
    public static $columnasDB = [
        'nombre_marca',
        'pais_origen',
        'fecha_creacion',
        'situacion'
    ];

    public $id_marca;
    public $nombre_marca;
    public $pais_origen;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_marca = $args['id_marca'] ?? null;
        $this->nombre_marca = $args['nombre_marca'] ?? '';
        $this->pais_origen = $args['pais_origen'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
