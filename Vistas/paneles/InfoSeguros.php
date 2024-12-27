<?php
if(isset($_GET['cliente'])){
    $cliente = $_GET['cliente'];
    $db = new DatosManager(tabla: 'Datos_Seguro');
    $seguros = $db->conseguir_registro("where id_cliente = $cliente");
    if($seguros->rowCount() > 0){
    $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
    echo "<a href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
    echo "<h1>Informacion del seguro</h1>";
    foreach ($seguros as $dato) {
        echo "<hr>";
        echo "<p><b>numero de poliza: </b> $dato[policy_number]</p>";
        echo "<p><b>numero de miembro: </b> $dato[member_number]</p>";
        echo "<p><b>numero de grupo: </b> $dato[group_number]</p>";
        echo "<p><b>Plan: </b> $dato[plan_seguro]</p>";
        echo "<a href='?controller=Paneles&action=InfoSeguros&cliente=$cliente&seguro=1'>Editar</a> ";
        echo "<a href='?controller=Cliente&action=eliminar_seguro&cliente=$cliente'>Eliminar</a>";
        echo "<hr>";
    }   
    }else{
        require_once 'Vistas/Formularios/formularioSeguro.php';
    }
        
}