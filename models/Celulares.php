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
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'color',
        'almacenamiento',
        'ram',
        'estado',
        'fecha_ingreso',
        'fecha_creacion',
        'situacion'
    ];

    public $id_celular;
    public $id_marca;
    public $modelo;
    public $precio_compra;
    public $precio_venta;
    public $stock_actual;
    public $stock_minimo;
    public $color;
    public $almacenamiento;
    public $ram;
    public $estado;
    public $fecha_ingreso;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_celular = $args['id_celular'] ?? null;
        $this->id_marca = $args['id_marca'] ?? '';
        $this->modelo = $args['modelo'] ?? '';
        $this->precio_compra = $args['precio_compra'] ?? 0;
        $this->precio_venta = $args['precio_venta'] ?? 0;
        $this->stock_actual = $args['stock_actual'] ?? 0;
        $this->stock_minimo = $args['stock_minimo'] ?? 5;
        $this->color = $args['color'] ?? '';
        $this->almacenamiento = $args['almacenamiento'] ?? '';
        $this->ram = $args['ram'] ?? '';
        $this->estado = $args['estado'] ?? 'Nuevo';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? null;
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
