<?php

namespace Model;

use Model\ActiveRecord;

class UsuarioRol extends ActiveRecord
{
    public static $tabla = 'usuario_rol';
    public static $idTabla = ['id_usuario_rol'];
    public static $columnasDB = [
        'id_usuario',
        'id_rol',
        'descripcion',
        'fecha_creacion',
        'situacion'
    ];

    public $id_usuario_rol;
    public $id_usuario;
    public $id_rol;
    public $descripcion;
    public $fecha_creacion;
    public $situacion;

    public function __construct($usuarioRol = [])
    {
        $this->id_usuario_rol = $usuarioRol['id_usuario_rol'] ?? null;
        $this->id_usuario = $usuarioRol['id_usuario'] ?? null;
        $this->id_rol = $usuarioRol['id_rol'] ?? null;
        $this->descripcion = $usuarioRol['descripcion'] ?? '';
        $this->fecha_creacion = $usuarioRol['fecha_creacion'] ?? null;
        $this->situacion = $usuarioRol['situacion'] ?? 1;
    }
}
