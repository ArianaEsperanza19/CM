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
            if($_POST['matrimonio']){
                echo "Esta casado";
            }
            if($_POST['dependientes']){
                echo "Tiene". $_POST['dependientes'] . "dependientes";
            }
            $datos = new DatosManager(tabla : 'Titulares');
            $sentencia = $datos->Registrar($_POST);
            var_dump($sentencia);
            header('Location: ?controller=Paneles&action=principal');
        }
    }
    public function Editar() {

    }
    public function Eliminar() {

    }
    public function Buscar() {
        
    }

}
