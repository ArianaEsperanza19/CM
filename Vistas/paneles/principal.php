<?php
require_once 'Barras/Header.php';
require_once 'Barras/Barra_buscador.php';
if($_SESSION['cliente']){
require_once 'Barras/Navegador.php';
}
# Si no hay clientes, mostrar el panel de nuevo titular
echo "<a href='?controller=Paneles&action=nuevo_titular'>Nuevo Cliente</a>";
require_once 'Herramientas/DatosManager.php';
$DB = new DatosManager(tabla: 'Titulares');
$titulares = $DB->Conseguir_Todos();
if($titulares){
foreach($titulares as $titular){
echo "<br>".$titular['id_cliente']." - ".$titular['nombre']." ".$titular['primer_apellido'].
" <a href='?controller=Paneles&action=info&cliente=".$titular['id_cliente']."'>mas</a>";
}
}else{
header('Location: ?controller=Paneles&action=principal');
}
?>
<?php
require_once 'Barras/Footer.php';
?>