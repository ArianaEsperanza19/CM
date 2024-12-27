<?php
if(isset($_SESSION['eliminar']) == true){
    echo "¿Realmente desea eliminar la poliza de este cliente?<br>";
    echo "<a href='?controller=Cliente&action=Eliminar&cliente=$cliente'>Si</a><br>";
    echo "<a href='?controller=Paneles&action=info&cliente=$cliente'>No</a>";
    unset($_SESSION['eliminar']);
}
