<?php
$rootDir = dirname(dirname(__DIR__));
require_once $rootDir.'/Login-Register-Logout/DB/DB.php';
class Admin{
    protected $id = null;
    protected $tabla = '';
    protected $DB;

    public function __construct($id = null, $tabla = null){
        $this->tabla = $tabla;
        $this->id = $id;
        $this->DB = DB::Connect();
    }
    public function __destruct(){
        $this->DB = null;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
    public function Registrar($datos){
    /**
     * Registra un nuevo administrador en la base de datos.
     * Este m todo verifica si ya existe un administrador y, si no existe, registra uno nuevo.
     * Devuelve una cadena con el resultado de la operacion.
     * @param array $datos Arreglo con los datos del nuevo registro.
     * @return string La sentencia preparada ejecutada.
     */
        #Verifica si ya existe un administrador
        $admin = $this->Verificar_Admin_En_DB();
        if($admin){
        #Construir la sentencia para registrar un nuevo administrador
        $sql = "INSERT INTO $this->tabla (role, name, surname, nick, email, password, image, created_at, updated_at) VALUES ('Admin', :name, :surname, :nick, :email, :password, :image, CURDATE(), CURDATE())";
        $stmt = $this->DB->prepare($sql);
        #Asignar valores
        #$stmt->bindParam(':role', 'admin');
        $stmt->bindParam(':name', $datos['name']);
        $stmt->bindParam(':surname', $datos['surname']);
        $stmt->bindParam(':nick', $datos['nick']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':password', $datos['password']);
        $stmt->bindParam(':image', $datos['image']);
        #Ejecutar
        $stmt->execute();
        #Cerrar conexion
        if($stmt){
            return 'Admin registrado';
        }
        }else{
            return 'Admin ya registrado';
        }
    }
    public function Iniciar_sesion(){
    /**
     * Verifica si el usuario actual es administrador.
     * Si es administrador, se establece la variable de sesion 'admin' en true.
     * Si no es administrador, se establece la variable de sesion 'admin' en false.
     * @return string con el rol del usuario.
     */
        $table = $this->tabla;
        $stmt = $this->DB->prepare("SELECT role FROM $table WHERE id = :id;");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        if($datos['role'] == 'Admin' && $_SESSION['admin'] != true){
            $_SESSION['admin'] = true;
        }else{
            $_SESSION['admin'] = false;
        }
        return $datos['role'];
    }
    public function Cerrar_sesion(){
    /**
     * Cierra la sesion del administrador.
     * Si el usuario actual es administrador, se establece la variable de sesion 'admin' en false.
     * Si el usuario actual no es administrador, no se hace nada.
     */
        if($_SESSION['admin'] == true){
            $_SESSION['admin'] = false;
        }else{
            $_SESSION['admin'] = false;
        }
    }
    public function Cambiar_Admin(){
    /**
     * Cambia el administrador actual por el especificado en $this->id.
     * Verifica la existencia del nuevo administrador y, si existe, cambia su rol a 'Admin'.
     * Luego, cambia el rol del administrador actual a 'user'.
     * @return string con el resultado de la operacion.
     */
        #Encontrar administrador
        $sql = "SELECT id FROM $this->tabla WHERE role = 'Admin';";
        $stmt = $this->DB->prepare($sql);
        $stmt->execute();
        $admin_actual = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin_actual = $admin_actual['id'];

        #Verificar existencia del nuevo administrador
        $sql = "SELECT id FROM $this->tabla WHERE id = :id;";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $admin_nuevo = $stmt->fetch(PDO::FETCH_ASSOC);
        #Se hace el cambio si la id recibida existe
        if($admin_nuevo){
        #Cambia el rol del actual administrador
        $sql = "UPDATE $this->tabla SET role = 'user' WHERE id = :id;";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':id', $admin_actual);
        $stmt->execute();
        
        if($stmt){
        #Cambia el rol del nuevo administrador
        $sql = "UPDATE $this->tabla SET role = 'Admin' WHERE id = :id;";
        $nuevo = $this->DB->prepare($sql);
        $nuevo->bindParam(':id', $this->id);
        $nuevo->execute();
        }
        if($stmt){
            return 'Admin cambiado';
        }
        #Nuevo administrador
        }else{
            return 'El ID dada no existente';
        }
    }
    public function Datos_del_Admin(){
    /**
     * Devuelve los datos del administrador en un arreglo asociativo.
     * 
     * @return array con los datos del administrador.
     */
        $sql = "SELECT * FROM $this->tabla WHERE role = 'Admin';";
        $stmt = $this->DB->prepare($sql);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        return $admin;
    }
    public function Verificar_Status_Admin(){
    /**
     * Verifica si el usuario actual es administrador.
     * Si es administrador, se devuelve true.
     * Si no es administrador, se devuelve false.
     * @return boolean True si el usuario actual es administrador, false de lo contrario.
     */
        if($_SESSION['admin'] == true){
            return true;
        }else{
            return false;}
    }
    public function Verificar_Admin_En_DB(){
    /**
     * Verifica si ya existe un administrador en la base de datos.
     * 
     * @return boolean True si ya existe un administrador, false de lo contrario.
     */
        $sql = "SELECT role FROM $this->tabla WHERE role = 'Admin';";
        $centinela = $this->DB->prepare($sql);
        $centinela->execute();
        $admin = $centinela->fetch(PDO::FETCH_ASSOC);
        if($admin){
            return true;
        }else{
            return false;
        }
    }
}
?>