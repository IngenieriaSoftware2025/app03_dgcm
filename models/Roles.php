<?php

// crea nombre de espacio Model
namespace Model;

// Importa la clase ActiveRecord del nombre de espacio Model
use Model\ActiveRecord;

// Crea la clase de instancia Roles y hereda las funciones de ActiveRecord
class Roles extends ActiveRecord
{

    // Crea las propiedades de la clase
    public static $tabla = 'roles';
    public static $idTabla = ['id_rol'];
    public static $columnasDB = [
        'rol_nombre',
        'descripcion',
        'situacion'
    ];

    // Crea las variables para almacenar los datos
    public $id_rol;
    public $rol_nombre;
    public $descripcion;
    public $situacion;

    public function __construct($rol = [])
    {
        $this->id_rol = $rol['id_rol'] ?? null;
        $this->rol_nombre = $rol['rol_nombre'] ?? '';
        $this->descripcion = $rol['descripcion'] ?? '';
        $this->situacion = $rol['situacion'] ?? 1;
    }
}
