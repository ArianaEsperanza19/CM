<?php

class PanelesController
{
    public function index()
    {
        require_once 'Vistas/paneles/principal.php';
    }
    public function formularioTitular()
    {
        require_once 'Vistas/paneles/Formularios/formularioTitular.php';
    }
    public function formularioConyugal()
    {
        require_once 'Vistas/paneles/Formularios/formularioConyugal.php';
    }
    public function formularioDepende()
    {
        require_once 'Vistas/paneles/Formularios/formularioDepende.php';
    }
    public function formularioRegistro()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = $_GET['cliente'];
        }
        require_once 'Vistas/paneles/Formularios/formularioRegistro.php';

    }
    /**
     * Muestra la informacion del cliente en la base de datos.
     *
     * - Verifica si se ha enviado un cliente en la peticion.
     * - Si se ha proporcionado el par;metro 'cliente', muestra la informacion del cliente en la base de datos.
     *
     * @return void
     */
    public function info()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = $_GET['cliente'];
            require_once 'Vistas/paneles/info.php';
        }
    }
    public function editar()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = $_GET['cliente'];
            if (isset($_GET['depende'])) {
                global $depende;
                $depende = true;
                require_once 'Vistas/paneles/Formularios/formularioDepende.php';
            }
            if (isset($_GET['conyugue'])) {
                global $conyugue;
                $conyugue = true;
                require_once 'Vistas/paneles/Formularios/formularioConyugal.php';
            }
        }
        if (isset($_GET['cliente_titular'])) {
            global $editar_titular;
            $editar_titular = $_GET['cliente_titular'];
            require_once 'Vistas/paneles/Formularios/formularioTitular.php';
        }
    }
    /**
     * Mostrar una advertencia al usuario antes de eliminar un conyugue o un dependiente
     *
     * Si se ha enviado un cliente en la peticion se mostrara una advertencia al usuario
     * para confirmar que desea eliminar el conyugue o el dependiente.
     * Si no se ha enviado un cliente se mostrara un mensaje de error.
     */
    public function advertencia()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = $_GET['cliente'];
            if (isset($_GET['opcion']) == "eliminarConyuge") {
                global $miembro;
                $miembro = isset($_GET['miembro']) ? $_GET['miembro'] : false;
            } elseif (isset($_GET['opcion']) == "eliminarDependiente") {
                global $miembro;
                $miembro = isset($_GET['miembro']) ? $_GET['miembro'] : false;
            }
            require_once 'Vistas/paneles/Advertencia.php';
        } else {
            echo "No se ha enviado un cliente";
        }
    }
    /**
     * Muestra la informacion del seguro de un cliente en la base de datos.
     *
     * - Verifica si se ha enviado un cliente en la peticion.
     * - Si se ha proporcionado el par;metro 'seguro' y su valor es 1, edita la informacion del seguro.
     * - De lo contrario, muestra la informacion del seguro en la base de datos.
     *
     * @return void
     */
    public function InfoSeguros()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
            # Editar
            if (isset($_GET['seguro']) == 1) {
                $_SESSION['seguro_centinela'] = true;
                require_once 'Vistas/paneles/Formularios/formularioSeguro.php';
            }
            if (!isset($_GET['seguro']) || isset($_GET['seguro']) != 1) {
                require_once 'Vistas/paneles/InfoSeguros.php';
            }
        } else {
            echo "No se ha enviado un cliente";
        }
    }
    /**
     * Muestra la informacion del banco de un cliente en la base de datos.
     *
     * - Verifica si se ha enviado un cliente en la peticion.
     * - Si se ha proporcionado el par;metro 'banco' y su valor es 1, edita la informacion del banco.
     * - De lo contrario, muestra la informacion del banco en la base de datos.
     *
     * @return void
     */
    public function InfoBanco()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : false;
            if (isset($_GET['banco']) == 1) {
                $_SESSION['banco_centinela'] = true;
                require_once 'Vistas/paneles/Formularios/formularioBanco.php';
            }
            if (!isset($_GET['banco']) || isset($_GET['banco']) != 1) {
                require_once 'Vistas/paneles/InfoBanco.php';

            }
        } else {
            echo "No se ha enviado un cliente";
        }
    }

    /**
     * Muestra la informacion de las imagenes de un cliente en la base de datos.
     *
     * - Verifica si se ha enviado un cliente en la peticion.
     * - Si se ha proporcionado el par;metro 'add' y su valor es 1 o 2, edita o agrega una imagen.
     * - De lo contrario, muestra la informacion de las imagenes en la base de datos.
     *
     * @return void
     */
    public function pagina_img()
    {
        if (isset($_GET['cliente'])) {
            global $cliente;
            $cliente = $_GET['cliente'];
            require_once 'Vistas/paneles/pagina_img.php';
        } else {
            die("No se ha enviado un cliente");
        }
    }

}
