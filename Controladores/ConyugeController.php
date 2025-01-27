<?php

class ConyugeController
{
    public function Agregar()
    {
        if (isset($_POST)) {
            if ($_GET['miembro']) {
                $miembro = $_GET['miembro'];
            }
            require_once 'Modelos/Grupo.php';
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
}// fin clase
