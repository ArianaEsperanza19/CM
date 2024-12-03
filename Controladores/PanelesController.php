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
       echo $_SESSION['cliente'];
       require_once 'Vistas/subpaneles/formularioConyugal.php'; 
    }
    public function formularioDepende() {
        require_once 'Vistas/subpaneles/formularioDepende.php';
    }
}
