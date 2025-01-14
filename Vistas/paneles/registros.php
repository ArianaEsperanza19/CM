<?php

foreach ($datos as $registro) {
echo "<div>
    <p>Fecha: $registro[fecha]</p>
    <p>Descripcion: $registro[descripcion]</p>
<a class='boton' href='?controller=Cliente&action=eliminarRegistro&cliente=$registro[id_cliente]'>Eliminar</a>
<a class='boton' href='?controller=Cliente&action=editarRegistro&editar=1&registro=$registro[id_registro]&cliente=$registro[id_cliente]'>Editar</a>
</div>";

}

