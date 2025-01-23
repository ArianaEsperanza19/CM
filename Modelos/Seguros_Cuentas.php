<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/CustomersManager/Config/DB.php';
class Seguros
{
    private $DB;

    public function __construct()
    {
        $this->DB = DB::Connect();
        if (!$this->DB) {
            throw new Exception('No se pudo conectar a la base de datos');
        }
    }

    public function registrar($datos, $id)
    {
        if (empty($datos) || empty($id)) {
            throw new Exception('Parámetros inválidos');
        }

        $sql = "INSERT INTO Datos_Seguro ( id_cliente, policy_number, member_number, group_number, plan_seguro) VALUES (:id_cliente, :policy_number, :member_number, :group_number, :plan_seguro)";
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
