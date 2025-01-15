<head>
  <link rel="stylesheet" type="text/css" href="Vistas/css/info.css">
</head>
<?php
require_once 'Barras/Header.php';
require_once 'Barras/Barra_buscador.php';
# Si no hay clientes, mostrar el panel de nuevo titular
echo "<a href='?controller=Paneles&action=nuevo_titular' id='nuevo_titular'>Nuevo Cliente</a>";
if($sentencia){
echo "<div id='titularesBox'>";
echo "<h1>Titulares</h1>";
            foreach ($sentencia as $dato) {
                echo "<p class='lista'>".$dato['id_cliente']." - ".$dato['nombre']." ".$dato['primer_apellido'].
                " <a href='?controller=Paneles&action=info&cliente=".$dato['id_cliente']."'>mas</a></p>";
            }
echo "</div>";
}else{
header('Location: ?controller=Paneles&action=index');
}
require_once 'Barras/Footer.php';
?>
