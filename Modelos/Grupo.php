<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir . '/CustomersManager/Config/DB.php';
class Grupo
{
    private $DB;
    public function __construct()
    {
        $this->DB = DB::Connect();
    }

    /**
     * Registra un nuevo conyugue o dependiente en la base de datos.
     * - Inserta los datos en la tabla Conyuges_Dependientes.
     * - Valida que los parámetros no estén vacíos.
     *
     * @param array<string, mixed> $datos -> Datos del conyugue o dependiente
     *                                    (en_poliza: string, nombre: string, segundo_nombre: string, apellido: string, SSN: string, alien_number: string, genero: string, fecha_nacimiento: string, estatus_migratorio: bool, relacion: string, notas: string).
     * @param int $id_cliente -> ID del cliente asociado al conyugue o dependiente.
     * @return PDOStatement|false -> Objeto de la sentencia ejecutada o false en caso de fallo.
     */
    public function registrar(array $datos, int $id_cliente): PDOStatement|false
    {

        $sql = "INSERT INTO Conyuges_Dependientes (
            id_cliente,
            en_poliza,
            nombre,
            segundo_nombre,
            apellido,
            SSN,
            alien_number,
            genero,
            fecha_nacimiento,
            estatus_migratorio,
            relacion,
            notas
        ) VALUES (
            :id_cliente,
            :en_poliza,
            :nombre,
            :segundo_nombre,
            :apellido,
            :SSN,
            :alien_number,
            :genero,
            :fecha_nacimiento,
            :estatus_migratorio,
            :relacion,
            :notas
        )";
        $this->DB->beginTransaction();
        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros con los datos
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':en_poliza', $datos['seguro'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $datos['apellidos'], PDO::PARAM_STR);
        $stmt->bindParam(':SSN', $datos['ssn'], PDO::PARAM_STR);
        $stmt->bindParam(':alien_number', $datos['alien_number'], PDO::PARAM_STR);
        $stmt->bindParam(':genero', $datos['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':estatus_migratorio', $datos['estatus'], PDO::PARAM_BOOL);
        $stmt->bindParam(':relacion', $datos['relacion'], PDO::PARAM_STR);
        $stmt->bindParam(':notas', $datos['notas'], PDO::PARAM_STR);
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
     * Elimina todos los titulares y dependientes asociados a un cliente,
     * ademas de eliminar las imagenes asociadas a este.
     *
     * 1. Primero se obtienen las imagenes asociadas al cliente con una
     *    consulta SQL. Se utiliza un objeto PDOStatement para ejecutar la
     *    sentencia y obtener los resultados en un array asociativo.
     * 2. Luego se itera sobre el array de imagenes y se eliminan una por una
     *    utilizando el objeto IMGmanager, que es una clase que provee metodos
     *    para manipular imagenes.
     * 3. Finalmente se elimina el registro del titular/dependiente en la tabla
     *    Titulares con una consulta SQL DELETE.
     *
     * @param int $id_cliente -> ID del cliente asociado a los titulares y dependientes.
     * @return PDOStatement -> Objeto de la sentencia ejecutada.
     */
    public function eliminar_todos(int $id_cliente): PDOStatement
    {
        // 1. Obtener imagenes asociadas al cliente
        $sql = "SELECT imagen FROM Img WHERE id_cliente = :id_cliente";
        $stmt = $this->DB->prepare($sql);
        $stmt->execute([':id_cliente' => $id_cliente]);
        $img = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Iterar sobre las imagenes y eliminarlas
        require_once 'Modelos/IMGmanager.php';
        $imgM = new IMGmanager("Vistas/img/");
        foreach ($img as $imagen) {
            // Borrar imagen en la carpeta
            $imgM->borrarImagen($imagen['imagen']);
        }

        // 3. Eliminar registro del titular/dependiente
        $sql = "DELETE FROM Titulares WHERE id_cliente = :id_cliente";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Elimina un conyuge o dependiente de la base de datos.
     *
     * @param int $id ID del miembro a eliminar.
     * @return PDOStatement Objeto de la sentencia ejecutada.
     */
    public function eliminar_uno(int $id): PDOStatement
    {
        // Preparar la sentencia para eliminar un conyuge o dependiente
        $stmt = $this->DB->prepare("DELETE FROM Conyuges_Dependientes WHERE id_miembro_grupo = :id");
        // Vincular el parámetro con el valor proporcionado
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        // Ejecutar la sentencia
        $stmt->execute();
        // Devolver la sentencia ejecutada
        return $stmt;
    }

    /**
     * Edita un registro en la base de datos.
     * Este método actualiza un registro ya existente en la base de datos
     * con los datos proporcionados.
     *
     * @param array $datos Arreglo con los datos a actualizar, conseguidos directamente por post.
     * @param int $id_cliente El ID del registro a editar.
     * @return PDOStatement La sentencia preparada ejecutada.
     */
    public function editar(array $datos, int $id_cliente): PDOStatement
    {
        // Preparar la sentencia para actualizar un registro
        $sql = "UPDATE Conyuges_Dependientes SET
                    en_poliza = :en_poliza,
                    nombre = :nombre,
                    segundo_nombre = :segundo_nombre,
                    apellido = :apellido,
                    SSN = :SSN,
                    alien_number = :alien_number,
                    genero = :genero,
                    fecha_nacimiento = :fecha_nacimiento,
                    estatus_migratorio = :estatus_migratorio,
                    relacion = :relacion,
                    notas = :notas
                WHERE id_miembro_grupo = :id_cliente";

        // Comenzar transacción para asegurarnos de que no se hagan cambios
        // en la base de datos hasta que se confirme que se han realizado
        // correctamente.
        $this->DB->beginTransaction();

        // Preparar la sentencia para su ejecución
        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros con los datos proporcionados
        $stmt->bindParam(':en_poliza', $datos['seguro'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $datos['apellidos'], PDO::PARAM_STR);
        $stmt->bindParam(':SSN', $datos['ssn'], PDO::PARAM_STR);
        $stmt->bindParam(':alien_number', $datos['alien_number'], PDO::PARAM_STR);
        $stmt->bindParam(':genero', $datos['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':estatus_migratorio', $datos['estatus'], PDO::PARAM_BOOL);
        $stmt->bindParam(':relacion', $datos['relacion'], PDO::PARAM_STR);
        $stmt->bindParam(':notas', $datos['notas'], PDO::PARAM_STR);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Confirmar que se ha realizado la transacción
            // y devolver la sentencia ejecutada.
            $this->DB->commit();
            return $stmt;
        } else {
            // Revertir la transacción en caso de error
            // y lanzar una excepción.
            $this->DB->rollBack();
            throw new Exception("Error al editar el registro");
        }
    }

    /**
     * Consigue el id_cliente de un conyugue o dependiente.
     *
     * Este método devuelve el id_cliente del titular al que pertenece
     * el conyugue o dependiente con el id especificado.
     *
     * @param int $id El id del conyugue o dependiente.
     *
     * @return int|null El id del cliente titular del conyugue o dependiente.
     *                   null si la consulta falla o no se encuentra el registro.
     *
     * @throws Exception Si la consulta falla.
     */
    public function info_titular(int $id): ?int
    {
        // Preparar la sentencia para la consulta
        $stmt = $this->DB->prepare("SELECT id_cliente FROM Conyuges_Dependientes WHERE id_miembro_grupo = :id");

        // Vincular el parámetro :id con el valor $id
        $stmt->execute([':id' => $id]);

        // Fetch the result as a single column
        $result = $stmt->fetchColumn();

        // Si el resultado es un valor booleano falso, devolver null
        // de lo contrario, devolver el valor como entero
        return $result !== false ? (int) $result : null;
    }

    /**
     * Consigue un registro de la tabla de Conyuges_Dependientes.
     *
     * Este método devuelve una sentencia PDOStatement que contiene
     * el resultado de la consulta a la tabla Conyuges_Dependientes con
     * la condición especificada por el parámetro $condicion.
     *
     * Primero, se verifica si la tabla existe. Si la tabla no existe,
     * se lanza una excepción con un mensaje de error.
     *
     * Luego, se prepara una sentencia para la consulta y se ejecuta
     * con los parámetros proporcionados en $condicion.
     *
     * @param string $condicion La condicion de busqueda para el registro.
     * @return PDOStatement La sentencia de selección ejecutada.
     * @throws Exception Si la tabla no existe.
     */
    public function Conseguir_Miembro(string $condicion): PDOStatement
    {
        // Verificar si la tabla existe
        $tabla = "Conyuges_Dependientes";
        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = :tabla";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute([':tabla' => $tabla]);

        // Si la tabla no existe, lanzar una excepción
        if ($sentencia->fetchColumn() == 0) {
            throw new Exception("La tabla $tabla no existe");
        }

        // Preparar y ejecutar la consulta
        $sql = "SELECT * FROM $tabla $condicion";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();

        // Devolver la sentencia ejecutada
        return $sentencia;
    }

    /**
     * Registra una nueva imagen en la base de datos.
     *
     * Inserta los datos de la imagen en la tabla 'Img' y maneja la transacción.
     * Devuelve un objeto PDOStatement si la operación es exitosa, o false en caso de fallo.
     *
     * @param array<string, mixed> $datos Datos de la imagen (incluye 'id', 'nombre', y 'descripcion').
     * @param string $img Ruta o nombre de la imagen a registrar.
     * @return PDOStatement|false El objeto de la sentencia ejecutada o false si falla.
     */
    public function registrar_img(array $datos, string $img): PDOStatement|false
    {
        // SQL para insertar un nuevo registro en la tabla Img
        $sql = "INSERT INTO Img (id_cliente, nombre, imagen, descripcion) VALUES (:id_cliente, :nombre, :imagen, :descripcion)";

        // Iniciar una transacción para asegurar la atomicidad de la operación
        $this->DB->beginTransaction();

        // Preparar la sentencia SQL
        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros con los valores proporcionados en $datos y $img
        $stmt->bindParam(':id_cliente', $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':imagen', $img, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);

        // Establecer el modo de error de PDO para que lance excepciones detalladas
        $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ejecutar la sentencia y verificar su éxito
        if ($stmt->execute()) {
            // Si la ejecución es exitosa, confirmar (commit) la transacción
            $this->DB->commit();
            return $stmt; // Retornar el objeto PDOStatement ejecutado
        } else {
            // Si la ejecución falla, revertir (rollBack) la transacción
            $this->DB->rollBack();
            return false; // Indicar el fallo devolviendo false
        }
    }

    /**
     * Actualiza la información de una imagen en la base de datos
     * y en el registro correspondiente en la tabla 'Img'.
     *
     * @param array<string, mixed> $datos Datos de la imagen (incluye 'id', 'nombre', 'descripcion', y 'id_img').
     * @param string $img Nombre o ruta de la imagen.
     * @param bool $centinela Indica si se debe usar la imagen proporcionada.
     *                        Si es false, no se actualiza la imagen.
     * @return PDOStatement|false El objeto de la sentencia ejecutada o false si falla.
     */
    public function actualizar_img(array $datos, string $img, bool $centinela = true): PDOStatement|false
    {
        // Preparar la sentencia SQL para actualizar el registro
        $sql = "UPDATE Img SET id_cliente = :id_cliente, imagen = :imagen, nombre = :nombre, descripcion = :descripcion WHERE id_img = :id";

        // Iniciar una transacción para asegurar la atomicidad de la operación
        $this->DB->beginTransaction();

        // Preparar la sentencia y vincular los parámetros con los valores proporcionados
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);

        // Si se debe actualizar la imagen, vincular el parámetro ':imagen' con el valor proporcionado
        if ($centinela) {
            $stmt->bindParam(':imagen', $img, PDO::PARAM_STR);
        } else {
            // Si no se debe actualizar la imagen, establecer el valor de ':imagen' en null
            $stmt->bindValue(':imagen', null, PDO::PARAM_NULL);
        }

        // Vincular el parámetro ':id' con el valor proporcionado
        $stmt->bindParam(':imagen', $img, PDO::PARAM_STR);
        $stmt->bindParam(':id', $datos['id_img'], PDO::PARAM_INT);

        // Ejecutar la sentencia y verificar su éxito
        $sentencia = $stmt->execute();

        // Si la ejecución es exitosa, confirmar la transacción
        if ($sentencia) {
            $this->DB->commit();
            return $stmt; // Retornar el objeto PDOStatement ejecutado
            return $stmt;
        } else {
            // Si la ejecución falla, revertir la transacción
            $this->DB->rollBack();
            return false; // Indicar el fallo devolviendo false
            return false;
        }
    }
    /**
     * @param int $id
     * @return PDOStatement
     */
    public function eliminar_img(int $id): PDOStatement
    {
        $table = "Img";
        $stmt = $this->DB->prepare("DELETE FROM $table WHERE id_img = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;

    }

    /**
     * Saves a new record to the database.
     *
     * @param array<string, int|string> $datos An array containing the data to be saved.
     *                                        The array should contain the following keys:
     *                                        - 'id_cliente' (int): The ID of the client associated with the record.
     *                                        - 'descripcion' (string): A short description of the record.
     * @return PDOStatement The statement object used to execute the query.
     */
    public function guardarRegistro(array $datos): PDOStatement
    {
        // Check if the required data has been provided
        if (isset($datos) && array_key_exists('id_cliente', $datos) && array_key_exists('descripcion', $datos)) {
            // Build the SQL query
            $sql = "INSERT INTO Registros (id_cliente, fecha, descripcion) VALUES (:id_cliente, CURDATE(), :descripcion)";
            // Start a transaction to ensure atomicity
            $this->DB->beginTransaction();
            // Prepare the statement and bind the parameters
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            // Execute the query
            try {
                $stmt->execute();
                // Commit the transaction if the query was successful
                $this->DB->commit();
            } catch (PDOException $e) {
                // Roll back the transaction if the query failed
                $this->DB->rollBack();
                // Re-throw the exception with a more informative message
                throw new Exception("Error al guardar el registro: " . $e->getMessage());
            }
            // Return the statement object
            return $stmt;

        } else {
            // Throw an exception if the required data is missing
            throw new InvalidArgumentException('No se han proporcionado datos para guardar el registro');
        }
    }

    /**
     * @param int $id_registro The ID of the record to be deleted.
     * @param int $id_cliente The ID of the client associated with the record.
     * @return PDOStatement The statement object used to execute the query.
     */
    public function eliminarRegistro(int $id_registro, int $id_cliente): PDOStatement
    {
        // Check if the required data has been provided
        if (isset($id_registro) && isset($id_cliente)) {
            // Build the SQL query
            $sql = "DELETE FROM Registros WHERE id_cliente = :id_cliente AND id_registro = :id_registro";
            // Prepare the statement and bind the parameters
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':id_registro', $id_registro, PDO::PARAM_INT);
            // Execute the query
            try {
                $stmt->execute();
                // If the query was successful, return the statement object
                return $stmt;
            } catch (PDOException $e) {
                // If the query failed, throw an exception with a more informative message
                throw new Exception("Error al eliminar el registro: " . $e->getMessage());
            }
        } else {
            // Throw an exception if the required data is missing
            throw new InvalidArgumentException('No se han proporcionado el ID del registro y el ID del cliente');
        }
    }
    /**
     * Retrieve a record from the database.
     *
     * This method takes two parameters: $id_registro and $id_cliente. The
     * method will return a PDOStatement object containing the record that
     * matches the provided ID.
     *
     * If $id_registro is provided, the method will search for a record with
     * a matching id_registro value. If $id_cliente is provided, the method
     * will search for a record with a matching id_cliente value. If both
     * parameters are provided, the method will search for a record that
     * matches both values.
     *
     * If no record is found, the method will throw an Exception.
     *
     * @param int|null $id_registro The ID of the record to retrieve.
     * @param int|null $id_cliente The ID of the client associated with the record.
     * @return PDOStatement The prepared statement object.
     * @throws Exception If there is an error executing the query.
     */
    public function conseguirRegistro(?int $id_registro = null, ?int $id_cliente = null): PDOStatement
    {
        if (isset($id_cliente)) {
            // The $id_cliente parameter is set, so we will search for a record
            // with a matching id_cliente value.
            $sql = "SELECT * FROM Registros WHERE id_cliente = :id";
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);
            try {
                $stmt->execute();
                return $stmt;
            } catch (PDOException $e) {
                // If there is an error executing the query, throw an Exception.
                throw new Exception("Error al conseguir registro: " . $e->getMessage());
            }
        } elseif (isset($id_registro)) {
            // The $id_registro parameter is set, so we will search for a record
            // with a matching id_registro value.
            $sql = "SELECT * FROM Registros WHERE id_registro = :id";
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id', $id_registro, PDO::PARAM_INT);
            try {
                $stmt->execute();
                return $stmt;
            } catch (PDOException $e) {
                // If there is an error executing the query, throw an Exception.
                throw new Exception("Error al conseguir registro: " . $e->getMessage());
            }
        }
        // If neither $id_registro nor $id_cliente are set, throw an
        // InvalidArgumentException.
        throw new InvalidArgumentException('No se ha proporcionado ni id_registro ni id_cliente');
    }

    /**
     * @param array<string, mixed> $datos The data to update the record with.
     * @return PDOStatement The statement object used to execute the query.
     * @throws Exception If there is an error executing the query.
     *
     * This method updates a record in the Registros table. It takes an array of
     * data as a parameter, which should contain the following keys:
     * - id_cliente: The ID of the client associated with the record.
     * - id_registro: The ID of the record to update.
     * - descripcion: The new value for the descripcion field.
     *
     * The method first checks that the required data is present in the $datos
     * array. If it is, it builds a SQL query to update the record and executes
     * it. If the query is successful, it commits the transaction and returns
     * the statement object. If the query fails, it rolls back the transaction
     * and throws an exception with a more informative error message.
     */
    public function actualizarRegistro(array $datos): PDOStatement
    {
        if (
            isset($datos['id_cliente']) &&
            isset($datos['id_registro']) &&
            isset($datos['descripcion'])
        ) {
            // Build the SQL query to update the record
            $sql = "UPDATE Registros SET descripcion = :descripcion WHERE id_cliente = :id_cliente AND id_registro = :id_registro";

            // Start a transaction to ensure atomicity
            $this->DB->beginTransaction();

            // Prepare the statement and bind the parameters
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_registro', $datos['id_registro'], PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);

            // Execute the query and check for errors
            try {
                $stmt->execute();
                // If the query is successful, commit the transaction
                $this->DB->commit();
                return $stmt;
            } catch (PDOException $e) {
                // If the query fails, roll back the transaction and throw an exception
                $this->DB->rollBack();
                throw new Exception("Error al actualizar: " . $e->getMessage());
            }
        } else {
            // If the required data is missing, throw an exception
            throw new InvalidArgumentException('No se ha proporcionado los datos necesarios para actualizar el registro');
        }
    }

}
