<?php

// crea nombre de espacio Model
namespace Model;

// Importar ActiveRecord
use Model\ActiveRecord;

// Clase Roles que extiende de ActiveRecord
class Roles extends ActiveRecord
{

    // Atributos de la clase
    protected static $tabla = 'roles';
    protected static $idTabla = 'id_rol';
    protected static $columnasDB = [
        'rol_nombre',
        'situacion'
    ];

    // Propiedades de instancia
    public $id_rol;
    public $rol_nombre;
    public $situacion;

    // Constructor
    public function __construct($rol = [])
    {
        $this->id_rol = $rol['id_rol'] ?? null;
        $this->rol_nombre = $rol['rol_nombre'] ?? '';
        $this->situacion = $rol['situacion'] ?? 1;
    }

    // Metodo para validar que el rol sea unico
    public function validarRolUnico()
    {
        if (!$this->rol_nombre) {
            self::setAlerta('error', 'El nombre del rol es obligatorio');
        }

        // Verificar si el rol ya existe
        if ($this->rol_nombre) {
            $consulta = "SELECT * FROM " . self::$tabla . " WHERE rol_nombre = ? AND id_rol != ?";
            $resultado = self::consultarSQL($consulta, [$this->rol_nombre, $this->id_rol ?? 0]);
            if ($resultado) {
                self::setAlerta('error', 'El nombre del rol ya existe');
            }
        }
        return self::getAlertas();
    }

    //  Metodo para obtener los roles activos
    public static function obtenerRolesActivos()
    {
        $consulta = "SELECT * FROM " . self::$tabla . " WHERE situacion = 1 ORDER BY rol_nombre";
        return self::consultarSQL($consulta);
    }
}
