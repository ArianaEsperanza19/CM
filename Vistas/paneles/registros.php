<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Vistas/css/registros.css\">";
echo "<div class='contenedor'>";
foreach ($datos as $registro) {
    echo "<a class='volver' href='?controller=Cliente&action=editarRegistro&editar=1&registro=$registro[id_registro]&cliente=$registro[id_cliente]'>Editar</a>
<a class='volver' style='background-color: red' href='?controller=Cliente&action=eliminarRegistro&cliente=$registro[id_cliente]&registro=$registro[id_registro]'>Eliminar</a>
    <p id='fecha'>Fecha: $registro[fecha]</p>
";
    echo "<div class='registro'>
    <p id='descripcion'><span id=''>Descripcion:</span> $registro[descripcion]</p>

</div>";

}
echo "</div>";
