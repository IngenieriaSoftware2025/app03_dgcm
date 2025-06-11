CREATE DATABASE app03_carbajal;

CREATE TABLE roles
(
    id_rol SERIAL PRIMARY KEY,
    rol_nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(250),
    situacion SMALLINT DEFAULT 1 CHECK (situacion IN (0,1))
);

CREATE TABLE usuarios
(
    id_usuario SERIAL PRIMARY KEY,
    nombre1 VARCHAR(70) NOT NULL,
    nombre2 VARCHAR(70),
    apellido1 VARCHAR(70) NOT NULL,
    apellido2 VARCHAR(70),
    telefono BIGINT,
    dpi BIGINT,
    correo VARCHAR(100) NOT NULL UNIQUE,
    usuario_clave VARCHAR(150) NOT NULL,
    token VARCHAR(150),
    fecha_creacion DATETIME
    YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    fecha_clave    DATETIME      YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    fotografia     VARCHAR
    (255),
    situacion      SMALLINT      DEFAULT 1 CHECK
    (situacion IN
    (0,1)),
    rol VARCHAR
    (20) DEFAULT 'cliente' CHECK
    (rol IN
    ('cliente','empleado','administrador'))
);

    CREATE TABLE usuario_rol
    (
        id_usuario_rol SERIAL PRIMARY KEY,
        id_usuario INTEGER NOT NULL,
        id_rol INTEGER NOT NULL,
        descripcion VARCHAR(255),
        fecha_creacion DATETIME
        YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    situacion   SMALLINT DEFAULT 1 CHECK
        (situacion IN
        (0,1))
);

        ALTER TABLE usuario_rol ADD CONSTRAINT FOREIGN KEY
        (id_usuario) 
    REFERENCES usuarios CONSTRAINT fk_usuario_rol_usuarios;

        ALTER TABLE usuario_rol ADD CONSTRAINT FOREIGN KEY
        (id_rol) 
    REFERENCES roles CONSTRAINT fk_usuario_rol_roles;