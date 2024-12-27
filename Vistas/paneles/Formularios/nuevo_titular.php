<?php
if(isset($editar_titular)){
    $id = $editar_titular;
    $DB = new DatosManager(tabla: 'Titulares');
    $datos = $DB->Conseguir_Registro("WHERE id_cliente = $id;");
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
        echo $genero;
    }
    $redirect = "?controller=Cliente&action=Editar&cliente=$id";
    echo "
    <h2>Formulario de Registro de Titulares</h2>
    <form action='$redirect' method='POST'>
    <label for='nombre'>Nombre:</label><br>
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
    if($genero == "F"){ 
    echo "<option value='F' selected>Femenino</option>";
    echo "<option value='M'>Masculino</option>";}
    if($genero == "M"){ 
    echo "<option value='M' selected>Masculino</option>";
    echo "<option value='F'>Femenino</option>";}
       
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
    <input value='$zip' type='text' id='codigo_postal' name='codigo_postal' maxlength='10'><br>
    <label for='telefono'>Teléfono:</label><br>
    <input value='$telefono' type='text' id='telefono' name='telefono' maxlength='20'><br>
    <label for='email'>Email:</label><br>
    <input value='$email' type='email' id='email' name='email' maxlength='50'><br>
    <label for='empresa'>Empresa:</label><br>
    <input value='$empresa' type='text' id='empresa' name='empresa' maxlength='50'><br>
    <label for='notas'>Notas:</label><br>
    <textarea value='$notas' id='notas' name='notas' maxlength='200'></textarea><br>
    <label for='actualizado'>¿La información está actualizada? </label>
    <select id='actualizado' name='actualizado'>";
    if($actualizado == "0"){ echo "<option value='0' selected>No</option>";}
    if($actualizado == "1"){ echo "<option value='1'>Sí</option>";}
    echo "</select><br>
    <button type='submit'>Enviar</button>
</form>
    ";
}else{
    echo "
    <h2>Formulario de Registro de Titulares</h2>
    <form action='?controller=Cliente&action=Crear' method='POST'>
    <label for='nombre'>Nombre:</label><br>
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
    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento'><br>
    <label for='direccion'>Dirección:</label><br>
    <input type='text' id='direccion' name='direccion' maxlength='100'><br>
    <label for='ciudad'>Ciudad:</label><br>
    <input type='text' id='ciudad' name='ciudad' maxlength='50' required><br>
    <label for='estado'>Estado:</label><br>
    <input type='text' id='estado' name='estado' maxlength='50' required><br>
    <label for='codigo_postal'>Código Postal:</label><br>
    <input type='text' id='codigo_postal' name='codigo_postal' maxlength='10'><br>
    <label for='telefono'>Teléfono:</label><br>
    <input type='text' id='telefono' name='telefono' maxlength='20'><br>
    <label for='email'>Email:</label><br>
    <input type='email' id='email' name='email' maxlength='50'><br>
    <label for='empresa'>Empresa:</label><br>
    <input type='text' id='empresa' name='empresa' maxlength='50'><br>
    <label for='notas'>Notas:</label><br>
    <textarea id='notas' name='notas' maxlength='200'></textarea><br>
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
    <button type='submit'>Enviar</button>
</form>
    
    ";
}
?>