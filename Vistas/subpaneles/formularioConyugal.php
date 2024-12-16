<?php
echo "Soy el formulario para conyugues";
if($_GET['id_cliente']){
    # id del titular
    $id = $_GET['id_cliente'];
    # Si tiene dependientes
    if($_GET['depende'] == 1){
    $redireccion = "?controller=Cliente&action=Agregar_Conyugue&id_cliente=$id&depende=1";
    }
    # No tiene dependientes
    else{
    $redireccion = "?controller=Cliente&action=Agregar_Conyugue&id_cliente=$id&depende=0";
    }
}
# Editar conyugue
if(isset($conyugue) == 1){
    require_once 'Herramientas/DatosManager.php';
    $id = $_GET['cliente'];
    $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
    $datos = $DB->Conseguir_Registro("WHERE id_miembro_grupo = $id AND pareja = 1");
    foreach ($datos as $dato) {
        var_dump($dato);
        $nombre = $dato['nombre'];
        $segundo_nombre = $dato['segundo_nombre'];
        $apellido = $dato['apellido'];
        $ssn = $dato['SSN'];
        $alien_number = $dato['alien_number'];
        $genero = $dato['genero'];
        $fecha_nacimiento = $dato['fecha_nacimiento'];
        $seguro = $dato['en_poliza'];
    }
    # id del conyugue a editar
    $redireccion = "?controller=Cliente&action=Editar&cliente=$id&conyugue=1";
    echo "
    <h2>Formulario de Registro</h2>
    <form action='$redireccion' method='POST'>
    <label for='seguro'>¿Solicita la cobertura? </label>
    <select id='seguro' name='seguro'>
    ";
    if($seguro == 'si'){
        echo "<option value='si'>Si</option>";
    }
    if($seguro == 'no'){
        echo "<option value='no'>No</option>";
    }
    echo "
    </select><br>
    <label for='nombre'>Nombre:</label><br>
    <input value='$nombre' type='text' id='nombre' name='nombre' maxlength='50' required><br>
    <label for='segundo_nombre'>Segundo Nombre:</label><br>
    <input value='$segundo_nombre' type='text' id='segundo_nombre' name='segundo_nombre' maxlength='50'><br>
    <label for='apellidos'>Apellidos:</label> <br>
    <input value='$apellido' type='text' id='apellidos' name='apellidos' maxlength='50'> <br>
    <label for='ssn'>SSN:</label> <br>
    <input value='$ssn' type='text' id='ssn' name='ssn' maxlength='20'> <br>
    <label for='alien_number'>Alien Number:</label> <br>
    <input value='$alien_number' type='text' id='alien_number' name='alien_number' maxlength='20'> <br>
    <label for='genero'>Genero </label>
    <select id='genero' name='genero'>
    ";
    if($genero == 'F'){
    echo "
        <option value='F' selected>Femenino</option>
    ";}else{
    echo "
        <option value='M'>Masculino</option>
    ";
    }
    echo "
    </select><br>
    <select id='pareja' name='pareja' hidden>
        <option value='0'>No</option>
        <option value='1' selected>Si</option>
    </select><br>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input value='$fecha_nacimiento' type='date' id='fecha_nacimiento' name='fecha_nacimiento'> <br>
    <button type='submit'>Enviar</button>
</form>
";
}else{
    echo "
    <h2>Formulario de Registro</h2>
    <form action='$redireccion' method='POST'>
    <label for='seguro'>¿Solicita la cobertura? </label>
    <select id='seguro' name='seguro'>
        <option value='si'>Si</option>
        <option value='no'>No</option>
    </select><br>
    <label for='nombre'>Nombre:</label><br>
    <input type='text' id='nombre' name='nombre' maxlength='50' required><br>
    <label for='segundo_nombre'>Segundo Nombre:</label><br>
    <input type='text' id='segundo_nombre' name='segundo_nombre' maxlength='50'><br>
    <label for='apellidos'>Apellidos:</label> <br>
    <input type='text' id='apellidos' name='apellidos' maxlength='50'> <br>
    <label for='ssn'>SSN:</label> <br>
    <input type='text' id='ssn' name='ssn' maxlength='20'> <br>
    <label for='alien_number'>Alien Number:</label> <br>
    <input type='text' id='alien_number' name='alien_number' maxlength='20'> <br>
    <label for='genero'>Genero </label>
    <select id='genero' name='genero'>
        <option value='F' selected>Femenino</option>
        <option value='M'>Masculino</option>
    </select><br>
    <select id='pareja' name='pareja' hidden>
        <option value='0'>No</option>
        <option value='1' selected>Si</option>
    </select><br>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento'> <br>
    <button type='submit'>Enviar</button>
</form>
";
}

?>