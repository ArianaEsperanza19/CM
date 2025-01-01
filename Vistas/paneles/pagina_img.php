<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/formularioBancoSeguro.css\">";
echo "<div id='contenedor'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";

# Formulario para registrar imagen
if (isset($_GET['add']) && isset($_GET['cliente']) && $_GET['add'] == 1) {
    echo "
    <div id='datos'>
    <h1>Agregar Imagen</h1>
    <form action='?controller=Cliente&action=agregarImg' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='id' value='" . $_GET['cliente'] . "'>
    <label for='imagen'>Nombre:</label><br>
    <input type='text' name='nombre'><br>
    <label for='imagen'>Imagen:</label><br>
    <input type='file' name='imagen'><br>
    <input type='submit' value='Enviar'>
    </form>
    </div></div>";
}
if (isset($_GET['add']) && isset($_GET['cliente']) && $_GET['add'] == 0) {
    echo "Mostrar imagenes";
    require_once "Modelos/DatosManager.php";
    $DB = new DatosManager(tabla: 'Img');
    $imagenes = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
    foreach ($imagenes as $dato) {
        $idImg = $dato['imagen'];
    }
    if ($imagenes->rowCount() > 0) {
        echo "<div id='datos'>";
        echo "<h1>Documentos</h1>";

        }
        echo "</div>";
    } else {
        echo "No se encontraron imágenes.";
    }


# Volver a la pagina del cliente