<?php
echo "Soy el formulario para un nuevo cliente";
?>
<h2>Formulario de Registro de Titulares</h2> 
<form action="?controller=Cliente&action=Crear" method="POST"> 
    <label for="nombre">Nombre:</label><br> 
    <input type="text" id="nombre" name="nombre" maxlength="50" required><br> 
    <label for="segundo_nombre">Segundo Nombre:</label><br> 
    <input type="text" id="segundo_nombre" name="segundo_nombre" maxlength="50"><br>
    <label for="primer_apellido">Primer Apellido:</label> <br>
    <input type="text" id="primer_apellido" name="primer_apellido" maxlength="50" required> <br>
    <label for="segundo_apellido">Segundo Apellido:</label> <br>
    <input type="text" id="segundo_apellido" name="segundo_apellido" maxlength="50"> <br>
    <label for="ssn">SSN:</label> <br>
    <input type="text" id="ssn" name="ssn" maxlength="20" > <br>
    <label for="alien_number">Alien Number:</label> <br>
    <input type="text" id="alien_number" name="alien_number" maxlength="20"> <br>
    <label for="genero">Genero </label>
    <select id="genero" name="genero">
    <option value="F" selected>Femenino</option> 
    <option value="M">Masculino</option> 
    </select><br>
    <label for="fecha_nacimiento">Fecha de Nacimiento:</label> <br>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" > <br>
    <label for="direccion">Dirección:</label> <br>
    <input type="text" id="direccion" name="direccion" maxlength="100" > <br>
    <label for="ciudad">Ciudad:</label><br> 
    <input type="text" id="ciudad" name="ciudad" maxlength="50" required> <br>
    <label for="estado">Estado:</label><br> 
    <input type="text" id="estado" name="estado" maxlength="50" required> <br>
    <label for="codigo_postal">Código Postal:</label> <br>
    <input type="text" id="codigo_postal" name="codigo_postal" maxlength="10" > <br>
    <label for="telefono">Teléfono:</label> <br>
    <input type="text" id="telefono" name="telefono" maxlength="20" > <br>
    <label for="email">Email:</label> <br>
    <input type="email" id="email" name="email" maxlength="50" > <br>
    <label for="empresa">Empresa:</label> <br>
    <input type="text" id="empresa" name="empresa" maxlength="50"> <br>
    <label for="notas">Notas:</label> <br>
    <textarea id="notas" name="notas" maxlength="200"></textarea> <br>
    <label for="actualizado">¿La información está actualizada? </label>
    <select id="actualizado" name="actualizado">
    <option value="0" selected>No</option> 
    <option value="1">Sí</option> 
    </select><br>
    <label for="conyugue">¿Está casad@? </label>
    <select id="conyugue" name="matrimonio">
    <option value="0" selected>No</option> 
    <option value="1">Sí</option> 
    </select><br>
    <label for="dependientes">¿Cuantos dependientes tiene? </label>
    <input type="number" id="dependientes" name="dependientes"><br>
    <button type="submit">Enviar</button> </form>