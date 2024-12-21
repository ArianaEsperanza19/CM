<?php
ob_clean(); 
# Si se acaba de editar algo, redirecciona
if(isset($_SESSION['editar'])){
    unset($_SESSION['editar']);
    header('Location: ?controller=Paneles&action=InfoBanco&cliente='.$cliente);
}
$cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
echo "<a href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
if(isset($_SESSION['banco']) == 1){
    # Editar cuentas de banco
    unset($_SESSION['banco']);
    require_once 'Modelos/DatosManager.php';
    $redireccion = "?controller=Cliente&action=registrar_editar_banco&cliente=$cliente&editar=1";
    $DB = new DatosManager(tabla: 'Cuentas');
    $sentecia = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
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
    $redireccion = "?controller=Cliente&action=registrar_editar_banco&cliente=$cliente&editar=0";
    echo "
    <h1>Ingresa tu Informacion Bancaria</h1>
    <form action='$redireccion' method='POST'>
    <label for='numero_cuenta'>Número de cuenta:</label><br>
    <input type='text' id='numero_cuenta' name='numero_cuenta'><br><br>
    <label for='tipo_cuenta'>Tipo de cuenta:</label><br>
    <input type='text' id='tipo_cuenta' name='tipo_cuenta'><br><br>
    <input type='submit' value='Enviar'>
</form>"; 
}