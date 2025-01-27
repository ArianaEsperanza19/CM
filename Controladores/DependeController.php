<?php

class DependeController
{
    /**
     * Método que se encarga de registrar un nuevo dependiente para un cliente específico
     * y redirige al formulario de dependientes.
     *
     * - Verifica si hay datos POST para procesar.
     * - Obtiene el ID del cliente de la consulta GET.
     * - Registra los datos del dependiente en la base de datos.
     * - Redirige al usuario al formulario de dependientes para el cliente dado.
     *
     * @return void
     */

    public function Agregar()
    {
        if (isset($_POST)) {
            {
                if (isset($_GET['titular'])) {
                    $id_cliente = $_GET['titular'];
                }
                require_once 'Modelos/Grupo.php';
                $registro = new Grupo();
                $registro->registrar($_POST, $id_cliente);
                header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
            }
        }
    }

    public function Editar()
    {
        if (isset($_POST)) {
            $id = isset($_GET['miembro']) ? $_GET['miembro'] : false;
            require_once 'Modelos/Grupo.php';
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
    public function Eliminar()
    {
        if (isset($_GET['miembro'])) {
            $titular = isset($_GET['titular']) ? $_GET['titular'] : false;
            $id = $_GET['miembro'];
            require_once 'Modelos/Grupo.php';
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
}//fin clase
