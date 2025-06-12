<?php

namespace Model;

use Model\ActiveRecord;

class ClientesConfiguracion extends ActiveRecord
{
    public static $tabla = 'clientes_configuracion';
    public static $idTabla = ['id_config'];
    public static $columnasDB = [
        'id_cliente',
        'direccion_principal',
        'ciudad',
        'estado',
        'codigo_postal',
        'pais',
        'telefono_contacto',
        'direcciones_adicionales',
        'metodos_pago',
        'notificaciones_email',
        'notificaciones_sms',
        'newsletter',
        'idioma',
        'moneda',
        'fecha_creacion',
        'fecha_modificacion'
    ];

    public $id_config;
    public $id_cliente;
    public $direccion_principal;
    public $ciudad;
    public $estado;
    public $codigo_postal;
    public $pais;
    public $telefono_contacto;
    public $direcciones_adicionales;
    public $metodos_pago;
    public $notificaciones_email;
    public $notificaciones_sms;
    public $newsletter;
    public $idioma;
    public $moneda;
    public $fecha_creacion;
    public $fecha_modificacion;

    public function __construct($config = [])
    {
        $this->id_config = $config['id_config'] ?? null;
        $this->id_cliente = $config['id_cliente'] ?? null;
        $this->direccion_principal = $config['direccion_principal'] ?? '';
        $this->ciudad = $config['ciudad'] ?? '';
        $this->estado = $config['estado'] ?? '';
        $this->codigo_postal = $config['codigo_postal'] ?? '';
        $this->pais = $config['pais'] ?? 'Guatemala';
        $this->telefono_contacto = $config['telefono_contacto'] ?? '';
        $this->direcciones_adicionales = $config['direcciones_adicionales'] ?? '';
        $this->metodos_pago = $config['metodos_pago'] ?? '';
        $this->notificaciones_email = $config['notificaciones_email'] ?? 1;
        $this->notificaciones_sms = $config['notificaciones_sms'] ?? 0;
        $this->newsletter = $config['newsletter'] ?? 1;
        $this->idioma = $config['idioma'] ?? 'es';
        $this->moneda = $config['moneda'] ?? 'GTQ';
        $this->fecha_creacion = $config['fecha_creacion'] ?? null;
        $this->fecha_modificacion = $config['fecha_modificacion'] ?? null;
    }
}
