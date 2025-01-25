<?php

ob_clean();
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/info.css\">";

$cliente = $_GET['cliente'];
if (isset($_GET['token'])) {
    $_SESSION['editar'] = true;
}
require_once "Modelos/Titulares.php";
$DB = new Titulares();
$titular = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
echo "  <a class='boton' style='margin-left:0' href='?controller=Paneles&action=index'>Inicio</a>
            <a class='boton' style='margin-left:0' href='?controller=DB&action=exportarGrupoCSV&id=$cliente'>Exportar</a>
            <h1>Informacion Poliza</h1>";
foreach ($titular as $dato) {
    $id = $dato['id_cliente'];
    echo "<div class='barra'>";
    echo "<a class='boton' style='margin-left:0px;' href='?controller=Paneles&action=editar&cliente_titular=$id'>Editar Titular #$cliente</a>";
    echo "<a class='boton' href='?controller=Paneles&action=InfoSeguros&cliente=$cliente'>Informacion de Seguros</a>
    <a class='boton' href='?controller=Paneles&action=InfoBanco&cliente=$cliente'>Informacion Bancaria</a>
    <a class='boton' href='?controller=Paneles&action=formularioRegistro&cliente=$cliente'>Registro</a>
    <a class='boton' style='background-color:red;' href='?controller=Paneles&action=advertencia&cliente=$cliente&opcion=eliminarTodos'>Eliminar</a>";
    require_once "Modelos/IMGmanager.php";
    $imagenes = new ImgManager();
    $imagenes = $imagenes->ConseguirImg("WHERE id_cliente = $id");

    echo "</div>";
    echo "<div id='titular' class='titular'>";
    echo "<div class='grid'>";
    echo "<div class='caja' id='caja1'>";
    echo "<p><b>Nombre:</b> $dato[nombre]</p>";
    echo "<p><b>Segundo nombre:</b> $dato[segundo_nombre]</p>";
    echo "<p><b>Apellido:</b> $dato[primer_apellido]</p>";
    echo "<p><b>Segundo apellido:</b> $dato[segundo_apellido]</p>";
    echo "<p><b>Fecha de Nacimiento:</b> $dato[fecha_nacimiento]</p>";
    echo "<p><b>SSN:</b> $dato[SSN]</p>";
    echo "<p><b>Alien Number:</b> $dato[alien_number]</p>";
    echo "<p><b>Telefono:</b> $dato[telefono]</p>";
    echo "</div>";
    echo "<div class='caja' id='caja2'>";
    echo "<p><b>Genero:</b> $dato[genero]</p>";
    echo "<p><b>Correo Electronico:</b> $dato[email]</p>";
    echo "<p><b>Direccion:</b> $dato[direccion]</p>";
    echo "<p><b>Ciudad:</b> $dato[ciudad]</p>";
    echo "<p><b>Estado:</b> $dato[estado]</p>";
    echo "<p><b>Codigo Postal:</b> $dato[codigo_postal]</p>";
    echo "<p><b>Empresa:</b> $dato[empresa]</p>";
    echo "<p><b>Cobertura:</b> $dato[en_poliza]</p>";
    echo "</div>";
    echo "<p style='padding-left:10px;' ><b>Notas:</b> $dato[notas]</p>";
    echo "</div></div>";
    if ($dato['actualizado'] == 1) {
        echo "<p><b>Actualizado:</b> <span>Si</span></p>";
    } else {
        echo "<p><b>Actualizado:</b> <span>No</span></p>";
    }
    if ($dato['estatus_migratorio'] == 1) {
        echo "<p><b>Documentos de estatus migratorio: </b> <span>Si</span></p>";
    } else {
        echo "<p><b>Documentos de estatus migratorio: </b> <span>No</span></p>";
    }
    if ($dato['declaracion_fiscal'] == 1) {
        echo "<p><b>Declaracion Fiscal: </b> <span>Si</span></p>";
    } else {
        echo "<p><b>Declaracion Fiscal: </b> <span>No</span></p>";
    }
    # Si no hay imagenes asociadas al titular mostrar boton para agregar
    # Si hay imagenes asociadas al titular mostrar boton para ver
    if ($imagenes->rowCount()) {
        echo " <a class ='boton' style='margin-left:0px; margin-right:4px;' href='?controller=Paneles&action=pagina_img&cliente=$id&add=0'>Ver Documentos</a><br><br>";
    } else {
        echo " <a class='boton' style='margin-left:0px; margin-right:4px;' href='?controller=Paneles&action=pagina_img&cliente=$id&add=1'>Agregar Documentos</a><br><br>";
    }
    echo "<hr>";
}

