<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/formularioRegistro.css\">";
require_once 'Modelos/Grupo.php';
$datos = new Grupo();
$datos = $datos->conseguirRegistro(id_cliente: $cliente);
# Verificar si hay no hay registros en la base de datos, para agregar el primero, o si se va a agregar uno nuevo
if (isset($_GET['add']) == 1 || $datos->rowcount() == 0) {
    $datos = $datos->fetchAll();
    echo "<div class='menu'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
    echo "</div>";
    echo "<form method='post' action='?controller=Cliente&action=agregarRegistro' enctype='multipart/form-data'>
    <input type='hidden' name='id_cliente' value='$cliente'>
    <label for='descripcion'>Descripcion</label>
    <textarea type='text' name='descripcion' id='descripcion'></textarea>
    <input type='submit' value='Registrar' class='boton'>
</form>";

}// if agregar o editar
else {
    # Verificar si hay mas de un registro y no se busca agregar uno nuevo, mostrar registros existentes.
    if ($datos->rowcount() > 0) {
        if (isset($_GET['editar']) == 1) {
            echo "<div class='menu'><a class='boton' href='?controller=Paneles&action=formularioRegistro&cliente=$cliente'>Volver</a>";
            $registro = isset($_GET['registro']) ? $_GET['registro'] : false;
            require_once 'Modelos/Grupo.php';
            $datos = new Grupo();
            $datos = $datos->conseguirRegistro(id_registro: $registro);
            $datos = $datos->fetch();
            $descripcion = $datos['descripcion'];
            $registro = $datos['id_registro'];
            echo "</div>";
            echo "<form method='post' action='?controller=Cliente&action=editarRegistro' enctype='multipart/form-data'>
    <input type='hidden' name='id_cliente' value='$cliente'>
    <input type='hidden' name='id_registro' value='$registro'>
    <label for='descripcion'>Descripcion</label>
    <textarea type='text' name='descripcion' id='descripcion'>$descripcion</textarea>
    <input type='submit' value='Registrar' class='boton'>
</form>";
        } else {
            echo "<div class='menu'><a class='boton' href='?controller=Paneles&action=info&cliente=$cliente'>Volver</a>";
            echo "<a class='boton' id='' href='?controller=Paneles&action=formularioRegistro&cliente=$cliente&add=1'>Agregar+</a></div>";
            require_once 'Vistas/paneles/registros.php';

        }
    }//else mostrar

}
