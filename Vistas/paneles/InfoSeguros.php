<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/DatosSeguroBanco.css\">";
if(isset($_GET['cliente'])){
    $cliente = $_GET['cliente'];
    $db = new DatosManager(tabla: 'Datos_Seguro');
    $seguros = $db->conseguir_registro("where id_cliente = $cliente");
    if($seguros->rowCount() > 0){
    $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
    echo "<div id='contenedor'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
    echo "<div id='datos'>";
    echo "<h1>Info del seguro</h1>";
    foreach ($seguros as $dato) {
        echo "<p><b>Numero de poliza: </b> $dato[policy_number]</p>";
        echo "<p><b>Numero de miembro: </b> $dato[member_number]</p>";
        echo "<p><b>Numero de grupo: </b> $dato[group_number]</p>";
        echo "<p><b>Plan: </b> $dato[plan_seguro]</p>";
        echo "<br>";
        echo "<a href='?controller=Paneles&action=InfoSeguros&cliente=$cliente&seguro=1'>Editar</a> ";
        echo "<a href='?controller=Cliente&action=eliminar_seguro&cliente=$cliente'>Eliminar</a>";
        echo "</div></div>";
    }   
    }else{
        require_once 'Vistas/paneles/Formularios/formularioSeguro.php';
    }
        
}