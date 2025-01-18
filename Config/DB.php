<?php
$_SESSION['DB_name'] = "AsistenteSeguros";
$_SESSION['DB_user'] = "root";
$_SESSION['DB_pass'] = "";
$_SESSION['DB_host'] = "localhost";
class DB{
    public static function Connect(){
    try {
    $conexion = new PDO("mysql:host=".$_SESSION['DB_host'].";dbname=".$_SESSION['DB_name'], $_SESSION['DB_user'], $_SESSION['DB_pass']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$conexion = new mysqli("localhost", "root", "", "digitienda");
		$conexion->query("SET NAMES 'utf8'");
    }catch(PDOException $e){ {
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/advertencia.css\">";
    echo "<div id='advertencia' style='margin-top: 5%;'>";
    if($e->getCode() == 1049){
    echo "<p>Error de Conexión:<p>"."<p style='color:red;'>".$e->getMessage()."</p>";
    echo "<p style='color:red;'>Base de datos no encontrada, verifique los datos del archivo 'Config/DB.php'</p>";
    }else{
    echo "<p>Error de Conexión:<p>"."<p style='color:red;'>".$e->getMessage()."</p>";
    }
    echo "<a class='boton' href='?controller=DB&action=crear'>Crear nueva</a>";
    }
    echo "</div>";
    }
		return $conexion;
    }
}
?>
