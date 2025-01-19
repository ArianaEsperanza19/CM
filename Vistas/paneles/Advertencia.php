<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/advertencia.css\">";

function advertencia($texto, $cliente, $redireccion){
    echo "<div id='advertencia'>";
    echo $texto."<br>";
    echo "<a class='boton' style='color: red;' href='$redireccion'>Si</a><br>";
    echo "<a class='boton' style='color: green;' href='?controller=Paneles&action=info&cliente=$cliente'>No</a>";
    echo "</div>";

}

if(isset($_GET['opcion']) == "eliminarTodos"){
    $texto ="¿Realmente desea <b style='color: red;'>eliminar</b> la poliza de este cliente?";
    $redireccion = "?controller=Cliente&action=Eliminar&cliente=$cliente";
    advertencia($texto, $cliente, $redireccion);

}elseif(isset($_GET['opcion']) == "eliminarConyuge"){
    $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> al conyuge del titular?";
    $redireccion = "?controller=Cliente&action=Eliminar&cliente=$miembro&conyugue=1&titular=$cliente";
    advertencia($texto,$cliente,$redireccion);
    exit;
}elseif(isset($_GET['opcion']) == "eliminarDependiente"){
    $texto = "¿Realmente desea <b style='color: red;'>eliminar</b> al dependiente del titular?";
    $redireccion = "?controller=Cliente&action=Eliminar&cliente=$miembro&dependiente=1&titular=$cliente";
    advertencia($texto,$cliente,$redireccion);
    exit;

}

?>
