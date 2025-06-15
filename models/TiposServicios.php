<?php

namespace Model;

use Model\ActiveRecord;

class TiposServicios extends ActiveRecord
{
    public static $tabla = 'tipos_servicios';
    public static $idTabla = ['id_tipo_servicio'];
    public static $columnasDB = [
        'descripcion',
        'precio_base',
        'tiempo_estimado',
        'categoria',
        'fecha_creacion',
        'situacion'
    ];

    public $id_tipo_servicio;
    public $descripcion;
    public $precio_base;
    public $tiempo_estimado;
    public $categoria;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_tipo_servicio = $args['id_tipo_servicio'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio_base = $args['precio_base'] ?? 0;
        $this->tiempo_estimado = $args['tiempo_estimado'] ?? 0;
        $this->categoria = $args['categoria'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
