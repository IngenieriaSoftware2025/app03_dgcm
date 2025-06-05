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