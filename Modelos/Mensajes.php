<?php

class Mensajes
{
    public function advertencia($texto, $cliente, $redireccion)
    {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/advertencia.css\">";
        echo "<div id='advertencia'>";
        echo $texto."<br>";
        echo "<a class='boton' style='color: red;' href='$redireccion'>Si</a><br>";
        echo "<a class='boton' style='color: green;' href='?controller=Paneles&action=info&cliente=$cliente'>No</a>";
        echo "</div>";

    }

    public function noEncontrado($mensaje)
    {
        echo "<p class='mensaje'><b>$mensaje</b></p>";
    }

    public function imagenNoSubida($mensaje)
    {
        echo "<span style='color: red;margin-left: 10px'>$mensaje</span>";

    }

    public function NoImagenes($mensaje)
    {

        echo "<p class='mensaje'><b>$mensaje</b></p>";
    }

}
