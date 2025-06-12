<?php

namespace Model;

use Model\ActiveRecord;

class Celulares extends ActiveRecord
{
    public static $tabla = 'celulares';
    public static $idTabla = ['id_celular'];
    public static $columnasDB = [
        'id_marca',
        'modelo',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'cantidad',
        'situacion'
    ];

    public $id_celular;
    public $id_marca;
    public $modelo;
    public $descripcion;
    public $precio_compra;
    public $precio_venta;
    public $cantidad;
    public $situacion;

    public function __construct($celular = [])
    {
        $this->id_celular = $celular['id_celular'] ?? null;
        $this->id_marca = $celular['id_marca'] ?? null;
        $this->modelo = $celular['modelo'] ?? '';
        $this->descripcion = $celular['descripcion'] ?? '';
        $this->precio_compra = $celular['precio_compra'] ?? 0.00;
        $this->precio_venta = $celular['precio_venta'] ?? 0.00;
        $this->cantidad = $celular['cantidad'] ?? 0;
        $this->situacion = $celular['situacion'] ?? 1;
    }
}
