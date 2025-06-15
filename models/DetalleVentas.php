<?php

namespace Model;

use Model\ActiveRecord;

class DetalleVentas extends ActiveRecord
{
    public static $tabla = 'detalle_ventas';
    public static $idTabla = ['id_detalle'];
    public static $columnasDB = [
        'id_venta',
        'id_celular',
        'id_reparacion',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento_item',
        'subtotal_item',
        'fecha_creacion',
        'situacion'
    ];

    public $id_detalle;
    public $id_venta;
    public $id_celular;
    public $id_reparacion;
    public $descripcion;
    public $cantidad;
    public $precio_unitario;
    public $descuento_item;
    public $subtotal_item;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_detalle = $args['id_detalle'] ?? null;
        $this->id_venta = $args['id_venta'] ?? '';
        $this->id_celular = $args['id_celular'] ?? null;
        $this->id_reparacion = $args['id_reparacion'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 1;
        $this->precio_unitario = $args['precio_unitario'] ?? 0;
        $this->descuento_item = $args['descuento_item'] ?? 0;
        $this->subtotal_item = $args['subtotal_item'] ?? 0;
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
