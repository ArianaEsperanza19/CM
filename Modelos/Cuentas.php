<?php
$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/CustomersManager/Config/DB.php';
class Cuentas {
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

        $sql = "INSERT INTO Cuentas (numero_cuenta, tipo_cuenta) VALUES (:numero_cuenta, :tipo_cuenta)";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':numero_cuenta', $datos['numero_cuenta']);
        $stmt->bindParam(':tipo_cuenta', $datos['tipo_cuenta']);

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
    if (!isset($datos['numero_cuenta']) || !isset($datos['tipo_cuenta'])) {
        throw new Exception('Datos incompletos');
    }
    $sql = "UPDATE Cuentas SET 
            numero_cuenta = :numero_cuenta,
            tipo_cuenta = :tipo_cuenta
            WHERE id_cliente = :id_cliente";
    $stmt = $this->DB->prepare($sql);
    $stmt->bindParam(':id_cliente', $id);
    $stmt->bindParam(':numero_cuenta', $datos['numero_cuenta']);
    $stmt->bindParam(':tipo_cuenta', $datos['tipo_cuenta']);
    
    try {
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
}