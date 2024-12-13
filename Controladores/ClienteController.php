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
            print_r($sentencia);
            $cliente_id = $datos->Ultimo_Registro();
            $cliente_id = $cliente_id['id_cliente'];
            if($sentencia){
            echo "Matrimonio";
            echo $_POST['matrimonio'];
            echo "Dependientes";
            echo $_POST['dependientes'];
            
            
            if($_POST['matrimonio'] == 1 && $_POST['dependientes'] == 0){
                header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id&depende=0");
                //die('detenido en matrimonio 1 y dependientes 0');
            }
            if($_POST['dependientes'] == 1 && $_POST['matrimonio'] == 1){
                header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id&depende=1");
                //die('detenido en dependientes 1 y matrimonio 1');
            }
            if($_POST['dependientes'] == 1 && $_POST['matrimonio'] == 0){
                header("Location: ?controller=Paneles&action=formularioDepende"."&id_cliente=$cliente_id&depende=1");
                //die('detenido en dependientes 1 y matrimonio 0');
            }
            if($_POST['matrimonio'] == 0 && $_POST['dependientes'] == 0){
                header('Location: ?controller=Paneles&action=principal');
            } 
            }else{
                header('Location: ?controller=Paneles&action=principal');
            }}
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
        if($_GET['depende'] == 1){
            
            header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
        }
        if($_GET['depende'] == 0){
            header('Location: ?controller=Paneles&action=principal');
        }
        
    }}

    public function Agregar_Depende(){
        echo "Soy el formulario para Dependientes";
        if(isset($_POST) && $_SESSION['dependientes'] > 0){ {
        if($_GET['id_cliente']){
            $id_cliente = $_GET['id_cliente'];
        }
        var_dump($_POST);
        $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
        require_once 'Modelos/Grupo.php';
        $registro = new Grupo($DB);
        $sentencia = $registro->registrar($_POST, $id_cliente);
        header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
    }}}
    public function Editar() {

    }
    public function Eliminar() {

    }
    public function Buscar() {
        
    }

}
