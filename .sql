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

CREATE TABLE usuarios
(
    id_usuario SERIAL PRIMARY KEY,
    nombre1 VARCHAR(70)NOT NULL,
    nombre2 VARCHAR(70),
    apellido1 VARCHAR(70) NOT NULL,
    apellido2 VARCHAR(70),
    telefono INT,
    dpi INT,
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

        -------------------------------

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
            ----------------------------------------------------------------------
            CREATE TABLE asig_permisos
            (
                id_asig_permiso SERIAL PRIMARY KEY,
                id_usuario INT,
                id_app INT,
                id_permiso INT,
                fecha_creacion DATETIME
                YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    usuario_asigno INT,
    motivo LVARCHAR
                (255),
    situacion SMALLINT  DEFAULT 1
);

                ALTER TABLE asig_permisos 
    ADD CONSTRAINT FOREIGN KEY
                (id_usuario) 
    REFERENCES usuarios CONSTRAINT fk_permisos_usuarios;

                ALTER TABLE asig_permisos 
    ADD CONSTRAINT FOREIGN KEY
                (id_app) 
    REFERENCES aplicacion CONSTRAINT fk_permisos_aplicacion;

                ALTER TABLE asig_permisos 
    ADD CONSTRAINT FOREIGN KEY
                (id_permiso) 
    REFERENCES permisos CONSTRAINT fk_permisos_asig;
                --------------------------------------------------------
                CREATE TABLE historial_act
                (
                    id_hist_act SERIAL PRIMARY KEY,
                    id_usuario INT,
                    id_ruta INT,
                    fecha_creacion DATETIME
                    YEAR TO MINUTE,
    ejecucion LVARCHAR
                    (2056),
    situacion SMALLINT  DEFAULT 1
);

                    ALTER TABLE historial_act 
    ADD CONSTRAINT FOREIGN KEY
                    (id_usuario) 
    REFERENCES usuarios CONSTRAINT fk_historial_usuarios;

                    ALTER TABLE historial_act 
    ADD CONSTRAINT FOREIGN KEY
                    (id_ruta) 
    REFERENCES rutas CONSTRAINT fk_historial_rutas;
                    ----------------------------
                    CREATE TABLE rutas
                    (
                        id_ruta SERIAL PRIMARY KEY,
                        id_app INT,
                        descripcion LVARCHAR(2056),
                        situacion SMALLINT DEFAULT 1
                    );

                    ALTER TABLE rutas 
    ADD CONSTRAINT FOREIGN KEY
                    (id_app) 
    REFERENCES aplicacion CONSTRAINT fk_rutas_aplicacion;