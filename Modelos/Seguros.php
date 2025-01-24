<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir . '/CustomersManager/Config/DB.php';

class Seguros
{
    private $DB; // Conexión a la base de datos

    /*
     * Constructor de la clase.
     * - Establece la conexión a la base de datos utilizando la clase DB.
     * - Lanza una excepción si no se puede conectar a la base de datos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->DB = DB::Connect(); // Obtiene la conexión a la base de datos
        if (!$this->DB) {
            throw new Exception('No se pudo conectar a la base de datos');
        }
    }

    /*
     * Registra un nuevo seguro en la base de datos.
     * - Inserta los datos del seguro en la tabla Datos_Seguro.
     * - Valida que los parámetros no estén vacíos.
     *
     * @param array $datos -> Datos del seguro (policy_number, member_number, group_number, plan_seguro).
     * @param int $id -> ID del cliente asociado al seguro.
     * @return PDOStatement|string -> Objeto de la sentencia ejecutada o mensaje de error en caso de fallo.
     */
    public function registrar($datos, $id)
    {
        if (empty($datos) || empty($id)) {
            throw new Exception('Parámetros inválidos');
        }

        $sql = "INSERT INTO Datos_Seguro (id_cliente, policy_number, member_number, group_number, plan_seguro)
                VALUES (:id_cliente, :policy_number, :member_number, :group_number, :plan_seguro)";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $id);
        $stmt->bindParam(':policy_number', $datos['policy_number']);
        $stmt->bindParam(':member_number', $datos['member_number']);
        $stmt->bindParam(':group_number', $datos['group_number']);
        $stmt->bindParam(':plan_seguro', $datos['plan_seguro']);

        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Actualiza los datos de un seguro existente en la base de datos.
     * - Modifica los datos del seguro en la tabla Datos_Seguro.
     * - Valida que los parámetros no estén vacíos.
     *
     * @param array $datos -> Nuevos datos del seguro (policy_number, member_number, group_number, plan_seguro).
     * @param int $id -> ID del cliente asociado al seguro.
     * @return PDOStatement|string -> Objeto de la sentencia ejecutada o mensaje de error en caso de fallo.
     */
    public function actualizar($datos, $id)
    {
        if (empty($datos) || empty($id)) {
            throw new Exception('Parámetros inválidos');
        }

        $sql = "UPDATE Datos_Seguro SET
                policy_number = :policy_number,
                member_number = :member_number,
                group_number = :group_number,
                plan_seguro = :plan_seguro
                WHERE id_cliente = :id_cliente";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $id);
        $stmt->bindParam(':policy_number', $datos['policy_number']);
        $stmt->bindParam(':member_number', $datos['member_number']);
        $stmt->bindParam(':group_number', $datos['group_number']);
        $stmt->bindParam(':plan_seguro', $datos['plan_seguro']);

        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Elimina un seguro de la base de datos.
     * - Borra el seguro asociado a un cliente en la tabla Datos_Seguro.
     * - Valida que el ID no esté vacío.
     *
     * @param int $id -> ID del cliente asociado al seguro que se desea eliminar.
     * @return PDOStatement|string -> Objeto de la sentencia ejecutada o mensaje de error en caso de fallo.
     */
    public function eliminar($id)
    {
        if (empty($id)) {
            throw new Exception('Parámetros inválidos');
        }

        $sql = "DELETE FROM Datos_Seguro WHERE id_cliente = :id_cliente";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $id);

        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Obtiene datos de la tabla Datos_Seguro según una condición.
     * - Realiza una consulta a la tabla Datos_Seguro.
     * - Verifica si la tabla existe antes de realizar la consulta.
     * - Lanza una excepción si la tabla no existe.
     *
     * @param string $condicion -> Condición SQL para filtrar los resultados (por ejemplo, "WHERE id_cliente = 1").
     * @return PDOStatement -> Objeto de la sentencia ejecutada con los resultados de la consulta.
     */
    public function obtener($condicion)
    {
        $tabla = "Datos_Seguro";
        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$tabla'";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();

        if ($sentencia->fetchColumn() == 0) {
            throw new Exception("La tabla $tabla no existe");
        } else {
            $sql = "SELECT * FROM $tabla $condicion";
            $sentencia = $this->DB->prepare($sql);
            $sentencia->execute();
        }
        return $sentencia;
    }
}
