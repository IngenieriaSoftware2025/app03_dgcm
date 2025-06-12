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
        'cantidad',
        'precio_unitario'
    ];

    public $id_detalle;
    public $id_venta;
    public $id_celular;
    public $id_reparacion;
    public $cantidad;
    public $precio_unitario;

    public function __construct($detalle = [])
    {
        $this->id_detalle = $detalle['id_detalle'] ?? null;
        $this->id_venta = $detalle['id_venta'] ?? null;
        $this->id_celular = $detalle['id_celular'] ?? null;
        $this->id_reparacion = $detalle['id_reparacion'] ?? null;
        $this->cantidad = $detalle['cantidad'] ?? 1;
        $this->precio_unitario = $detalle['precio_unitario'] ?? 0.00;
    }
}
