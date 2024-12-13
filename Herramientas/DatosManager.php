<?php
$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/CustomersManager/Config/DB.php';
class DatosManager{

    protected $id;
    protected $DB;
    protected $tabla;
      public function __construct($id = null, $tabla = null){
    /**
     * Constructor de la clase. Establece la conexion a la base de datos
     * y los valores de la tabla y el ID.
     * @param int $id El ID de la tabla.
     * @param string $tabla El nombre de la tabla.
     */
        $this->tabla = $tabla;
        $this->id = $id;
        $this->DB = DB::Connect();
      }    
    public function __destruct(){
    /**
     * Destructor de la clase. Cierra la conexion a la base de datos.
     */
        $this->DB = null;
    }
    public function get_id(){
        return $this->id;
    }
    public function set_id($id){
        $this->id = $id;
    }
    public function Conseguir_Todos(){
    /*
     * Consigue todos los registros de una tabla dada.
     * 
     * @param string $tabla El nombre de la tabla en la que se buscan los registros.
     * @return array -> Un array con todos los registros de la tabla.
     */
        $tabla = $this->tabla;
        $datos = $this->DB->prepare("SELECT * FROM $tabla");
        $datos->execute();
        $datos = $datos->fetchAll();
        return $datos;

    }
    public function Conseguir_Registro($condicion){
    /**
     * Consigue un registro de una tabla dada.
     * 
     * @param string $condicion La condicion de busqueda para el registro.
     * @return PDOStatement La sentencia de selección ejecutada.
     * @throws Exception Si la tabla no existe.
     */

        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$this->tabla'";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        if($sentencia->fetchColumn() == 0){
            throw new Exception("La tabla '$this->tabla' no existe");
        }else{
        $sql = "SELECT * FROM $this->tabla $condicion";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        }
        return $sentencia;
    }
    public function Ultimo_Registro(){
        $sql = "SELECT * FROM $this->tabla ORDER BY id_cliente DESC LIMIT 1";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetch();
    }
    public function Restaurar(){
    /*
    Restaura la tabla truncándola.
    Este método verifica si la tabla existe en la base de datos y, si es así,
    la trunca eliminando todos los registros.

    @throws Exception Si la tabla no existe en la base de datos.
    @return PDOStatement La sentencia de truncado ejecutada.
     */
        $tabla = $this->tabla;
        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$tabla'";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        if($sentencia->fetchColumn() == 0){
            throw new Exception("La tabla '$tabla' no existe");
        }else{
        $sql = "TRUNCATE TABLE $tabla";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        }
        return $sentencia;
    }
    public function Registrar($datos) {
    /**
     * Registra un nuevo titular en la base de datos.
     * Este método verifica si todos los campos de la tabla se han rellenado correctamente
     * y, si es así, registra un nuevo titular en la base de datos.
     * Devuelve la sentencia preparada ejecutada.
     * 
     * @param array $datos Arreglo con los datos a registrar.
     * @return PDOStatement|false La sentencia preparada ejecutada o false en caso de error.
     */
    
    // Verificar que todos los campos obligatorios estén presentes
   // if (empty($datos['nombre']) || empty($datos['primer_apellido']) || empty($datos['ssn']) || empty($datos['fecha_nacimiento']) || empty($datos['direccion']) || empty($datos['ciudad']) || empty($datos['estado']) || empty($datos['codigo_postal']) || empty($datos['telefono']) || empty($datos['email'])) {
    //    return false;
    //}

    // Asignar valores
    $tabla = $this->tabla;
    $this->DB = DB::Connect();

    // Construir la sentencia SQL
    $sql = "INSERT INTO $tabla (nombre, segundo_nombre, primer_apellido, segundo_apellido, SSN, alien_number, genero, fecha_nacimiento, direccion, ciudad, estado, codigo_postal, telefono, email, empresa, notas, actualizado) 
            VALUES (:nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :SSN, :alien_number, :genero, :fecha_nacimiento, :direccion, :ciudad, :estado, :codigo_postal, :telefono, :email, :empresa, :notas, :actualizado)";
    
    $stmt = $this->DB->prepare($sql);

    // Vincular los parámetros con los datos
    $stmt->bindParam(':nombre', $datos['nombre']);
    $stmt->bindParam(':segundo_nombre', $datos['segundo_nombre']);
    $stmt->bindParam(':primer_apellido', $datos['primer_apellido']);
    $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido']);
    $stmt->bindParam(':SSN', $datos['ssn']);
    $stmt->bindParam(':alien_number', $datos['alien_number']);
    $stmt->bindParam(':genero', $datos['genero']);
    $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
    $stmt->bindParam(':direccion', $datos['direccion']);
    $stmt->bindParam(':ciudad', $datos['ciudad']);
    $stmt->bindParam(':estado', $datos['estado']);
    $stmt->bindParam(':codigo_postal', $datos['codigo_postal']);
    $stmt->bindParam(':telefono', $datos['telefono']);
    $stmt->bindParam(':email', $datos['email']);
    $stmt->bindParam(':empresa', $datos['empresa']);
    //$stmt->bindParam(':declaracion_fiscal', $datos['declaracion_fiscal'], PDO::PARAM_BOOL);
    //$stmt->bindParam(':actualizado', $datos['actualizado'], PDO::PARAM_BOOL);
    $stmt->bindParam(':notas', $datos['notas']);
    $stmt->bindParam(':actualizado', $datos['actualizado']);
    
    // Ejecutar la sentencia
    if ($stmt->execute()) {
        return $stmt;
    } else {
        return false;
    }
}

        public function Eliminar(){
    /**
     * Elimina un registro de la base de datos.
     * Este método elimina un registro de la base de datos con base en el ID.
     * Si el registro se elimino correctamente, devuelve la sentencia preparada ejecutada.
     * @return PDOStatement La sentencia preparada ejecutada.
     */
        $table = $this->tabla;
        $id = $this->id;
        $stmt = $this->DB->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }
    public function Editar($datos){
    /**
     * Edita un registro de la base de datos.
     * Este método edita un registro de la base de datos con base en el ID.
     * Si el registro se edito correctamente, devuelve la sentencia preparada ejecutada.
     * @param array $datos Arreglo con los datos a editar.
     * @return PDOStatement La sentencia preparada ejecutada.
     */
        $table = $this->tabla;
        $id = $this->id;
        $sql = "
        UPDATE $table SET 
        role = :role, 
        name = :name, 
        surname = :surname, 
        nick = :nick, 
        email = :email, 
        password = :password, 
        updated_at = CURDATE() 
        WHERE id = :id";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':role', $datos['role']);
        $stmt->bindParam(':name', $datos['name']);
        $stmt->bindParam(':surname', $datos['surname']);
        $stmt->bindParam(':nick', $datos['nick']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':password', $datos['password']);
        #$stmt->bindParam(':image', $datos['image']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;


    }
    public function Cifrar($datos){
    /**
     * Cifra un string con password_hash.
     * @param string $datos String a cifrar.
     * @return string El string cifrado.
     */
        //return password_hash($datos, PASSWORD_BCRYPT);
        return password_hash($datos, PASSWORD_DEFAULT);
    }
    public function Descifrar($entrada){
        $id = $this->id;
        $consulta = $this->Conseguir_Registro("WHERE id = $id");
        $fetch = $consulta->fetch(PDO::FETCH_ASSOC);
        $password_hash = $fetch['password'];
        if (password_verify($entrada, $password_hash)) {
            return true;
        } else {
            return false;
        }
    }
}
?>