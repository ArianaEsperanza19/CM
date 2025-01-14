<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/conyugueDependiente.css\">";
    # Centinela que vigila si se ha editado la informacion
    if(isset($_SESSION['editar']) && isset($_GET['titular'])){
    unset($_SESSION['editar']);
    header('Location: ?controller=Paneles&action=info&cliente='.$_GET['titular']);
    }

    # Titular de un nuevo dependiente
    if(isset($_GET['titular'])){
    $id = $_GET['titular'];
    echo "<div id='contenedor'>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$id'>Volver</a>";
    }
    # Id del dependiente para editar
    if(isset($_GET['id_cliente'])){
    # id del titular para registrarle un NUEVO dependiente.
    $id_titular = $_GET['id_cliente'];
    echo "<div id='contenedor'>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$id_titular'>Volver</a>";
    $redirect = "?controller=Cliente&action=Agregar_Depende&id_cliente=$id_titular";
    }
if(isset($depende) == 1){
    # id del dependiente para editar
    $id = $_GET['cliente'];
    $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
    $datos = $DB->Conseguir_Registro("WHERE id_miembro_grupo = $id AND pareja = 0");
    foreach ($datos as $dato) {
        $nombre = $dato['nombre'];
        $segundo_nombre = $dato['segundo_nombre'];
        $apellido = $dato['apellido'];
        $ssn = $dato['SSN'];
        $alien_number = $dato['alien_number'];
        $genero = $dato['genero'];
        $fecha_nacimiento = $dato['fecha_nacimiento'];
        $seguro = $dato['en_poliza'];
    }

    $redirect = "?controller=Cliente&action=Editar&cliente=$id&depende=1";
    echo "<div id='datos'>";
    echo "<h2>Formulario de Dependientes</h2>
    <form action='$redirect' method='POST'>
    <label for='seguro'>¿Solicita la cobertura? </label>
    <select id='seguro' name='seguro'>";
        if($seguro == 'si'){
         echo "<option value='si' selected>Si</option>";
        echo "<option value='no'>No</option>";
        }
        if($seguro == 'no'){
        echo "<option value='no' selected>No</option>";
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
    <select id='genero' name='genero'>";
        if($genero == 'F'){
            echo "<option value='F' selected>Femenino</option>";
            echo "<option value='M'>Masculino</option>";
        }
        if($genero == 'M'){
            echo "<option value='M' selected>Masculino</option>";
            echo "<option value='F'>Femenino</option>";
        }
    echo "
    </select><br>
    <select id='pareja' name='pareja' hidden>
        <option value='0' selected>No</option>
        <option value='1'>Si</option>
    </select><br>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input value='$fecha_nacimiento' type='date' id='fecha_nacimiento' name='fecha_nacimiento'> <br>
    <button class='boton' type='submit'>Enviar</button>
    </form>
    </div>
    </div>
";
}else{
    # Formulario para registrar un dependiente
    echo"
    <div id='datos'>
    <h2>Formulario de Dependientes</h2>
    <form action='$redirect' method='POST'>
    <label for='seguro'>¿Solicita la cobertura? </label>
    <select id='seguro' name='seguro'>
        <option value='si' selected>Si</option>
        <option value='no'>No</option>
    </select><br>
    <label for='nombre'>Nombre:</label><br>
    <input type='text' id='nombre' name='nombre' maxlength='50'><br>
    <label for='segundo_nombre'>Segundo Nombre:</label><br>
    <input type='text' id='segundo_nombre' name='segundo_nombre' maxlength='50'><br>
    <label for='apellidos'>Apellidos:</label> <br>
    <input type='text' id='apellidos' name='apellidos' maxlength='50' required> <br>
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
        <option value='0' selected>No</option>
        <option value='1'>Si</option>
    </select><br>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento'><br>
    <button class='boton' type='submit'>Enviar</button>
    <a href='?controller=Paneles&action=index'>Listo</a>
    </form>
    </div>
    </div>";
}
?>
