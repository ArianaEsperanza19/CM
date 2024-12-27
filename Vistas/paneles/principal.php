<head>
  <link rel="stylesheet" type="text/css" href="Vistas/css/info.css">
</head>
<?php
require_once 'Barras/Header.php';
require_once 'Barras/Barra_buscador.php';
# Si no hay clientes, mostrar el panel de nuevo titular
echo "<a href='?controller=Paneles&action=nuevo_titular' id='nuevo_titular'>Nuevo Cliente</a>";
require_once 'Modelos/DatosManager.php';
$DB = new DatosManager(tabla: 'Titulares');
$titulares = $DB->Conseguir_Todos();
if($titulares){
echo "<div id='titularesBox'>
<h1>Titulares</h1>";
if(isset($_SESSION['flash']) && $_SESSION['flash'] != 'vacio'){
    $mensaje = $_SESSION['flash'];
    unset($_SESSION['flash']);
    echo "<p class='mensaje'><b>$mensaje</b></p>";
}
foreach($titulares as $titular){
echo "<p class='lista'>".$titular['id_cliente']." - ".$titular['nombre']." ".$titular['primer_apellido'].
" <a href='?controller=Paneles&action=info&cliente=".$titular['id_cliente']."'>mas</a></p>";
}
echo "</div>";// Fin de lista de titulares
}else{
header('Location: ?controller=Paneles&action=principal');
}
?>
<?php
require_once 'Barras/Footer.php';
?>