# Conyuge
require_once "Modelos/Grupo.php";
$DB = new Grupo();
$conyugue = $DB->Conseguir_Miembro("WHERE id_cliente = $cliente AND relacion = 'Conyuge'");
echo "<h1>Informacion del Conyuge</h1>";
if ($conyugue->rowCount() > 0) {
    // La consulta ha encontrado algo
    foreach ($conyugue as $dato) {
        $miembro = $dato['id_miembro_grupo'];
        echo "<a class='boton' style='margin-left:0px; margin-right:4px;' href='?controller=Paneles&action=editar&cliente=$miembro&conyugue=1&titular=$cliente'>Editar</a>";
        echo "<a class='boton' style=background-color:red;' href='?controller=Paneles&action=advertencia&miembro=$miembro&cliente=$cliente&opcion=eliminarConyuge'>Eliminar</a>";
        echo "<div class='grid'>";
        echo "<div class='caja' id='caja1'>";
        echo "<p><b>Nombre:</b> $dato[nombre]</p>";
        echo "<p><b>Segundo nombre:</b> $dato[segundo_nombre]</p>";
        echo "<p><b>Apellido:</b> $dato[apellido]</p>";
        echo "<p><b>Genero:</b> $dato[genero]</p>";
        echo"</div><div class='caja' id='caja2'>";
        echo "<p><b>Fecha de Nacimiento:</b> $dato[fecha_nacimiento]</p>";
        echo "<p><b>Alien Number:</b> $dato[alien_number]</p>";
        echo "<p><b>SSN:</b> $dato[SSN]</p>";
        echo "<p><b>Cobertura:</b> $dato[en_poliza]</p></div></div></div>";
        if ($dato['estatus_migratorio'] == 1) {
            echo "<p><b>Estatus migratorio: </b> <span>Si</span></p>";
        } else {
            echo "<p><b>Estatus migratorio: </b> <span>No</span></p>";
        }
        if ($dato['notas'] != null) {
            echo "<p><b>Notas:</b> \"$dato[notas]\"</p>";
        }
    }
} else {
    // La consulta no ha encontrado nada
    echo "<a class='boton' href='?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente'>Agregar +</a><br><br>";
}


# Dependientes
$dependientes = $DB->Conseguir_Miembro("WHERE id_cliente = $cliente AND relacion != 'Conyuge'");
echo "<hr>";
echo "<h1>Informacion de Dependientes</h1>";
foreach ($dependientes as $dato) {
    $miembro = $dato['id_miembro_grupo'];
    echo "<a class='boton' style='margin-left:0px; margin-right:4px;' href='?controller=Paneles&action=editar&cliente=$miembro&depende=1&titular=$cliente'>Editar</a>";
    echo "<a class='boton' style=background-color:red;' href='?controller=Paneles&action=advertencia&miembro=$miembro&cliente=$cliente&opcion=eliminarDependiente'>Eliminar</a>";
    echo "<div class='grid'>";
    echo "<div class='caja' id='caja1'>";
    echo "<p><b>Nombre:</b> $dato[nombre]</p>";
    echo "<p><b>Segundo nombre:</b> $dato[segundo_nombre]</p>";
    echo "<p><b>Apellido:</b> $dato[apellido]</p>";
    echo "<p><b>Genero:</b> $dato[genero]</p>";
    echo"</div><div class='caja' id='caja2'>";
    echo "<p><b>Fecha de Nacimiento:</b> $dato[fecha_nacimiento]</p>";
    echo "<p><b>Alien Number:</b> $dato[alien_number]</p>";
    echo "<p><b>SSN:</b> $dato[SSN]</p>";
    echo "<p><b>Cobertura:</b> $dato[en_poliza]</p></div>
    <p style='padding-left:10px;'><b>Relacion:</b> $dato[relacion]</p></div>";

    if ($dato['estatus_migratorio'] == 1) {
        echo "<p><b>Estatus migratorio: </b> <span>Si</span></p>";
    } else {
        echo "<p><b>Estatus migratorio: </b> <span>No</span></p>";
    }
    if ($dato['notas'] != null) {
        echo "<p><b>Notas:</b> \"$dato[notas]\"</p><hr><br>";
    }
}
echo "<br><a class='boton' style:'margin-left:0px' href='?controller=Paneles&action=formularioDepende"."&id_cliente=$cliente&depende=0'>Agregar +</a><br><br>";
