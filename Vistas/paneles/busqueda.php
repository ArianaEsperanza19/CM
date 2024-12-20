<?php
require_once 'Barras/Header.php';
require_once 'Barras/Barra_buscador.php';
# Si no hay clientes, mostrar el panel de nuevo titular
echo "<a href='?controller=Paneles&action=nuevo_titular'>Nuevo Cliente</a>";
if($sentencia){
            foreach ($sentencia as $dato) {
                echo "<br>".$dato['id_cliente']." - ".$dato['nombre']." ".$dato['primer_apellido'].
                " <a href='?controller=Paneles&action=info&cliente=".$dato['id_cliente']."'>mas</a>";
            }
}else{
header('Location: ?controller=Paneles&action=principal');
}
require_once 'Barras/Footer.php';
?>