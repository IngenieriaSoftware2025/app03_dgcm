<?php

namespace Model;

use Model\ActiveRecord;

class TipoServicio extends ActiveRecord
{
    public static $tabla = 'tipo_servicio';
    public static $idTabla = ['id_tipo_servicio'];
    public static $columnasDB = [
        'descripcion',
        'costo_base',
        'situacion'
    ];

    public $id_tipo_servicio;
    public $descripcion;
    public $costo_base;
    public $situacion;

    public function __construct($tipoServicio = [])
    {
        $this->id_tipo_servicio = $tipoServicio['id_tipo_servicio'] ?? null;
        $this->descripcion = $tipoServicio['descripcion'] ?? '';
        $this->costo_base = $tipoServicio['costo_base'] ?? 0.00;
        $this->situacion = $tipoServicio['situacion'] ?? 1;
    }
}
