<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/DatosSeguroBanco.css\">";
$cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
echo "<div id='contenedor'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
if(isset($_GET['cliente'])){
    $cliente = $_GET['cliente'];
    $DB = new DatosManager(tabla: 'Cuentas');
    $cuentas= $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
    if($cuentas->rowCount() > 0){
    echo "<div id='datos'>";
    echo "<h1>Informacion Bancaria</h1>";
    foreach ($cuentas as $dato) {
        echo "<p><b>Numero de cuenta: </b> $dato[numero_cuenta]</p>";
        echo "<p><b>Tipo de cuenta: </b> $dato[tipo_cuenta]</p>";
        echo "<a href='?controller=Paneles&action=InfoBanco&cliente=$cliente&banco=1'>Editar</a> ";
        echo "<a href='?controller=Cliente&action=eliminar_banco&cliente=$cliente'>Eliminar</a>";
    }
    echo "</div></div>";
    }else{
        require_once 'Vistas/paneles/Formularios/formularioBanco.php';
    }
}