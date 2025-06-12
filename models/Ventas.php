<?php

namespace Model;

use Model\ActiveRecord;

class Ventas extends ActiveRecord
{
    public static $tabla = 'ventas';
    public static $idTabla = ['id_venta'];
    public static $columnasDB = [
        'id_empleado_vendedor',
        'id_cliente',
        'fecha_venta',
        'tipo',
        'total',
        'situacion'
    ];

    public $id_venta;
    public $id_empleado_vendedor;
    public $id_cliente;
    public $fecha_venta;
    public $tipo;
    public $total;
    public $situacion;

    public function __construct($venta = [])
    {
        $this->id_venta = $venta['id_venta'] ?? null;
        $this->id_empleado_vendedor = $venta['id_empleado_vendedor'] ?? null;
        $this->id_cliente = $venta['id_cliente'] ?? null;
        $this->fecha_venta = $venta['fecha_venta'] ?? null;
        $this->tipo = $venta['tipo'] ?? 'C';
        $this->total = $venta['total'] ?? 0.00;
        $this->situacion = $venta['situacion'] ?? 1;
    }
}
