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

    public function registrar($datos, $id_cliente)
    {
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
            relacion
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
            :relacion
        )";

$stmt = $this->DB->prepare($sql);

// Vincular los parámetros con los datos
$stmt->bindParam(':id_cliente', $id_cliente);
$stmt->bindParam(':en_poliza', $datos['seguro']);
$stmt->bindParam(':nombre', $datos['nombre']);
$stmt->bindParam(':segundo_nombre', $datos['segundo_nombre']);
$stmt->bindParam(':apellido', $datos['apellidos']);
$stmt->bindParam(':SSN', $datos['ssn']);
$stmt->bindParam(':alien_number', $datos['alien_number']);
$stmt->bindParam(':genero', $datos['genero']);
$stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
$stmt->bindParam(':estatus_migratorio', $datos['estatus_migratorio'], PDO::PARAM_BOOL);
$stmt->bindParam(':relacion', $datos['relacion']);
        // Ejecutar la sentencia
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return false;
        }
    }


    public function eliminar_todos($id_cliente)
    {
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

    public function eliminar_uno($id)
    {
        $stmt = $this->DB->prepare("DELETE FROM Conyuges_Dependientes WHERE id_miembro_grupo = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    public function editar($datos, $id_cliente)
    {
        /**
         * Edita un registro en la base de datos.
         * Este método actualiza un registro ya existente en la base de datos
         * con los datos proporcionados.
         *
         * @param array $datos Arreglo con los datos a actualizar, conseguidos directamente por post.
         * @param int $id_cliente El ID del registro a editar.
         * @return PDOStatement|false La sentencia preparada ejecutada o false en caso de error.
         */
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
                    relacion = :relacion
                WHERE id_miembro_grupo = $id_cliente";

        $stmt = $this->DB->prepare($sql);

        // Vincular los parámetros con los datos
        $stmt->bindParam(':en_poliza', $datos['seguro']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre']);
        $stmt->bindParam(':apellido', $datos['apellidos']);
        $stmt->bindParam(':SSN', $datos['ssn']);
        $stmt->bindParam(':alien_number', $datos['alien_number']);
        $stmt->bindParam(':genero', $datos['genero']);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $stmt->bindParam(':estatus_migratorio', $datos['estatus_migratorio'], PDO::PARAM_BOOL);
        $stmt->bindParam(':relacion', $datos['relacion']);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return false;
        }
    }

    public function info_titular($id)
    {
        $stmt = $this->DB->prepare("SELECT id_cliente FROM Conyuges_Dependientes WHERE id_miembro_grupo = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn();
    }


    public function registrar_img($datos, $img)
    {

            $sql = "INSERT INTO Img (id_cliente, nombre, imagen, descripcion) VALUES (:id_cliente, :nombre, :imagen, :descripcion)";
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id_cliente', $datos['id'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $img);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);

            // Configura PDO para lanzar excepciones detalladas
            $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($stmt->execute()) {
                return $stmt;
            } else {
                return false;
            }
    }

    public function actualizar_img($datos, $img, $centinela = true) {
        $sql = "UPDATE Img SET id_cliente = :id_cliente, imagen = :imagen, nombre = :nombre, descripcion = :descripcion WHERE id_img = :id";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id_cliente', $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':imagen', $img);
        $stmt->bindParam(':id', $datos['id_img'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function guardarRegistro($datos){
        if(isset($datos)){
            $sql = "INSERT INTO Registros (id_cliente, fecha, descripcion) VALUES (:id_cliente, CURDATE(), :descripcion)";
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            try {
            $stmt->execute();
}catch (PDOException $e) {
    echo "Error al guardar el registro: " . $e->getMessage();
    die();
}
return $stmt;

}else{
    return false;}}

public function eliminarRegistro($id){
    if(isset($id)){
    $sql = "DELETE FROM Registros WHERE id_cliente = :id";
    $stmt = $this->DB->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
try {
    $stmt->execute();
}catch (PDOException $e) {
    echo "Error al eliminar el registro: " . $e->getMessage();
    die();
}
    return $stmt;
}else{
    return false;
}
}

public function conseguirRegistro($id){
    if(isset($id)){
    $sql = "SELECT * FROM Registros WHERE id_registro = :id";
    $stmt = $this->DB->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    try{

$stmt->execute();
}catch(PDOException $e){
die("Error al conseguir registro: ".$e->getMessage());
}
    return $stmt;
}else{
 return false;
}
}

public function actualizarRegistro($datos){
    if(isset($datos)){
    $sql = "UPDATE Registros SET descripcion = :descripcion WHERE id_cliente = :id_cliente AND id_registro = :id_registro";
            $stmt = $this->DB->prepare($sql);
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_registro', $datos['id_registro'], PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            try{
            $stmt->execute();
}catch(PDOException $e){
die("Error al actualizar: ".$e->getMessage());
}
return $stmt;
}else{
// Datos no enviados
return false;
}
}

}
