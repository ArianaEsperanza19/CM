<?php
#session_start();
require_once 'Herramientas/DatosManager.php';
class PanelesController 
{
    public function principal() {
        require_once 'Vistas/paneles/principal.php';
    }
    public function nuevo_titular() {
        require_once 'Vistas/subpaneles/nuevo_titular.php';
    }
    public function formularioConyugal() {
       require_once 'Vistas/subpaneles/formularioConyugal.php'; 
    }
    public function formularioDepende() {
        require_once 'Vistas/subpaneles/formularioDepende.php';
    }
    public function info() {
    if (isset($_GET['cliente'])) {
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/subpaneles/info.php';
    }
    }
    public function editar() {
        if(isset($_GET['cliente'])){
            global $cliente; 
            $cliente = $_GET['cliente'];
            if(isset($_GET['depende'])){
            global $depende;
            $depende = true;
            require_once 'Vistas/subpaneles/formularioDepende.php';
            }
            if(isset($_GET['conyugue'])){
            global $conyugue;
            $conyugue = true;
            require_once 'Vistas/subpaneles/formularioConyugal.php';
            }
        }
        if(isset($_GET['cliente_titular'])){
            global $editar_titular;
            $editar_titular = $_GET['cliente_titular'];
            require_once 'Vistas/subpaneles/nuevo_titular.php';
        }}
    public function advertencia(){
        if($_GET['cliente']){
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/subpaneles/Advertencia.php';
        }else{
            echo "No se ha enviado un cliente";
        }
    }
    public function segurosInfo(){
        if(isset($_GET['cliente'])){
        if(isset($_GET['seguro']) == 1){
        $_SESSION['seguro'] = true;
        require_once 'Vistas/subpaneles/formularioSeguro.php';
        }
        if(!isset($_GET['seguro']) || isset($_GET['seguro']) != 1){
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/subpaneles/segurosInfo.php'; 
        }
        }else{
            echo "No se ha enviado un cliente";
        }
    }
    public function bancoInfo(){
        if(isset($_GET['cliente'])){
        if(isset($_GET['banco']) == 1){
        $_SESSION['banco'] = true;
        require_once 'Vistas/subpaneles/formularioBanco.php';
        }
        if(!isset($_GET['banco']) || isset($_GET['banco']) != 1){
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/subpaneles/bancoInfo.php';

        }
        }else{
            echo "No se ha enviado un cliente";
        }
    }
    
    }

