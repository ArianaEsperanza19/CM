<?php
echo "<h1>Informacion Bancaria</h1>";
if(isset($_GET['cliente'])){
    $cliente = $_GET['cliente'];
    $DB = new DatosManager(tabla: 'Cuentas');
    $cuentas= $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
    if($cuentas->rowCount() > 0){
    foreach ($cuentas as $dato) {
        echo "<p><b>Numero de cuenta: </b> $dato[numero_cuenta]</p>";
        echo "<p><b>Tipo de cuenta: </b> $dato[tipo_cuenta]</p>";
        echo "<a href='?controller=Paneles&action=bancoInfo&cliente=$cliente&banco=1'>Editar</a>";
    }
    }else{
        require_once 'Vistas/subpaneles/formularioBanco.php';
    }
}