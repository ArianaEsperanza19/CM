<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/pagina_img.css\">";
// 0 mostrar
// 1 agregar
// 2 editar
# Mostrar imagenes
if (isset($_GET['add']) && isset($_GET['cliente']) && $_GET['add'] == 0) {
echo "<div id='contenedor'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
    require_once "Modelos/DatosManager.php";
    $DB = new DatosManager(tabla: 'Img');
    $imagenes = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
    foreach ($imagenes as $dato) {
        $id = $dato['id_img'];
        $img = $dato['imagen'];
    }
    if ($imagenes->rowCount() > 0) {
    echo "<a class='boton' href='?controller=Paneles&action=pagina_img&cliente=$id&add=1&cliente=$cliente'>Agregar</a>";
if(isset($_SESSION['flash'])){
    $m = $_SESSION['flash'];
    echo "<span style='color: red;margin-left: 10px'>$m</span>";
    unset($_SESSION['flash']);
}
    echo "<h1>Documentos</h1>";
    echo "<div class='contenedor'>";
        echo "<div id='datos'>";
        $DB = new DatosManager(tabla: 'Img');
        $imagenes = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
        foreach ($imagenes as $dato) {
            $id = $dato['id_img'];
            $Img = $dato['imagen'];
            $nombre = $dato['nombre'];
            $descripcion = $dato['descripcion'];
            echo "<div class='imagen'><img src='Vistas/img/$Img' alt='Imagen'><div class='texto'>
            <p>Nombre: $nombre</p>
            <p>Descripcion: $descripcion</p><div>
            <a class='boton' href='?controller=Cliente&action=eliminarImg&cliente=$cliente&img=$id'>Eliminar</a>
            <a class='boton' href='?controller=Paneles&action=pagina_img&cliente=$cliente&add=2&img=$id'>Editar</a></div>
            </div></div>";

        }}
    echo "</div>";
        echo "</div>";
    }else{

        $DB = new DatosManager(tabla: 'Img');
        $imagenes = $DB->Conseguir_Registro("WHERE id_cliente = $cliente");
if($imagenes->rowCount() == 0){
echo "<div id='contenedor'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
}elseif($imagenes->rowCount() > 0){
echo "<div id='contenedor'><a class='boton' href='?controller=Paneles&action=pagina_img&cliente=$cliente&add=0'>Volver</a>";

}
# Formulario para registrar imagen
if (isset($_GET['add']) && isset($_GET['cliente']) && $_GET['add'] == 1) {
    echo "
    <div id='datos'>
    <h1>Agregar Imagen</h1>
    <form action='?controller=Cliente&action=agregarImg' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='id' value='" . $_GET['cliente'] . "'>
    <label for='imagen'>Nombre:</label><br>
    <input type='text' name='nombre'><br>
    <label for='descripcion'>Descripcion:</label><br>
    <input type='text' name='descripcion'><br>
    <label for='imagen'>Imagen:</label><br>
    <input type='file' name='imagen' required><br>
    <input type='submit' value='Enviar'>
    </form>
    </div></div>";
}


# Editar imagen
if (isset($_GET['add']) && isset($_GET['cliente']) && isset($_GET['img']) && $_GET['add'] == 2) {
    require_once "Modelos/DatosManager.php";
    $DB = new DatosManager(tabla: 'Img');
    $img = $_GET['img'];
    $imagenes = $DB->Conseguir_Registro("WHERE id_img = $img");
    if ($imagenes->rowCount() > 0) {
    foreach ($imagenes as $dato) {
        $id = $dato['id_img'];
        $Img = $dato['imagen'];
        $nombre = $dato['nombre'];
        $descripcion = $dato['descripcion'];
    }}
    echo "
    <div id='datos'>
    <h1>Agregar Imagen</h1>
    <form action='?controller=Cliente&action=editarImg' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='id_img' value='" . $id . "'>
    <input type='hidden' name='id' value='" . $_GET['cliente'] . "'>
    <label for='imagen'>Nombre:</label><br>
    <input value='$nombre' type='text' name='nombre'><br>
    <label for='descripcion'>Descripcion:</label><br>
    <input value='$descripcion' type='text' name='descripcion'><br>
    <label for='imagen'>Imagen:</label><br>
    <input type='file' name='imagen'><br>
    <img class='miniatura' src='Vistas/img/$Img' alt='Imagen'>
    <input type='submit' value='Enviar'>
    </form>
    </div></div>";
}
}
    if($imagenes->rowCount() == 0){
        echo "No se encontraron imágenes.";
    }


# Volver a la pagina del cliente
