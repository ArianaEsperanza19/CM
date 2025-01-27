<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/CustomersManager/Config/DB.php';
class Titulares
{
    protected $DB;
    public function __construct()
    {
        /**
         * Constructor de la clase. Establece la conexion a la base de datos
         * y los valores de la tabla y el ID.
         * @param int $id El ID de la tabla.
         * @param string $tabla El nombre de la tabla.
         */
        $this->DB = DB::Connect();
    }
    public function __destruct()
    {
        /**
         * Destructor de la clase. Cierra la conexion a la base de datos.
         */
        $this->DB = null;
    }
    public function Conseguir_Todos(): array
    {
        /**
         * Consigue todos los registros de una tabla dada.
         *
         * @return array Un array con todos los registros de la tabla.
         */
        $tabla = "Titulares";
        $datos = $this->DB->prepare("SELECT id_cliente FROM $tabla");
        $datos->execute();
        $datos = $datos->fetchAll();
        return $datos;
    }
    public function Conseguir_Registro(string $condicion): PDOStatement
    {
        /**
         * Consigue un registro de una tabla dada.
         *
         * @param string $condicion La condición de búsqueda para el registro.
         * @return PDOStatement La sentencia de selección ejecutada.
         * @throws Exception Si la tabla no existe.
         */

        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = 'Titulares'";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        if ($sentencia->fetchColumn() == 0) {
            throw new Exception("La tabla Titulares no existe");
        } else {
            $sql = "SELECT * FROM Titulares $condicion";
            $sentencia = $this->DB->prepare($sql);
            $sentencia->execute();
        }
        return $sentencia;
    }
    /**
     * @return array<string, mixed>
     */
    public function Ultimo_Registro(): array
    {
        $sql = "SELECT * FROM Titulares ORDER BY id_cliente DESC LIMIT 1";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function Registrar(array $datos): PDOStatement|false
    {
        /**
         * Registra un nuevo titular en la base de datos.
         * Este método verifica si todos los campos de la tabla se han rellenado correctamente
         * y, si es así, registra un nuevo titular en la base de datos.
         * Devuelve la sentencia preparada ejecutada.
         *
         * @param array<string, string|int|bool> $datos Arreglo con los datos a registrar.
         * @return PDOStatement|false La sentencia preparada ejecutada o false en caso de error.
         */

        // Asignar valores
        $tabla = "Titulares";
        $this->DB = DB::Connect();
        $this->DB->beginTransaction();
        // Construir la sentencia SQL
        $sql = "INSERT INTO $tabla (nombre, segundo_nombre, primer_apellido, segundo_apellido, SSN, alien_number, genero, fecha_nacimiento, estatus_migratorio, declaracion_fiscal, direccion, ciudad, estado, codigo_postal, telefono, email, empresa, notas, actualizado, en_poliza)
            VALUES (:nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :SSN, :alien_number, :genero, :fecha_nacimiento, :estatus_migratorio, :declaracion_fiscal, :direccion, :ciudad, :estado, :codigo_postal, :telefono, :email, :empresa, :notas, :actualizado, :en_poliza)";
        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros con los datos
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':SSN', $datos['ssn'], PDO::PARAM_INT);
        $stmt->bindParam(':alien_number', $datos['alien_number'], PDO::PARAM_STR);
        $stmt->bindParam(':genero', $datos['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $datos['ciudad'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo_postal', $datos['codigo_postal'], PDO::PARAM_INT);
        $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(':empresa', $datos['empresa'], PDO::PARAM_STR);
        $stmt->bindParam(':estatus_migratorio', $datos['estatus'], PDO::PARAM_BOOL);
        $stmt->bindParam(':declaracion_fiscal', $datos['fiscal'], PDO::PARAM_BOOL);
        $stmt->bindParam(':notas', $datos['notas'], PDO::PARAM_STR);
        $stmt->bindParam(':actualizado', $datos['actualizado'], PDO::PARAM_BOOL);
        $stmt->bindParam(':en_poliza', $datos['seguro'], PDO::PARAM_STR);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            $this->DB->commit();
            return $stmt;
        } else {
            $this->DB->rollBack();
            return false;
        }
    }

    /**
     * Edita un titular en la base de datos con los datos proporcionados.
     *
     * @param array<string, string|int|bool> $datos Arreglo asociativo que contiene los datos del titular a actualizar.
     * @param int $id El ID del titular que se desea actualizar.
     * @return PDOStatement|false La sentencia preparada ejecutada o false en caso de fallo.
     * @throws Exception Si los parámetros proporcionados son inválidos.
     */
    public function Editar(array $datos, int $id): PDOStatement|false
    {
        // Verificar si los datos o el ID proporcionados están vacíos
        if (empty($datos) || empty($id)) {
            throw new Exception('Parámetros inválidos');
        }

        // Definir el nombre de la tabla
        $tabla = "Titulares";

        // Establecer la conexión con la base de datos
        $this->DB = DB::Connect();

        // Construir la sentencia SQL para actualizar el registro del titular
        $sql = "UPDATE $tabla SET
            nombre = :nombre,
            segundo_nombre = :segundo_nombre,
            primer_apellido = :primer_apellido,
            segundo_apellido = :segundo_apellido,
            SSN = :SSN,
            alien_number = :alien_number,
            fecha_nacimiento = :fecha_nacimiento,
            estatus_migratorio = :estatus_migratorio,
            declaracion_fiscal = :declaracion_fiscal,
            direccion = :direccion,
            ciudad = :ciudad,
            estado = :estado,
            codigo_postal = :codigo_postal,
            telefono = :telefono,
            email = :email,
            empresa = :empresa,
            notas = :notas,
            actualizado = :actualizado,
            en_poliza = :en_poliza
            WHERE id_cliente = :id_cliente";

        // Preparar la sentencia SQL
        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros de la sentencia SQL con los datos proporcionados
        $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':SSN', $datos['ssn'], PDO::PARAM_INT);
        $stmt->bindParam(':alien_number', $datos['alien_number'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':estatus_migratorio', $datos['estatus'], PDO::PARAM_BOOL);
        $stmt->bindParam(':declaracion_fiscal', $datos['fiscal'], PDO::PARAM_BOOL);
        $stmt->bindParam(':direccion', $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $datos['ciudad'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo_postal', $datos['codigo_postal'], PDO::PARAM_INT);
        $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(':empresa', $datos['empresa'], PDO::PARAM_STR);
        $stmt->bindParam(':notas', $datos['notas'], PDO::PARAM_STR);
        $stmt->bindParam(':actualizado', $datos['actualizado'], PDO::PARAM_BOOL);
        $stmt->bindParam(':en_poliza', $datos['seguro'], PDO::PARAM_STR);

        // Ejecutar la sentencia SQL
        if ($stmt->execute()) {
            // Devolver la sentencia ejecutada si tuvo éxito
            return $stmt;
        } else {
            // Devolver false si hubo un fallo en la ejecución
            return false;
        }
    }

}
