<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir . '/CustomersManager/Config/DB.php';
class DBController
{
    private $DB;
    public function __construct()
    {
        $this->DB = DB::Connect();
    }
    /**
     * Crea la base de datos y todas las tablas necesarias.
     *
     * Crea la base de datos y todas las tablas necesarias.
     * Si ya existe la base de datos, no hace nada.
     * Si ya existen las tablas, no hace nada.
     * Redirige a la pantalla de inicio.
     *
     * @return void
     */
    public static function crear()
    {
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
                codigo_postal INT(10),
                telefono VARCHAR(20),
                email VARCHAR(50),
                empresa VARCHAR(50),
                en_poliza VARCHAR(2),
                estatus_migratorio INT(1),
                declaracion_fiscal INT(1),
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
            CREATE TABLE IF NOT EXISTS Cuentas (
                id_cliente INT,
                numero_cuenta VARCHAR(20),
                tipo_cuenta VARCHAR(20),
                PRIMARY KEY (id_cliente),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Conyuges_Dependientes (
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
                relacion VARCHAR(20),
                notas VARCHAR(200),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Registros (
                id_registro INT PRIMARY KEY AUTO_INCREMENT,
                id_cliente INT,
                fecha DATE DEFAULT (CURRENT_DATE),
                descripcion VARCHAR(255),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS Img (
                id_img INT PRIMARY KEY AUTO_INCREMENT,
                id_cliente INT,
                nombre VARCHAR(50),
                descripcion VARCHAR(50),
                imagen VARCHAR(250),
                FOREIGN KEY (id_cliente) REFERENCES Titulares(id_cliente) ON DELETE CASCADE
            );
        ";
        $conexion->exec($sql);

        header("Location: ?controller=Paneles&action=index");
        exit;
    }
    /**
     * Exporta todos los titulares en formato CSV.
     *
     * Genera un archivo CSV con todos los titulares, incluyendo sus conyuges y dependientes.
     * El archivo se llama "titulares.csv"
     *
     * @return void
     */
    public function exportarCSV()
    {
        try {
            $sql = "SELECT * FROM Titulares";
            $titulares = $this->DB->query($sql);
            $titulares = $titulares->fetchAll();

            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=Titulares.csv");
            foreach ($titulares as $titular) {
                echo "id_cliente,nombre,segundo_nombre,primer_apellido,segundo_apellido,SSN,alien_number,genero,fecha_nacimiento,direccion,ciudad,estado,codigo_postal,telefono,email,empresa,estatus_migratorio,declaracion_fiscal,actualizado,notas,en_poliza\n";
                echo "$titular[id_cliente],";
                echo "$titular[nombre],";
                echo "$titular[segundo_nombre],";
                echo "$titular[primer_apellido],";
                echo "$titular[segundo_apellido],";
                echo "$titular[SSN],";
                echo "$titular[alien_number],";
                echo "$titular[genero],";
                echo "$titular[fecha_nacimiento],";
                echo "$titular[direccion],";
                echo "$titular[ciudad],";
                echo "$titular[estado],";
                echo "$titular[codigo_postal],";
                echo "$titular[telefono],";
                echo "$titular[email],";
                echo "$titular[empresa],";
                echo "$titular[estatus_migratorio],";
                echo "$titular[declaracion_fiscal],";
                echo "$titular[actualizado],";
                echo "$titular[notas],";
                echo "$titular[en_poliza]\n";
                echo "-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-\n";
                echo "relacion,nombre,segundo_nombre,apellido,SSN,alien_number,genero,fecha_nacimiento,en_poliza,estatus_migratorio,id_miembro_grupo,id_cliente\n";
                // echo "id_miembro_grupo,nombre,segundo_nombre,apellido,SSN,alien_number,genero,fecha_nacimiento,en_poliza,estatus_migratorio,relacion\n";
                $sql = "SELECT * FROM Conyuges_Dependientes WHERE id_cliente = :id AND relacion = 'Conyuge'";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindParam(':id', $titular['id_cliente']);
                $stmt->execute();
                $conyuge = $stmt->fetch();
                // contar columnas
                if ($conyuge) {
                    echo "$conyuge[relacion],$conyuge[nombre],$conyuge[segundo_nombre],$conyuge[apellido],";
                    echo "$conyuge[SSN],$conyuge[alien_number],$conyuge[genero],$conyuge[fecha_nacimiento],$conyuge[en_poliza],$conyuge[estatus_migratorio],$conyuge[id_miembro_grupo],$conyuge[id_cliente]\n";

                }
                $sql = "SELECT * FROM Conyuges_Dependientes WHERE id_cliente = :id AND relacion != 'Conyuge'";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindParam(':id', $titular['id_cliente']);
                $stmt->execute();
                $dependientes = $stmt->fetchAll();
                if ($dependientes) {
                    foreach ($dependientes as $depende) {
                        echo "$depende[relacion],";
                        echo "$depende[nombre],";
                        echo "$depende[segundo_nombre],";
                        echo "$depende[apellido],";
                        echo "$depende[SSN],";
                        echo "$depende[alien_number],";
                        echo "$depende[genero],";
                        echo "$depende[fecha_nacimiento],";
                        echo "$depende[en_poliza],";
                        echo "$depende[estatus_migratorio],";
                        echo "$depende[id_miembro_grupo]\n";
                    }
                    echo "-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----,-----\n";
                }
            }
        } catch (PDOException $e) {
            die("Error al buscar en base de datos: ".$e->getMessage());

        }
    }//Fin de exportarCSV

    /**
     * Exporta un grupo de personas a un archivo CSV.
     *
     * Se utilizan las tablas Titulares, Datos_Seguro, Cuentas y Conyuges_Dependientes.
     *
     * @return void
     */
    public function exportarGrupoCSV()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $sql = "SELECT * FROM Titulares WHERE id_cliente = :id";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $titular = $stmt->fetch();
                $sql = "SELECT * FROM Datos_Seguro WHERE id_cliente = :id";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $seguro = $stmt->fetch();
                $sql = "SELECT * FROM Cuentas WHERE id_cliente = :id";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $cuenta = $stmt->fetch();
                $sql = "SELECT * FROM Conyuges_Dependientes WHERE id_cliente = :id";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $grupo = $stmt->fetchAll();
                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=Grupo.csv");
                echo "TITULAR,Nombre,Segundo_nombre,Primer Apellido,Segundo Apellido,SSN,Alien_number,Fecha_nacimiento,Genero,Direccion,Ciudad,Estado,Codigo_postal,Telefono,Email,Empresa,Cobertura,Estatus_migratorio,Declaracion_fiscal,Actualizado,Notas\n";
                echo "$titular[id_cliente],";
                echo "$titular[nombre],";
                echo "$titular[segundo_nombre],";
                echo "$titular[primer_apellido],";
                echo "$titular[segundo_apellido],";
                echo "$titular[SSN],";
                echo "$titular[alien_number],";
                echo "$titular[fecha_nacimiento],";
                echo "$titular[genero],";
                echo "$titular[direccion],";
                echo "$titular[ciudad],";
                echo "$titular[estado],";
                echo "$titular[codigo_postal],";
                echo "$titular[telefono],";
                echo "$titular[email],";
                echo "$titular[empresa],";
                echo "$titular[en_poliza],";
                echo "$titular[estatus_migratorio],";
                echo "$titular[declaracion_fiscal],";
                echo "$titular[actualizado],";
                echo "$titular[notas]\n";
                echo "-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,\n";
                echo "MIEMBRO,Tipo,Nombre,Segundo_nombre,Apellido(s),SSN,Alien_number,Fecha_nacimiento,Cobertura,Estatus Migratorio,Genero,Relacion\n";
                foreach ($grupo as $miembro) {
                    echo "$miembro[id_miembro_grupo],";
                    if ($miembro['relacion'] == 'Conyuge') {
                        echo "Conyuge,";
                    } else {
                        echo "Dependiente,";
                    }
                    echo "$miembro[nombre],";
                    echo "$miembro[segundo_nombre],";
                    echo "$miembro[apellido],";
                    echo "$miembro[SSN],";
                    echo "$miembro[alien_number],";
                    echo "$miembro[fecha_nacimiento],";
                    echo "$miembro[en_poliza],";
                    echo "$miembro[estatus_migratorio],";
                    echo "$miembro[genero],";
                    echo "$miembro[relacion]\n";
                }
                echo "-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,\n";
                echo "SEGURO,Numero de poliza, Numero de miembro,Numero de grupo,Plan\n";
                echo "-,$seguro[policy_number],$seguro[member_number],$seguro[group_number],$seguro[plan_seguro]\n";
                echo "-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,-,\n";
                echo "CUENTA,Tipo de cuenta,Numero de cuenta\n";
                echo "-,$cuenta[tipo_cuenta],$cuenta[numero_cuenta],\n";
            } catch (PDOException $e) {
                die("Error al buscar en base de datos: ".$e->getMessage());
            }
        } else {
            die("No se recibieron datos");
        }
    }
    public function exportarSQL()
    {
        // ...

        $comando = "mysqldump -u root -p AsistenteSeguros > datos.sql";
        try {
            putenv('TERM=xterm');
            exec($comando, $output, $retorno);
            if ($retorno !== 0) {
                throw new Exception("Error al ejecutar el comando mysqldump: " . implode("\n", $output));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        // Verificar si el archivo se ha generado correctamente
        if (file_exists('datos.sql') && filesize('datos.sql') > 0) {
            // Descargar el archivo
            header('Content-Disposition: attachment; filename="datos.sql"');
            readfile('datos.sql');
            exit;
        } else {
            die("Error: No se pudo generar el archivo de respaldo");
        }
    }

}//Final de la clase
