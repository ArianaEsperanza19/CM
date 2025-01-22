<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/advertencia.css\">";
if (isset($_SESSION['advertencia'])) {
    header('Location: ?controller=Paneles&action=info&cliente='.$cliente);
    unset($_SESSION['advertencia']);
}

function advertencia($texto, $cliente, $redireccion)
{
    echo "<div id='advertencia'>";
    echo $texto."<br>";
    echo "<a class='boton' style='color: red;' href='$redireccion'>Si</a><br>";
    echo "<a class='boton' style='color: green;' href='?controller=Paneles&action=info&cliente=$cliente'>No</a>";
    echo "</div>";

}

if (isset($_GET['opcion'])) {
    switch ($_GET['opcion']) {
        case "eliminarTodos":
            $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> la poliza de este cliente y todos sus registros asociados?";
            $redireccion = "?controller=Cliente&action=Eliminar&cliente=$cliente";
            break;
        case "eliminarConyuge":
            $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> al conyuge del titular?";
            $redireccion = "?controller=Cliente&action=Eliminar&cliente=$miembro&conyugue=1&titular=$cliente";
            break;
        case "eliminarDependiente":
            $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> al dependiente del titular?";
            $redireccion = "?controller=Cliente&action=Eliminar&cliente=$miembro&depende=1&titular=$cliente";
            break;
        default:
            echo "error, opcion no valida: $_GET[opcion]";
            break;
    }
    advertencia($texto, $cliente, $redireccion);
    exit;
}
