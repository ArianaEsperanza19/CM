<?php
$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/CustomersManager/Config/DB.php';
class Seguros {
    private $DB;

    public function __construct() {
        $this->DB = DB::Connect();
        if (!$this->DB) {
            throw new Exception('No se pudo conectar a la base de datos');
        }
    }

    public function registrar($datos) {
        if (empty($datos) || empty($id)) {
            throw new Exception('Parámetros inválidos');
        }

        $sql = "INSERT INTO Datos_Seguro (policy_number, member_number, group_number) VALUES (:policy_number, :member_number, :group_number)";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':policy_number', $datos['policy_number']);
        $stmt->bindParam(':member_number', $datos['member_number']);
        $stmt->bindParam(':group_number', $datos['group_number']);

        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function actualizar($datos, $id) {
        if (empty($datos) || empty($id)) {
            throw new Exception('Parámetros inválidos');
        }
    
        $sql = "UPDATE Datos_Seguro SET 
                policy_number = :policy_number, 
                member_number = :member_number, 
                group_number = :group_number 
                WHERE id_cliente = :id_cliente";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $id);
        $stmt->bindParam(':policy_number', $datos['policy_number']);
        $stmt->bindParam(':member_number', $datos['member_number']);
        $stmt->bindParam(':group_number', $datos['group_number']);
    
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}