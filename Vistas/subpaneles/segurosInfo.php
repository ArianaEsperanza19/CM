<?php
if(isset($_GET['cliente'])){
    $cliente = $_GET['cliente'];
    $db = new DatosManager(tabla: 'Datos_Seguro');
    $seguros = $db->conseguir_registro("where id_cliente = $cliente");
    if($seguros->rowCount() > 0){
    echo "<h1>Informacion del seguro</h1>";
    foreach ($seguros as $dato) {
        echo "<hr>";
        echo "<p><b>numero de poliza: </b> $dato[policy_number]</p>";
        echo "<p><b>numero de miembro: </b> $dato[member_number]</p>";
        echo "<p><b>numero de grupo: </b> $dato[group_number]</p>";
        echo "<p><b>Plan: </b> $dato[plan_seguro]</p>";
        echo "<a href='?controller=Paneles&action=segurosInfo&cliente=$cliente&seguro=1'>Editar</a>";
        echo "<hr>";
    }   
    }else{
        require_once 'Vistas/subpaneles/formularioSeguro.php';
    }
        
}