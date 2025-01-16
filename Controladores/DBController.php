<?php
class DBController {
    public static function crear() {
        $conexion = new PDO("mysql:host=localhost", $_SESSION['DB_user'], $_SESSION['DB_pass']);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE IF NOT EXISTS " . $_SESSION['DB_name'];
        $conexion->exec($sql);
        $conexion = new PDO("mysql:host=localhost;dbname=" . $_SESSION['DB_name'], $_SESSION['DB_user'], $_SESSION['DB_pass']);

        // Crear tablas
        $sql = "
            CREATE TABLE IF NOT EXISTS Titulares (
                id_cliente INT PRIMARY KEY AUTO_INCREMENT,
                nombre VARCHAR(50),
                segundo_nombre VARCHAR(50),
                primer_apellido VARCHAR(50),
                segundo_apellido VARCHAR(50),
                SSN VARCHAR(20),
                alien_number VARCHAR(20),
                genero VARCHAR(10),
                fecha_nacimiento DATE DEFAULT NULL,
                direccion VARCHAR(100),
                ciudad VARCHAR(50),
                estado VARCHAR(50),
                codigo_postal VARCHAR(10),
                telefono VARCHAR(20),
                email VARCHAR(50),
                empresa VARCHAR(50),
                en_poliza VARCHAR(20),
                estatus_migratorio BOOLEAN,
                declaracion_fiscal BOOLEAN,
                actualizado BOOLEAN,
                notas VARCHAR(200)
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Datos_Seguro (
                id_cliente INT,
                policy_number VARCHAR(20),
                member_number VARCHAR(20),
                group_number VARCHAR(20),
                plan_seguro VARCHAR(20),
                PRIMARY KEY (id_cliente),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Conyugues_Dependientes (
                id_miembro_grupo INT PRIMARY KEY AUTO_INCREMENT,
                id_cliente INT,
                nombre VARCHAR(50),
                segundo_nombre VARCHAR(50),
                apellido VARCHAR(50),
                SSN VARCHAR(20),
                alien_number VARCHAR(20),
                genero VARCHAR(10),
                fecha_nacimiento DATE DEFAULT NULL,
                en_poliza VARCHAR(20),
                estatus_migratorio BOOLEAN,
                pareja BOOLEAN,
                relacion VARCHAR(20),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Registros (
                id_registro INT PRIMARY KEY AUTO_INCREMENT,
                id_cliente INT,
                fecha DATE DEFAULT (CURRENT_DATE),
                descripcion VARCHAR(50),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Img (
                id_img INT PRIMARY KEY AUTO_INCREMENT,
                id_cliente INT,
                nombre VARCHAR(50),
                descripcion VARCHAR(255),
                imagen VARCHAR(250),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        header("Location: ?controller=Paneles&action=index");
        exit;
    }
}
