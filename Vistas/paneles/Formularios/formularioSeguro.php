<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/formularioBancoSeguro.css\">";
echo "<div id='contenedorSeguro' class='contenedor'><a class='boton' id='volverSeguro' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
// Si se acaba de editar algo, redirecciona
if (isset($_SESSION['editarSeguro'])) {
    unset($_SESSION['editarSeguro']);
    header('Location: ?controller=Paneles&action=InfoSeguros&cliente='.$cliente);
}

if (isset($_SESSION['seguro_centinela']) && $_SESSION['seguro_centinela'] == 1) {
    // Donde se puede editar seguro
    unset($_SESSION['seguro_centinela']);
    $id_titular = $_GET['cliente'];
    $redirect = "?controller=Cliente&action=registrar_editar_seguro&cliente=$id_titular&editar=1";
    require_once 'Modelos/Seguros.php';
    $DB = new Seguros();
    $sentencia = $DB->obtener("WHERE id_cliente = $id_titular");
    foreach ($sentencia as $dato) {
        $policy_number = $dato['policy_number'];
        $member_number = $dato['member_number'];
        $group_number = $dato['group_number'];
        $plan_seguro = $dato['plan_seguro'];
    }
    echo "
    <div class='datos'>
    <h1>Editar informacion del Seguro</h1>
    <form action='$redirect' method='POST'>
    <label for='policy_number'>Número de póliza:</label><br>
    <input value='$policy_number' type='text' id='policy_number' name='policy_number'><br>

    <label for='member_number'>Número de miembro:</label><br>
    <input value='$member_number' type='text' id='member_number' name='member_number'><br>

    <label for='group_number'>Número de grupo:</label><br>
    <input value='$group_number' type='text' id='group_number' name='group_number'><br>
    <label for='plan_seguro'>Plan de seguro:</label><br>
    <input value='$plan_seguro' type='text' id='plan_seguro' name='plan_seguro'><br>

    <input style='margin-top: 10px;' type='submit' value='Guardar'>
    </form></div>
    ";
} else {
    // Agregar seguro
    $redirect = '?controller=Cliente&action=registrar_editar_seguro&cliente='.$_GET['cliente'].'&editar=0';
    echo "
    <div class='datos'>
    <h1>Informacion de Seguro </h1>
    <form action='$redirect' method='POST'>
    <label for='policy_number'>Número de póliza:</label><br>
    <input type='text' id='policy_number' name='policy_number'><br>

    <label for='member_number'>Número de miembro:</label><br>
    <input type='text' id='member_number' name='member_number'><br>

    <label for='group_number'>Número de grupo:</label><br>
    <input type='text' id='group_number' name='group_number'><br>
    <label for='plan_seguro'>Plan de seguro:</label><br>
    <input type='text' id='plan_seguro' name='plan_seguro'><br>

    <input style='margin-top: 10px;' type='submit' value='Guardar'>
    </form></div></div>
    ";
}
