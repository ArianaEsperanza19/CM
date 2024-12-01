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
}
