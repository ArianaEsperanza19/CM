<?php
echo "Soy el formulario para conyugues";
if($_GET['id_cliente']){
    $id_titular = $_GET['id_cliente'];
}
?>
<h2>Formulario de Registro</h2> 
<form action="<?php echo "?controller=Cliente&action=Agregar_Conyugue&id_cliente=$id_titular" ?>" method="POST"> 
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
    <select id="pareja" name="pareja" hidden>
    <option value="0">No</option>
    <option value="1" selected>Si</option>
    </select><br>
    <label for="fecha_nacimiento">Fecha de Nacimiento:</label> <br>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" > <br>
    <button type="submit">Enviar</button> </form>

