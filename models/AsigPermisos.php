<?php

// crea nombre de espacio Model
namespace Model;

// Importa la clase ActiveRecord del nombre de espacio Model
use Model\ActiveRecord;

// Crea la clase de instancia AsigPermisos y hereda las funciones de ActiveRecord
class AsigPermisos extends ActiveRecord
{
    // Crea las propiedades de la clase
    public static $tabla = 'asig_permisos';
    public static $idTabla = ['id_asig_permiso'];
    public static $columnasDB = [
        'id_usuario',
        'id_app',
        'id_permiso',
        'fecha_creacion',
        'usuario_asigno',
        'motivo',
        'situacion'
    ];

    // Crea las variables para almacenar los datos
    public $id_asig_permiso;
    public $id_usuario;
    public $id_app;
    public $id_permiso;
    public $fecha_creacion;
    public $usuario_asigno;
    public $motivo;
    public $situacion;

    public function __construct($asignacion = [])
    {
        $this->id_asig_permiso = $asignacion['id_asig_permiso'] ?? null;
        $this->id_usuario = $asignacion['id_usuario'] ?? '';
        $this->id_app = $asignacion['id_app'] ?? '';
        $this->id_permiso = $asignacion['id_permiso'] ?? '';
        $this->fecha_creacion = $asignacion['fecha_creacion'] ?? null;
        $this->usuario_asigno = $asignacion['usuario_asigno'] ?? '';
        $this->motivo = $asignacion['motivo'] ?? '';
        $this->situacion = $asignacion['situacion'] ?? 1;
    }
}
