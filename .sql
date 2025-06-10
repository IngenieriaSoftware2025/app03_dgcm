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
    nombre1 VARCHAR(70)NOT NULL,
    nombre2 VARCHAR(70),
    apellido1 VARCHAR(70) NOT NULL,
    apellido2 VARCHAR(70),
    telefono BIGINT,
    dpi BIGINT,
    correo VARCHAR(100) NOT NULL UNIQUE,
    usuario_clave lVARCHAR(1056) NOT NULL,
    token lVARCHAR(1056),
    fecha_creacion DATETIME
    YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    fecha_clave DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    fotografia lVARCHAR
    (2056),
    situacion SMALLINT  DEFAULT 1
);

    CREATE TABLE aplicacion
    (
        id_app SERIAL PRIMARY KEY,
        nombre_app_lg LVARCHAR(2056),
        nombre_app_md LVARCHAR(1056),
        nombre_app_ct LVARCHAR(255),
        fecha_creacion DATETIME
        YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    situacion SMALLINT  DEFAULT 1
);

        CREATE TABLE permisos
        (
            id_permiso SERIAL PRIMARY KEY,
            id_app INT,
            nombre_permiso VARCHAR(70) NOT NULL,
            clave_permiso VARCHAR(70),
            descripcion VARCHAR(255),
            fecha_creacion DATETIME
            YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    situacion SMALLINT  DEFAULT 1
);

            ALTER TABLE permisos 
    ADD CONSTRAINT FOREIGN KEY
            (id_app) 
    REFERENCES aplicacion CONSTRAINT fk_perm_aplicacion;