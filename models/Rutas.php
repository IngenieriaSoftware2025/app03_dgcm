<?php

namespace Model;

use Model\ActiveRecord;

class Rutas extends ActiveRecord
{
    public static $tabla = 'rutas';
    public static $idTabla = ['id_ruta'];
    public static $columnasDB = [
        'id_app',
        'descripcion',
        'situacion'
    ];

    public $id_ruta;
    public $id_app;
    public $descripcion;
    public $situacion;

    public function __construct($datos = [])
    {
        $this->id_ruta = $datos['id_ruta'] ?? null;
        $this->id_app = $datos['id_app'] ?? '';
        $this->descripcion = $datos['descripcion'] ?? '';
        $this->situacion = $datos['situacion'] ?? 1;
    }
}
