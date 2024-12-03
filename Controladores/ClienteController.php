<?php
require_once 'Herramientas/DatosManager.php';

class ClienteController 
{
    public function VerTodos() {
    }
    public function VerUno() {
    }
    public function Crear() {
        //echo "Soy el formulario para un nuevo cliente";
        if(isset($_POST)) {
            $_SESSION['registro'] = true;
            $datos = new DatosManager(tabla : 'Titulares');
            $sentencia = $datos->Registrar($_POST);
            $cliente_id = $datos->Ultimo_Registro();
            $cliente_id = $cliente_id['id_cliente'];
            if($sentencia){
                
            if($_POST['matrimonio'] || $_POST['dependientes']){
                echo "Se debe proceder a agregar dependientes y/o conyugue";
                $_SESSION['dependientes'] = $_POST['dependientes'];
                header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id");
            }
            //header('Location: ?controller=Paneles&action=principal');
            }
        }
    }
    public function Agregar_Conyugue() {
        if(isset($_POST)) {
        if($_GET['id_cliente']){
            $id_cliente = $_GET['id_cliente'];
        }
        $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
        require_once 'Modelos/Grupo.php';
        $registro = new Grupo($DB);
        $sentencia = $registro->registrar($_POST, $id_cliente);
        var_dump($sentencia);
        if(isset($_SESSION['dependientes']) && $_SESSION['dependientes'] > 0){
            header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
        }
    }}

    public function Agregar_Depende(){
        echo "Soy el formulario para Dependientes";
        if(isset($_POST)) {
        if($_GET['id_cliente']){
            $id_cliente = $_GET['id_cliente'];
        }
        var_dump($_POST);
        $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
        require_once 'Modelos/Grupo.php';
        $registro = new Grupo($DB);
        $sentencia = $registro->registrar($_POST, $id_cliente);
        echo $sentencia;
        echo $_SESSION['dependientes'];
    }}
    public function Editar() {

    }
    public function Eliminar() {

    }
    public function Buscar() {
        
    }

}
