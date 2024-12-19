<?php

    $cliente = $_GET['cliente'];
    $DB = new DatosManager(tabla: 'Titulares');
    $titular = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
    $_SESSION['eliminar'] = true;
    echo "<h1>Informacion del Titular</h1>
    <a href='?controller=Paneles&action=advertencia&cliente=$cliente'>Eliminar poliza</a>
    <a href='?controller=Paneles&action=segurosInfo&cliente=$cliente'>Informacion de Seguros</a>
    <a href='?controller=Paneles&action=bancoInfo&cliente=$cliente'>Informacion Bancaria</a>
    <hr>";
    foreach ($titular as $dato) {
    $id = $dato['id_cliente'];
    echo "<a href='?controller=Paneles&action=editar&cliente_titular=$id'>Editar</a>";
    echo "<p><b>Nombre:</b> $dato[nombre]</p>";
    echo "<p><b>Segundo nombre:</b> $dato[segundo_nombre]</p>";
    echo "<p><b>Apellido:</b> $dato[primer_apellido]</p>";
    echo "<p><b>Segundo apellido:</b> $dato[segundo_apellido]</p>";
    echo "<p><b>SSN:</b> $dato[SSN]</p>";
    echo "<p><b>Alien Number:</b> $dato[alien_number]</p>";
    echo "<p><b>Genero:</b> $dato[genero]</p>";
    echo "<p><b>Fecha de Nacimiento:</b> $dato[fecha_nacimiento]</p>";
    echo "<p><b>Telefono:</b> $dato[telefono]</p>";
    echo "<p><b>Correo Electronico:</b> $dato[email]</p>";
    echo "<p><b>Direccion:</b> $dato[direccion]</p>";
    echo "<p><b>Ciudad:</b> $dato[ciudad]</p>";
    echo "<p><b>Estado:</b> $dato[estado]</p>";
    echo "<p><b>Codigo Postal:</b> $dato[codigo_postal]</p>";
    echo "<p><b>Empresa:</b> $dato[empresa]</p>";
    echo "<p><b>Notas:</b> $dato[notas]</p>";
    echo "<hr>";
    if($dato['actualizado'] == 1){
        echo "<p><b>Actualizado:</b> Si</p>";
    }else{
        echo "<p><b>Actualizado:</b> No</p>";
    }
    if($dato['estatus_migratorio'] == 1){
        echo "<p><b>Documentos de estatus migratorio</b> Si</p>";
    }else{
        echo "<p><b>Documentos de estatus migratorio</b> No</p>";
    }
    if($dato['declaracion_fiscal'] == 1){
        echo "<p><b>Declaracion Fiscal: </b> Si</p>";
    }else{
        echo "<p><b>Declaracion Fiscal: </b> No</p>";
    }
    echo "<hr>";
    }

    # Conyugue
    $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
    $conyugue = $DB->Conseguir_Registro("WHERE id_cliente = $cliente AND pareja = 1");
    echo "<h1>Informacion del Conyugue</h1>";
    if ($conyugue->rowCount() > 0) {
    // La consulta ha encontrado algo
    foreach ($conyugue as $dato) {
    $id=$dato['id_miembro_grupo'];
    echo "<a href='?controller=Paneles&action=editar&cliente=$id&conyugue=1'>Editar</a>";
    echo "<p><b>Nombre:</b> $dato[nombre]</p>";
    echo "<p><b>Segundo nombre:</b> $dato[segundo_nombre]</p>";
    echo "<p><b>Apellido:</b> $dato[apellido]</p>";
    echo "<p><b>Genero:</b> $dato[genero]</p>";
    echo "<p><b>Fecha de Nacimiento:</b> $dato[fecha_nacimiento]</p>";
    echo "<p><b>Alien Number:</b> $dato[alien_number]</p>";
    echo "<p><b>SSN:</b> $dato[SSN]</p>";
    echo "<p><b>Cobertura:</b> $dato[en_poliza]</p>";
    echo "<a href='?controller=Cliente&action=Eliminar&cliente=$id&conyugue=1&titular=$cliente'>Eliminar</a><br>";
    echo "<hr>";
    }
} else {
    // La consulta no ha encontrado nada
    echo "<a href='?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente'>Agregar +</a>";
}


    # Dependientes
    $dependientes = $DB->Conseguir_Registro("WHERE id_cliente = $cliente AND pareja = 0");
    echo "<hr>";
    echo "<h1>Informacion de Dependientes</h1>";
    foreach ($dependientes as $dato) {
    $id=$dato['id_miembro_grupo'];
    echo "<a href='?controller=Paneles&action=editar&cliente=$id&depende=1'>Editar</a>";
    echo "<p><b>Nombre:</b> $dato[nombre]</p>";
    echo "<p><b>Segundo nombre:</b> $dato[segundo_nombre]</p>";
    echo "<p><b>Apellido:</b> $dato[apellido]</p>";
    echo "<p><b>Genero:</b> $dato[genero]</p>";
    echo "<p><b>Fecha de Nacimiento:</b> $dato[fecha_nacimiento]</p>";
    echo "<p><b>Alien Number:</b> $dato[alien_number]</p>";
    echo "<p><b>SSN:</b> $dato[SSN]</p>";
    echo "<p><b>Cobertura:</b> $dato[en_poliza]</p>";
    echo "<a href='?controller=Cliente&action=Eliminar&cliente=$id&depende=1&titular=$cliente'>Eliminar</a><br>";
    echo "<hr>";
}
    echo "<a href='?controller=Paneles&action=formularioDepende"."&id_cliente=$cliente&depende=0'>Agregar +</a>";
?>
