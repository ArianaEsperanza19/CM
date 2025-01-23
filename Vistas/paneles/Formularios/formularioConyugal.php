<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/conyugueDependiente.css\">";
# Centinela que vigila si se ha editado la informacion
if (isset($_SESSION['editar']) && isset($_GET['titular'])) {
    unset($_SESSION['editar']);
    header('Location: ?controller=Paneles&action=info&cliente='.$_GET['titular']);
}
if (isset($_GET['id_cliente'])) {
    # id del titular
    $id = $_GET['id_cliente'];
    echo "<div id='contenedor'>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$id'>Volver</a>";
    # Si tiene dependientes
    if (isset($_GET['depende']) && $_GET['depende'] == 1) {
        $redireccion = "?controller=Cliente&action=Agregar_Conyuge&id_cliente=$id&depende=1";
    }
    # No tiene dependientes
    else {
        $redireccion = "?controller=Cliente&action=Agregar_Conyuge&id_cliente=$id&depende=0";
    }
}
# Editar conyugue
if (isset($conyugue) == 1) {
    # Editar conyugue
    require_once 'Modelos/DatosManager.php';
    $id = $_GET['cliente'];
    $titular = isset($_GET['titular']) ? $_GET['titular'] : false;
    echo "<div id='contenedor'>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$titular'>Volver</a>";
    $DB = new DatosManager(tabla: 'Conyuges_Dependientes');
    $datos = $DB->Conseguir_Registro("WHERE id_miembro_grupo = $id AND relacion = 'Conyuge'");
    foreach ($datos as $dato) {
        $nombre = $dato['nombre'];
        $segundo_nombre = $dato['segundo_nombre'];
        $apellido = $dato['apellido'];
        $ssn = $dato['SSN'];
        $alien_number = $dato['alien_number'];
        $genero = $dato['genero'];
        $fecha_nacimiento = $dato['fecha_nacimiento'];
        $seguro = $dato['en_poliza'];
        $estatus = $dato['estatus_migratorio'];
        $notas = $dato['notas'];
    }
    # id del conyugue a editar
    $redireccion = "?controller=Cliente&action=Editar&cliente=$id&conyugue=1";
    echo "
    <div id='datos'>
    <h2>Formulario del Conyuge</h2>
    <form action='$redireccion' method='POST'>
    <label for='seguro'>¿Solicita la cobertura? </label>
    <select id='seguro' name='seguro'>
    ";
    if ($seguro == 'si') {
        echo "<option value='si' selected>Si</option>";
        echo "<option value='no'>No</option>";
    }
    if ($seguro == 'no') {
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
    <select id='genero' name='genero'>
    ";
    if ($genero == 'F') {
        echo "
        <option value='F' selected>Femenino</option>
        <option value='M'>Masculino</option>
    ";
    } else {
        echo "
        <option value='M' selected>Masculino</option>
        <option value='F'>Femenino</option>
    ";
    }
    echo "
    </select><br>
    <input type='hidden' id='relacion' name='relacion' value='Conyuge'>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input value='$fecha_nacimiento' type='date' id='fecha_nacimiento' name='fecha_nacimiento'> <br>";

    echo "<label for='actualizado'>¿Tiene estatus migratorio? </label>
<select id='estatus' name='estatus'>";
    if ($estatus == "0") {
        echo "<option value='0' selected>No</option>";
        echo "<option value='1'>Sí</option>";
    }
    if ($estatus == "1") {
        echo "<option value='1' selected>Sí</option>";
        echo "<option value='0'>No</option>";
    }
    echo "</select><br>
    <textarea id='notas' name='notas' maxlength='200'>$notas</textarea><br>
    <button type='submit' class='boton'>Enviar</button>
    <button type='submit' class='boton'>Enviar</button>
    </form></div></div>";
} else {

    # Agregar conyugue
    echo "
    <div id='datos'>
    <h2>Formulario del Conyuge</h2>
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
<input type='hidden' id='relacion' name='relacion' value='Conyuge'>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento'> <br>
    <label for='estatus'>¿Tiene estatus migratorio? </label>
    <select id='estatus' name='estatus'>
        <option value='0' selected>No</option>
        <option value='1'>Sí</option>
    </select><br>
    <label for='notas'>Notas:</label><br>
    <textarea id='notas' name='notas' maxlength='200'></textarea><br>
    <button type='submit' class='boton'>Enviar</button>
</form></div></div>
";
}
