<?php
if(isset($_SESSION['banco']) == 1){
    # Editar cuentas de banco
    unset($_SESSION['banco']);
    require_once 'Herramientas/DatosManager.php';
    $id_titular = isset($_GET['cliente']);
    $redireccion = "?controller=Cliente&action=registrar_info_banco&cliente=$id_titular";
    $DB = new DatosManager(tabla: 'Cuentas');
    $sentecia = $DB->Conseguir_Registro("WHERE id_cliente = $id_titular");
    foreach ($sentecia as $dato) {
        $numero_cliente = $dato['numero_cuenta'];
        $tipo_cuenta = $dato['tipo_cuenta'];
    }
    echo " 
    <h1>Informacion Bancaria</h1>
    <form action='$redireccion' method='POST'>
    <label for='numero_cuenta'>Número de cuenta:</label><br>
    <input value='$numero_cliente' type='text' id='numero_cuenta' name='numero_cuenta'><br><br>
    <label for='tipo_cuenta'>Tipo de cuenta:</label><br>
    <input value='$tipo_cuenta' type='text' id='tipo_cuenta' name='tipo_cuenta'><br><br>
    <input type='submit' value='Enviar'>
</form>"; 
}else{
    # Agregar cuentas de banco
    echo "
    <form action='$redireccion' method='POST'>
    <label for='numero_cuenta'>Número de cuenta:</label><br>
    <input type='text' id='numero_cuenta' name='numero_cuenta'><br><br>
    <label for='tipo_cuenta'>Tipo de cuenta:</label><br>
    <input type='text' id='tipo_cuenta' name='tipo_cuenta'><br><br>
    <input type='submit' value='Enviar'>
</form>"; 
}