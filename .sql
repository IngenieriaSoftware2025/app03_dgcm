CREATE DATABASE app03_carbajal;

CREATE TABLE clientes
(
    id_cliente SERIAL PRIMARY KEY NOT NULL,
    nombres VARCHAR (70) NOT NULL,
    apellidos VARCHAR(70),
    telefono INT,
    sar VARCHAR(20),
    correo VARCHAR(75),
    situacion SMALLINT DEFAULT 1
);

CREATE TABLE usuarios (
    id_usuario SERIAL PRIMARY KEY,
    nombre1  VARCHAR(70)NOT NULL,
    nombre2  VARCHAR(70),
    apellido1 VARCHAR(70) NOT NULL,
    apellido2 VARCHAR(70),
    telefono BIGINT,
    dpi BIGINT,
    correo VARCHAR(100) NOT NULL UNIQUE,
    usuario_clave lVARCHAR(1056) NOT NULL,
    token lVARCHAR(1056),
    fecha_creacion DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    fecha_clave DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    fotografia lVARCHAR(2056),
    situacion SMALLINT  DEFAULT 1
);
