<?php
#session_start();
require_once 'Herramientas/DatosManager.php';
class User
{
    public function Registrar($datos)
    {
    /**
     * Registra un nuevo usuario en la base de datos.
     * Verifica si ya existen usuarios en la base de datos y, si no hay, registra uno nuevo como administrador.
     * Devuelve un mensaje de exito o error al registrar.
     * @param array $datos Arreglo con los datos del nuevo registro.
     */
        #Autenticacion
        #Verificar si ya existen usuarios
        $DB = new DatosManager(tabla: 'users');
        $usuarios = $DB->Conseguir_Todos();
        if(count($usuarios) > 0){
        #Registrar
        $sentencia = $DB->Registrar($datos);
        if($sentencia){
        $_SESSION['flash'] = 'Registrado con exito';
        }else{
        $_SESSION['flash'] = 'Error al registrar';
        }
        }else{
        //Registrar como administrador
        require_once './Herramientas/Admin.php';
        $admin = new Admin();
        $sentencia = $admin->Registrar($datos);
        if($sentencia){
        $_SESSION['flash'] = 'Registrado con exito como administrador';
        }else{

        $_SESSION['flash'] = "Error al registrar"; 

        }
        }

        //var_dump($sentencia);
        //die(); 
        #Redireccionar
        header('Location: ./Vistas/Formulario.php');
    }
    public function Borrar($id)
    {
    /**
     * Borra un usuario de la base de datos.
     * Verifica si se ha pasado el id del usuario a eliminar y, si es asi, lo elimina.
     * Redirecciona a la pagina de registros.
     * @param int $id El id del usuario a eliminar.
     */
        if (isset($id)) {
            $DB = new DatosManager(id: $id, tabla: 'users');
            $DB->Eliminar();
            header('Location: ./Vistas/Registros.php');
        } else {
            header('Location: ./Vistas/Registros.php');
        }
    }
    public function Editar($datos, $id)
    {
    /**
     * Edita un usuario en la base de datos.
     * Verifica si se ha pasado el id del usuario a editar y, si es asi, lo edita.
     * Redirecciona a la pagina de formulario.
     * @param array $datos Arreglo con los datos del usuario a editar.
     * @param int $id El id del usuario a editar.
     */
        $DB = new DatosManager(id: $id, tabla: 'users');
        $sentencia = $DB->Editar($datos);
        $_SESSION['flash'] = 'Editado con exito';
        header('Location: ./Vistas/Formulario.php');
    }
    public function Iniciar_Sesion() {}
    public function Cerrar_Sesion() {}
}
