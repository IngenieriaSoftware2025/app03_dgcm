<?php

namespace Model;

use Model\ActiveRecord;

class MovimientosInventario extends ActiveRecord
{
    public static $tabla = 'movimientos_inventario';
    public static $idTabla = ['id_movimiento'];
    public static $columnasDB = [
        'id_celular',
        'id_empleado',
        'tipo_movimiento',
        'cantidad',
        'stock_anterior',
        'stock_nuevo',
        'motivo',
        'referencia',
        'fecha_movimiento',
        'situacion'
    ];

    public $id_movimiento;
    public $id_celular;
    public $id_empleado;
    public $tipo_movimiento;
    public $cantidad;
    public $stock_anterior;
    public $stock_nuevo;
    public $motivo;
    public $referencia;
    public $fecha_movimiento;
    public $situacion;

    public function __construct($args = [])
    {
        $this->id_movimiento = $args['id_movimiento'] ?? null;
        $this->id_celular = $args['id_celular'] ?? '';
        $this->id_empleado = $args['id_empleado'] ?? '';
        $this->tipo_movimiento = $args['tipo_movimiento'] ?? 'Entrada';
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->stock_anterior = $args['stock_anterior'] ?? 0;
        $this->stock_nuevo = $args['stock_nuevo'] ?? 0;
        $this->motivo = $args['motivo'] ?? '';
        $this->referencia = $args['referencia'] ?? '';
        $this->fecha_movimiento = $args['fecha_movimiento'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
    }
}
