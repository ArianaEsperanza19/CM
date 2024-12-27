<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/advertencia.css\">";
if(isset($_SESSION['eliminar']) == true){
    echo "<div id='advertencia'>";
    echo "¿Realmente desea <b style='color: red;'>eliminar</b> la poliza de este cliente?<br>";
    echo "<a class='boton' style='color: red;' href='?controller=Cliente&action=Eliminar&cliente=$cliente'>Si</a><br>";
    echo "<a class='boton' style='color: green;' href='?controller=Paneles&action=info&cliente=$cliente'>No</a>";
    echo "</div>";
    unset($_SESSION['eliminar']);
}
