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

CREATE TABLE roles
(
    id_rol SERIAL PRIMARY KEY,
    rol_nombre VARCHAR(50) NOT NULL UNIQUE,
    situacion SMALLINT DEFAULT 1
        CHECK (situacion IN (0,1))
);