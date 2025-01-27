<?php

require_once 'Modelos/Grupo.php';
class DependeController
{

    /**
     * Agrega un nuevo registro de dependiente
     * @param none
     * @return none
     */
    public function Agregar()
    {
        if (isset($_POST)) {
            {
                if (isset($_GET['titular'])) {
                    $id_cliente = $_GET['titular'];
                }
                $registro = new Grupo();
                $registro->registrar($_POST, $id_cliente);
                header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
            }
        }
    }

    /**
     * Edita un registro de dependiente
     * @param none
     * @return none
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
     * Elimina un registro de dependiente
     * @param none
     * @return none
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
}//fin clase
