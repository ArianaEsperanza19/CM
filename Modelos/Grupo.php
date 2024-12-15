<?php
$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/CustomersManager/Config/DB.php';
class Grupo {
    private $DB;
    public function __construct() {
        $this->DB = DB::Connect();
    }

    public function registrar($datos, $id_cliente) {
        /**
         * Registra un nuevo cónyuge o dependiente en la base de datos.
         * Este método verifica si todos los campos obligatorios se han rellenado correctamente
         * y, si es así, registra un nuevo cónyuge o dependiente en la base de datos.
         * Devuelve la sentencia preparada ejecutada.
         * 
         * @param array $datos Arreglo con los datos a registrar.
         * @return PDOStatement|false La sentencia preparada ejecutada o false en caso de error.
         */
        // Verificar si la sesión está iniciada y la variable 'cliente' está definida
        
        // Construir la sentencia SQL
        $sql = "INSERT INTO Conyugues_Dependientes (
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
                    pareja
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
                    :pareja
                )";
        
        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros con los datos
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':en_poliza', $datos['seguro']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre']);
        $stmt->bindParam(':apellido', $datos['primer_apellido']);
        $stmt->bindParam(':SSN', $datos['SSN']);
        $stmt->bindParam(':alien_number', $datos['alien_number']);
        $stmt->bindParam(':genero', $datos['genero']);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $stmt->bindParam(':estatus_migratorio', $datos['estatus_migratorio'], PDO::PARAM_BOOL);
        $stmt->bindParam(':pareja', $datos['pareja'], PDO::PARAM_BOOL);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return false;
        }
    }



    public function eliminar_todos($id_cliente) {
    /**
     * Elimina todos los registros asociados a un cliente en la base de datos.
     * Este método elimina todos los titulares pertenecientes al cliente con el 
     * ID proporcionado.
     * 
     * @param int $id_cliente El ID del cliente cuyos registros se eliminarán.
     * @return PDOStatement La sentencia preparada ejecutada.
     */
        $sql = "DELETE FROM Titulares WHERE id_cliente = :id_cliente";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt;
    }
}
