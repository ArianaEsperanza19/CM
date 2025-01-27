<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/formularioTitular.css\">";

if (isset($editar_titular)) {
    $id = $editar_titular;
    echo "<div id='contenedor'><a href='?controller=Paneles&action=info&cliente=$id'>Cancelar</a>";
    if (isset($_SESSION['editar'])) {
        unset($_SESSION['editar']);
        header('Location: ?controller=Paneles&action=info&cliente='.$id);
    }
    require_once 'Modelos/Titulares.php';
    $DB = new Titulares();
    $datos = $DB->Conseguir_Registro("WHERE id_cliente = $id");
    foreach ($datos as $dato) {
        $nombre = $dato["nombre"];
        $segundo_nombre = $dato["segundo_nombre"];
        $primer_apellido = $dato["primer_apellido"];
        $segundo_apellido = $dato["segundo_apellido"];
        $ssn = $dato["SSN"];
        $alien = $dato["alien_number"];
        $genero = $dato["genero"];
        $fecha_nacimiento = $dato['fecha_nacimiento'];
        $direccion = $dato["direccion"];
        $ciudad = $dato["ciudad"];
        $estado = $dato["estado"];
        $zip = $dato["codigo_postal"];
        $telefono = $dato["telefono"];
        $email = $dato["email"];
        $empresa = $dato["empresa"];
        $actualizado = $dato["actualizado"];
        $notas = $dato["notas"];
        $estatus = $dato["estatus_migratorio"];
        $fiscal = $dato["declaracion_fiscal"];
        $seguro = $dato["en_poliza"];
    }
    $redirect = "?controller=Cliente&action=Editar&cliente=$id";
    echo "
    <div id='datos'>
    <h2>Formulario de Registro de Titulares</h2>
    <form action='$redirect' method='POST'>
    <label for='seguro'>¿El titular está en la poliza?</label>
    <select id='seguro' name='seguro'>";

    if ($seguro == 'si') {
        echo "<option value='si' selected>Si</option>";
        echo "<option value='no'>No</option>";
    }
    if ($seguro == 'no') {
        echo "<option value='no' selected>No</option>";
        echo "<option value='no'>No</option>";

    }


    echo"</select><br><label for='nombre'>Nombre:</label><br>
    <input value='$nombre' type='text' id='nombre' name='nombre' maxlength='50' required><br>
    <label for='segundo_nombre'>Segundo Nombre:</label><br>
    <input value='$segundo_nombre' type='text' id='segundo_nombre' name='segundo_nombre' maxlength='50'><br>
    <label for='primer_apellido'>Primer Apellido:</label><br>
    <input value='$primer_apellido' type='text' id='primer_apellido' name='primer_apellido' maxlength='50' required><br>
    <label for='segundo_apellido'>Segundo Apellido:</label><br>
    <input value='$segundo_apellido' type='text' id='segundo_apellido' name='segundo_apellido' maxlength='50'><br>
    <label for='ssn'>SSN:</label><br>
    <input value='$ssn' type='text' id='ssn' name='ssn' maxlength='20'><br>
    <label for='alien_number'>Alien Number:</label><br>
    <input value='$alien' type='text' id='alien_number' name='alien_number' maxlength='20'><br>
    <label for='genero'>Genero </label>
    <select id='genero' name='genero'>
    ";
    if ($genero == "F") {
        echo "<option value='F' selected>Femenino</option>";
        echo "<option value='M'>Masculino</option>";
    }
    if ($genero == "M") {
        echo "<option value='M' selected>Masculino</option>";
        echo "<option value='F'>Femenino</option>";
    }

    echo "</select><br>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label><br>
    <input value='$fecha_nacimiento' type='date' id='fecha_nacimiento' name='fecha_nacimiento'><br>
    <label for='direccion'>Dirección:</label><br>
    <input value='$direccion' type='text' id='direccion' name='direccion' maxlength='100'><br>
    <label for='ciudad'>Ciudad:</label><br>
    <input value='$ciudad' type='text' id='ciudad' name='ciudad' maxlength='50' required><br>
    <label for='estado'>Estado:</label><br>
    <input value='$estado' type='text' id='estado' name='estado' maxlength='50' required><br>
    <label for='codigo_postal'>Código Postal:</label><br>
    <input value='$zip' type='number' id='codigo_postal' name='codigo_postal' maxlength='10'><br>
    <label for='telefono'>Teléfono:</label><br>
    <input value='$telefono' type='text' id='telefono' name='telefono' maxlength='20'><br>
    <label for='email'>Email:</label><br>
    <input value='$email' type='email' id='email' name='email' maxlength='50'><br>
    <label for='empresa'>Empresa:</label><br>";
    $opciones = array(
    array("Ambetter", "<option value='Ambetter' selected>Ambetter</option>", "<option value='Ambetter'>Ambetter</option>"),
    array("Oscar", "<option value='Oscar' selected>Oscar</option>", "<option value='Oscar'>Oscar</option>"),
    array("Aetna", "<option value='Aetna' selected>Aetna</option>", "<option value='Aetna'>Aetna</option>"),
    );
    echo "<select id='empresa' name='empresa'>";
    foreach ($opciones as $opcion) {
        if ($empresa == $opcion[0]) {
            echo $opcion[1];
        }
        if ($empresa != $opcion[0]) {
            echo $opcion[2];
        }
    }
    echo "</select><br>";
    echo "<label for='notas'>Notas:</label><br>
    <textarea value='$notas' id='notas' name='notas' maxlength='200'></textarea><br>
<label for='fiscal'>¿Hizo una declaración fiscal? </label>
<select id='fiscal' name='fiscal'>";
    if ($fiscal == "0") {
        echo "<option value='0' selected>No</option>";
        echo "<option value='1'>Sí</option>";
    }
    if ($fiscal == "1") {
        echo "<option value='1' selected>Sí</option>";
        echo "<option value='0'>No</option>";
    }
    echo "</select><br>
<label for='actualizado'>¿Tiene estatus migratorio? </label>
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
<label for='actualizado'>¿La información está actualizada? </label>
<select id='actualizado' name='actualizado'>";
    if ($actualizado == "0") {
        echo "<option value='0' selected>No</option>";
        echo "<option value='1'>Sí</option>";
    }
    if ($actualizado == "1") {
        echo "<option value='1' selected>Sí</option>";
        echo "<option value='0'>No</option>";
    }
    echo "</select><br>
    <button class='boton' type='submit'>Enviar</button>
</form>
</div>";
} else {
    echo "<div id='contenedor'><a href='?controller=Paneles&action=index'>Cancelar</a>";
    echo "
    <div id='datos'>
    <h2>Formulario de Registro de Titulares</h2>
    <form action='?controller=Cliente&action=Crear' method='POST'>
    <label for='seguro'>¿El titular está en la poliza? </label>
    <select id='seguro' name='seguro'>
    <option value='si' selected>Si</option>
    <option value='no'>No</option>
    </select><br><label for='nombre'>Nombre:</label><br>
    <input type='text' id='nombre' name='nombre' maxlength='50' required><br>
    <label for='segundo_nombre'>Segundo Nombre:</label><br>
    <input type='text' id='segundo_nombre' name='segundo_nombre' maxlength='50'><br>
    <label for='primer_apellido'>Primer Apellido:</label><br>
    <input type='text' id='primer_apellido' name='primer_apellido' maxlength='50'><br>
    <label for='segundo_apellido'>Segundo Apellido:</label><br>
    <input type='text' id='segundo_apellido' name='segundo_apellido' maxlength='50'><br>
    <label for='ssn'>SSN:</label><br>
    <input type='text' id='ssn' name='ssn' maxlength='20'><br>
    <label for='alien_number'>Alien Number:</label><br>
    <input type='text' id='alien_number' name='alien_number' maxlength='20'><br>
    <label for='genero'>Genero </label>
    <select id='genero' name='genero'>
        <option value='F' selected>Femenino</option>
        <option value='M'>Masculino</option>
    </select><br>
    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label><br>
    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento' required><br>
    <label for='direccion'>Dirección:</label><br>
    <input type='text' id='direccion' name='direccion' maxlength='100'><br>
    <label for='ciudad'>Ciudad:</label><br>
    <input type='text' id='ciudad' name='ciudad' maxlength='50' required><br>
    <label for='estado'>Estado:</label><br>
    <input type='text' id='estado' name='estado' maxlength='50' required><br>
    <label for='codigo_postal'>Código Postal:</label><br>
    <input type='number' id='codigo_postal' name='codigo_postal' maxlength='10'><br>
    <label for='telefono'>Teléfono:</label><br>
    <input type='text' id='telefono' name='telefono' maxlength='20'><br>
    <label for='email'>Email:</label><br>
    <input type='email' id='email' name='email' maxlength='50'><br>
    <label for='empresa'>Empresa:</label><br>
<select id='empresa' name='empresa'>
    <option value='Ambetter'>Ambetter</option>
    <option value='Oscar'>Oscar</option>
    <option value='Aetna'>Aetna</option>
</select><br>
    <label for='notas'>Notas:</label><br>
    <textarea id='notas' name='notas' maxlength='200'></textarea><br>
    <label for='fiscal'>¿Hizo una declaración fiscal? </label>
    <select id='fiscal' name='fiscal'>
        <option value='0' selected>No</option>
        <option value='1'>Sí</option>
    </select><br>
    <label for='estatus'>¿Tiene estatus migratorio? </label>
    <select id='estatus' name='estatus'>
        <option value='0' selected>No</option>
        <option value='1'>Sí</option>
    </select><br>
    <label for='actualizado'>¿La información está actualizada? </label>
    <select id='actualizado' name='actualizado'>
    <option value='0' selected>No</option>
    <option value='1'>Sí</option>
    </select><br>
    <label for='conyugue'>¿Está casad@? </label>
    <select id='conyugue' name='matrimonio'>
        <option value='0' selected>No</option>
        <option value='1'>Sí</option>
    </select><br>
    <label for='dependientes'>¿Dependientes?</label>
    <select id='dependientes' name='dependientes'>
        <option value='0' selected>No</option>
        <option value='1'>Sí</option>
    </select><br>
    <button class='boton' type='submit'>Enviar</button>
</form>
</div>
</div>";
}
