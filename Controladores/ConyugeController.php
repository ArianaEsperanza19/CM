<?php

require_once 'Modelos/Grupo.php';
class ConyugeController
{
    /**
     * Agrega un conyugue a la base de datos.
     * La funcion recibe por $_GET['miembro'] el id del miembro al que se le va a agregar el conyugue.
     * Si se esta agregando un conyugue a un dependiente, redirige a la pagina de formulario de dependientes.
     * Si se esta agregando un conyugue a un titular, redirige a la pagina de informacion del cliente.
     */
    public function Agregar()
    {
        if (isset($_POST)) {
            if ($_GET['miembro']) {
                $miembro = $_GET['miembro'];
            }
            $registro = new Grupo();
            $registro->registrar($_POST, $miembro);
            if ($_GET['depende'] == 1) {

                header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$miembro");
            }
            if ($_GET['depende'] == 0) {
                header("Location: ?controller=Paneles&action=info&cliente=$miembro");
            }

        }

    }// fin Agregar

    /**
     * Edita un registro de conyugue existente en la base de datos.
     * La funcion recibe por $_GET['miembro'] el id del miembro al que se le va a editar el conyugue.
     * Si la edicion es exitosa, redirige a la pagina de informacion del cliente,
     * pasando un parametro GET 'token' con un valor aleatorio para impedir que el usuario pueda retroceder al formulario.
     */
    public function Editar()
    {
        if (isset($_POST)) {
            $id = isset($_GET['miembro']) ? $_GET['miembro'] : false;
            $registro = new Grupo();
            $sentencia = $registro->editar($_POST, $id);
            $titular = $registro->info_titular($id);

            if ($sentencia && $titular) {
                # El token es necesario para impedir que el usuario pueda retroceder al formulario
                $token = md5(uniqid());
                header("Location: ?controller=Paneles&action=info&cliente=$titular&token=$token");
            }
        }

    }
    /**
     * Elimina un registro de conyugue existente en la base de datos.
     * La funcion recibe por $_GET['miembro'] el id del miembro al que se le va a eliminar el conyugue.
     * Si la eliminacion es exitosa, redirige a la pagina de informacion del cliente,
     * pasando un parametro GET 'token' con un valor aleatorio para impedir que el usuario pueda retroceder al formulario.
     */
    public function Eliminar()
    {
        if (isset($_GET['miembro'])) {
            $titular = isset($_GET['titular']) ? $_GET['titular'] : false;
            $id = $_GET['miembro'];
            $grupo = new Grupo();
            $sentecia = $grupo->eliminar_uno($id);
            if ($sentecia) {
                $_SESSION['advertencia'] = true;
                header('Location: ?controller=Paneles&action=info&cliente='.$titular);
            } else {
                die("Error al eliminar");
            }
            exit;
        }//fin isset GET

    }
}// fin clase
