<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/conyugueDependiente.css\">";
# Centinela que vigila si se ha editado la informacion
if (isset($_SESSION['editar']) && isset($_GET['titular'])) {
    unset($_SESSION['editar']);
    header('Location: ?controller=Paneles&action=info&cliente='.$_GET['titular']);
}

# Titular de un nuevo dependiente
if (isset($_GET['titular'])) {
    $id = $_GET['titular'];
    echo "<div id='contenedor'>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$id'>Volver</a>";
}
# Id del dependiente para editar
if (isset($_GET['id_cliente'])) {
    # id del titular para registrarle un NUEVO dependiente.
    $id_titular = $_GET['id_cliente'];
    echo "<div id='contenedor'>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$id_titular'>Volver</a>";
    // $redirect = "?controller=Cliente&action=Agregar_Depende&id_cliente=$id_titular";
    $redirect = "?controller=Depende&action=Agregar&titular=$id_titular";
}
if (isset($depende) == 1) {
    # id del dependiente para editar
    $id = $_GET['cliente'];
    require_once "Modelos/Grupo.php";
    $DB = new Grupo();
    $datos = $DB->Conseguir_Miembro("WHERE id_miembro_grupo = $id AND relacion != 'Conyuge'");
    foreach ($datos as $dato) {
        $nombre = $dato['nombre'];
        $segundo_nombre = $dato['segundo_nombre'];
        $apellido = $dato['apellido'];
        $ssn = $dato['SSN'];
        $alien_number = $dato['alien_number'];
        $genero = $dato['genero'];
        $fecha_nacimiento = $dato['fecha_nacimiento'];
        $relacion = $dato['relacion'];
        $seguro = $dato['en_poliza'];
        $estatus = $dato['estatus_migratorio'];
        $notas = $dato['notas'];
    }

    // $redirect = "?controller=Cliente&action=Editar&cliente=$id&depende=1";
    $redirect = "?controller=Depende&action=Editar&miembro=$id";
    echo "<div id='datos'>";
    echo "<h2>Formulario de Dependientes</h2>
    <form action='$redirect' method='POST'>
    <label for='seguro'>¿Solicita la cobertura? </label>
    <select id='seguro' name='seguro'>";
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
    <select id='genero' name='genero'>";
    if ($genero == 'F') {
        echo "<option value='F' selected>Femenino</option>";
        echo "<option value='M'>Masculino</option>";
    }
    if ($genero == 'M') {
        echo "<option value='M' selected>Masculino</option>";
        echo "<option value='F'>Femenino</option>";
    }
    echo "
    </select><br>
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
    echo "</select><br>";
    $opciones = array(
    array('Padre', '<option value="Padre" selected>Padre/Madre</option>', '<option value="Padre">Padre/Madre</option>'),
    array('Hijo', '<option value="Hijo" selected>Hijo/a</option>', '<option value="Hijo">Hijo/a</option>'),
    array('Sobrino', '<option value="Sobrino" selected>Sobrino/a</option>', '<option value="Sobrino">Sobrino/a</option>'),
    array('Hermano', '<option value="Hermano" selected>Hermano/a</option>', '<option value="Hermano">Hermano/a</option>'),
    array('Primo', '<option value="Primo" selected>Primo/a</option>', '<option value="Primo">Primo/a</option>'),
    array('Nieto', '<option value="Nieto" selected>Nieto/a</option>', '<option value="Nieto">Nieto/a</option>'),
    array('Cuñado', '<option value="Cuñado" selected>Cuñado/a</option>', '<option value="Cuñado">Cuñado/a</option>'),
    array('Otros', '<option value="Otros" selected>Otros</option>', '<option value="Otros">Otros</option>')
    );

    echo "<select id='relacion' name='relacion'>";
    foreach ($opciones as $op) {
        if ($op[0] == $relacion) {
            echo $op[1];
        } else {
            echo $op[2];
        }
    }
    echo "</select><br>";
    echo "<label for='notas'>Notas:</label><br>
    <textarea id='notas' name='notas' maxlength='200'>$notas</textarea><br>";

    echo "    <button class='boton' type='submit'>Enviar</button>
    </form>
    </div>
    </div>
";
} else {
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
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label> <br>
    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento'><br>
    <label for='estatus'>¿Tiene estatus migratorio? </label>
    <select id='estatus' name='estatus'>
        <option value='0' selected>No</option>
        <option value='1'>Sí</option>
    </select><br>
<select id='relacion' name='relacion'>
        <option value='Progenitor' selected>Padre/Madre</option>
        <option value='Hijo'>Hijo/a</option>
        <option value='Sobrino'>Sobrino/a</option>
        <option value='Hermano'>Hermano/a</option>
        <option value='Primo'>Primo/a</option>
        <option value='Nieto'>Nieto/a</option>
        <option value='Cuñado'>Cuñado/a</option>
        <option value='Otros'>Otros</option>
</select><br>
    <label for='notas'>Notas:</label><br>
    <textarea id='notas' name='notas' maxlength='200'></textarea><br>
    <button class='boton' type='submit'>Enviar</button>
    <a class='boton' href='?controller=Paneles&action=info&cliente=$id_titular'>Listo</a>
    </form>
    </div>
    </div>";
}
