<?php

require_once "Modelos/Mensajes.php";
$mensajes = new Mensajes();

if (isset($_SESSION['advertencia'])) {
    header('Location: ?controller=Paneles&action=info&cliente='.$cliente);
    unset($_SESSION['advertencia']);
} else {
    if (isset($_GET['opcion'])) {
        switch ($_GET['opcion']) {
            case "eliminarTodos":
                $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> la poliza de este cliente y todos sus registros asociados?";
                $redireccion = "?controller=Cliente&action=Eliminar&cliente=$cliente";
                break;
            case "eliminarConyuge":
                $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> al conyuge del titular?";
                // $redireccion = "?controller=Cliente&action=Eliminar&cliente=$miembro&conyugue=1&titular=$cliente";
                $redireccion = "?controller=Conyuge&action=Eliminar&miembro=$miembro&titular=$cliente";
                break;
            case "eliminarDependiente":
                $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> al dependiente del titular?";
                // $redireccion = "?controller=Cliente&action=Eliminar&cliente=$miembro&depende=1&titular=$cliente";
                $redireccion = "?controller=Depende&action=Eliminar&miembro=$miembro&titular=$cliente";
                break;
            default:
                echo "error, opcion no valida: $_GET[opcion]";
                break;
        }
        $mensajes->advertencia($texto, $cliente, $redireccion);
        exit;
    }

}
