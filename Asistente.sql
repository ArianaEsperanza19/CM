USE bahv4pjuf5svbwvj9hok;
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
    declaracion_fiscales BOOLEAN,
    notas VARCHAR(200),
    actualizado BOOLEAN
);

CREATE TABLE Datos_Seguro(
    id_cliente INT,
    policy_number VARCHAR(20),
    member_number VARCHAR(20),
    group_number VARCHAR(20),
    PRIMARY KEY (id_cliente), 
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

CREATE TABLE Conyugues_Dependientes(
    id_cliente INT,
    nombre VARCHAR(50),
    segundo_nombre VARCHAR(50),
    apellido VARCHAR(50),
    SSN VARCHAR(20),
    alien_number VARCHAR(20), 
    genero VARCHAR(10),
    fecha_nacimiento DATE,
    estatus_migratorio BOOLEAN,
    pareja BOOLEAN,
    PRIMARY KEY (id_cliente),
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);

CREATE TABLE Cuentas(
    id_cliente INT,
    numero_cuenta VARCHAR(20),
    tipo_cuenta VARCHAR(20),
    PRIMARY KEY (id_cliente),
    FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
);
