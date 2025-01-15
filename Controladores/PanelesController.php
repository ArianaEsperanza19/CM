<?php
#session_start();
require_once 'Modelos/DatosManager.php';
class PanelesController
{
    public function index() {
        require_once 'Vistas/paneles/principal.php';
    }
    public function nuevo_titular() {
        require_once 'Vistas/paneles/Formularios/nuevo_titular.php';
    }
    public function formularioConyugal() {
       require_once 'Vistas/paneles/Formularios/formularioConyugal.php';
    }
    public function formularioDepende() {
        require_once 'Vistas/paneles/Formularios/formularioDepende.php';
    }
    public function formularioRegistro(){
        if(isset($_GET['cliente'])){
            global $cliente;
            $cliente = $_GET['cliente'];
        }
        require_once 'Vistas/paneles/Formularios/formularioRegistro.php';

}
    public function info() {
    if (isset($_GET['cliente'])) {
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/paneles/info.php';
    }
    }
    public function editar() {
        if(isset($_GET['cliente'])){
            global $cliente;
            $cliente = $_GET['cliente'];
            if(isset($_GET['depende'])){
            global $depende;
            $depende = true;
            require_once 'Vistas/paneles/Formularios/formularioDepende.php';
            }
            if(isset($_GET['conyugue'])){
            global $conyugue;
            $conyugue = true;
            require_once 'Vistas/paneles/Formularios/formularioConyugal.php';
            }
        }
        if(isset($_GET['cliente_titular'])){
            global $editar_titular;
            $editar_titular = $_GET['cliente_titular'];
            require_once 'Vistas/paneles/Formularios/nuevo_titular.php';
        }}
    public function advertencia(){
        if($_GET['cliente']){
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/paneles/Advertencia.php';
        }else{
            echo "No se ha enviado un cliente";
        }
    }
    public function InfoSeguros(){
        if(isset($_GET['cliente'])){
        global $cliente;
        $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
        # Editar
        if(isset($_GET['seguro']) == 1){
        $_SESSION['seguro_centinela'] = true;
        require_once 'Vistas/paneles/Formularios/formularioSeguro.php';
        }
        if(!isset($_GET['seguro']) || isset($_GET['seguro']) != 1){
        require_once 'Vistas/paneles/InfoSeguros.php';
        }
        }else{
            echo "No se ha enviado un cliente";
        }
    }
    public function InfoBanco(){
        if(isset($_GET['cliente'])){
        global $cliente;
        $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
        if(isset($_GET['banco']) == 1){
        $_SESSION['banco_centinela'] = true;
        require_once 'Vistas/paneles/Formularios/formularioBanco.php';
        }
        if(!isset($_GET['banco']) || isset($_GET['banco']) != 1){
        require_once 'Vistas/paneles/InfoBanco.php';

        }
        }else{
            echo "No se ha enviado un cliente";
        }
    }

    public function pagina_img(){
        if (isset($_GET['cliente'])){
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/paneles/pagina_img.php';
        }else{
        die("No se ha enviado un cliente");
        }
    }

    }

