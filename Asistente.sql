CREATE DATABASE AsistenteSeguros;
USE AsistenteSeguros;
CREATE TABLE Titulares(
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50),
    segundo_apellido VARCHAR(50),
    SSN VARCHAR(20),
    alien_number VARCHAR(20), 
    genero VARCHAR(10),
    fecha_nacimiento DATE,
    direccion VARCHAR(100),
    ciudad VARCHAR(50),
    estado VARCHAR(50),
    codigo_postal VARCHAR(10),
    telefono VARCHAR(20),
    email VARCHAR(50),
    empresa VARCHAR(50),
    estatus_migratorio BOOLEAN,
    declaracion_fiscal BOOLEAN,
    actualizado BOOLEAN,
    notas VARCHAR(200)
);

CREATE TABLE Datos_Seguro(
    id_cliente INT,
    policy_number VARCHAR(20),
    member_number VARCHAR(20),
    group_number VARCHAR(20),
    plan_seguro VARCHAR(20),
    PRIMARY KEY (id_cliente), 
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

CREATE TABLE Conyugues_Dependientes(
    id_miembro_grupo INT AUTO_INCREMENT,
    id_cliente INT,
    nombre VARCHAR(50),
    segundo_nombre VARCHAR(50),
    apellido VARCHAR(50),
    SSN VARCHAR(20),
    alien_number VARCHAR(20), 
    genero VARCHAR(10),
    fecha_nacimiento DATE,
    en_poliza VARCHAR(20),
    estatus_migratorio BOOLEAN,
    pareja BOOLEAN,
    PRIMARY KEY (id_miembro_grupo),
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

CREATE TABLE Cuentas(
    id_cliente INT,
    numero_cuenta VARCHAR(20),
    tipo_cuenta VARCHAR(20),
    PRIMARY KEY (id_cliente),
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

CREATE TABLE Registros (
    id_registro INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    fecha DATE,
    descripcion VARCHAR(50),
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

CREATE TABLE Imagenes (
    id_img INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    imagen LONGBLOB,
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

