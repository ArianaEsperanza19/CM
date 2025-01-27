<head>
  <link rel="stylesheet" type="text/css" href="Vistas/css/index.css">
</head>
<?php
require_once 'Barras/Header.php';
require_once 'Barras/Barra_buscador.php';
require_once 'Modelos/Titulares.php';
require_once 'Modelos/Paginacion.php';
# Si no hay clientes, mostrar el panel de nuevo titular
echo "<a href='?controller=Paneles&action=formularioTitular' id='formularioTitular'>Nuevo Cliente</a>";
$DB = new Titulares();
$titulares = $DB->Conseguir_Todos();
$paginacion = new Paginacion($titulares);
$pag = null;
if (isset($_GET['pag'])) {
    $pag = $_GET['pag'];
} else {
    $pag = 1;
}
$titulares = $paginacion->paginar($pag);
if ($titulares) {
    echo "<div id='titularesBox'>
<h1>Titulares</h1>";
    if (isset($_SESSION['flash'])) {
        $mensaje = $_SESSION['flash'];
        unset($_SESSION['flash']);
        require_once "Modelos/Mensajes.php";
        $aviso = new Mensajes();
        echo $aviso->noEncontrado($mensaje);
    }
    foreach ($titulares as $titular) {
        echo "<p class='lista'>".$titular['id_cliente']." - ".$titular['nombre']." ".$titular['primer_apellido'].
        " <a href='?controller=Paneles&action=info&cliente=".$titular['id_cliente']."'>mas</a></p>";
    }
    echo "</div>";// Fin de lista de titulares
    $numpag = $paginacion->getNumPaginas();
    // Paginacion
    if ($numpag > 1) {
        echo "<div class='paginacion'>~~~ ";
        for ($i = 1; $i <= $numpag; $i++) {
            echo "<a href='?controller=Paneles&action=index&pag=$i'>|$i|</a>";
        }
        echo " ~~~</div>";
    } else {
        // Solo hay una pagina
        echo '<br>';
    }
} else {
    //Error: No hay titulares
    header('Location: ?controller=Paneles&action=formularioTitular');
}
require_once 'Barras/Footer.php';
?>
