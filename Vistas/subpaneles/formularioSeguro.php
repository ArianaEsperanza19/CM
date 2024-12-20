
<?php
if(isset($_SESSION['seguro']) == 1){
    # Donde se puede editar seguro
    unset($_SESSION['seguro']);
    $id_titular = isset($_GET['cliente']);
    $redirect = "?controller=Cliente&action=registrar_info_seguro&cliente=$id_titular&editar=1";
    $DB = new DatosManager(tabla: 'Datos_Seguro');
    $sentencia = $DB->Conseguir_Registro("WHERE id_cliente = $id_titular");
    foreach ($sentencia as $dato) {
        $policy_number = $dato['policy_number'];
        $member_number = $dato['member_number'];
        $group_number = $dato['group_number'];
        //$plan_seguro = $dato['plan_seguro'];   
    }
    echo "
    <h1>Editar informacion de Seguro</h1>
    <form action='$redirect' method='POST'>
    <label for='policy_number'>Número de póliza:</label><br>
    <input value='$policy_number' type='text' id='policy_number' name='policy_number'><br>
    
    <label for='member_number'>Número de miembro:</label><br>
    <input value='$member_number' type='text' id='member_number' name='member_number'><br>
    
    <label for='group_number'>Número de grupo:</label><br>
    <input value='$group_number' type='text' id='group_number' name='group_number'><br>
    
    <input type='submit' value='Guardar'>
    </form>
    ";
}else{
    # Agregar seguro
    $redirect='?controller=Cliente&action=registrar_info_seguro&cliente='.$_GET['cliente'].'&editar=0';   
    echo "
    <h1>Informacion de Seguro</h1>
    <form action='$redirect' method='POST'>
    <label for='policy_number'>Número de póliza:</label><br>
    <input type='text' id='policy_number' name='policy_number'><br>
    
    <label for='member_number'>Número de miembro:</label><br>
    <input type='text' id='member_number' name='member_number'><br>
    
    <label for='group_number'>Número de grupo:</label><br>
    <input type='text' id='group_number' name='group_number'><br>
    
    
    <input type='submit' value='Guardar'>
    </form>
    ";
    /*
    <label for='plan_seguro'>Plan de seguro:</label><br>
    <input type='text' id='plan_seguro' name='plan_seguro'><br>
    */
}