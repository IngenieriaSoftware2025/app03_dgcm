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
        'numero_factura',
        'fecha_venta',
        'tipo_venta',
        'subtotal',
        'descuento',
        'impuestos',
        'total',
        'metodo_pago',
        'estado_pago',
        'observaciones',
        'fecha_creacion',
        'situacion'
    ];

    public $id_venta;
    public $id_empleado_vendedor;
    public $id_cliente;
    public $numero_factura;
    public $fecha_venta;
    public $tipo_venta;
    public $subtotal;
    public $descuento;
    public $impuestos;
    public $total;
    public $metodo_pago;
    public $estado_pago;
    public $observaciones;
    public $fecha_creacion;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_venta = $args['id_venta'] ?? null;
        $this->id_empleado_vendedor = $args['id_empleado_vendedor'] ?? '';
        $this->id_cliente = $args['id_cliente'] ?? '';
        $this->numero_factura = $args['numero_factura'] ?? '';
        $this->fecha_venta = $args['fecha_venta'] ?? null;
        $this->tipo_venta = $args['tipo_venta'] ?? 'C';
        $this->subtotal = $args['subtotal'] ?? 0;
        $this->descuento = $args['descuento'] ?? 0;
        $this->impuestos = $args['impuestos'] ?? 0;
        $this->total = $args['total'] ?? 0;
        $this->metodo_pago = $args['metodo_pago'] ?? 'Efectivo';
        $this->estado_pago = $args['estado_pago'] ?? 'Pagado';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
