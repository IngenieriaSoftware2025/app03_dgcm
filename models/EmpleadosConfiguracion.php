<?php

namespace Model;

use Model\ActiveRecord;

class EmpleadosConfiguracion extends ActiveRecord
{
    public static $tabla = 'empleados_configuracion';
    public static $idTabla = ['id_config'];
    public static $columnasDB = [
        'id_empleado',
        'notificaciones_email',
        'notificaciones_sms',
        'idioma',
        'tema_preferido',
        'fecha_creacion',
        'fecha_modificacion'
    ];

    public $id_config;
    public $id_empleado;
    public $notificaciones_email;
    public $notificaciones_sms;
    public $idioma;
    public $tema_preferido;
    public $fecha_creacion;
    public $fecha_modificacion;

    public function __construct($config = [])
    {
        $this->id_config = $config['id_config'] ?? null;
        $this->id_empleado = $config['id_empleado'] ?? null;
        $this->notificaciones_email = $config['notificaciones_email'] ?? 1;
        $this->notificaciones_sms = $config['notificaciones_sms'] ?? 0;
        $this->idioma = $config['idioma'] ?? 'es';
        $this->tema_preferido = $config['tema_preferido'] ?? 'claro';
        $this->fecha_creacion = $config['fecha_creacion'] ?? null;
        $this->fecha_modificacion = $config['fecha_modificacion'] ?? null;
    }
}
