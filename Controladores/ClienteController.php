<?php

require_once 'Modelos/Titulares.php';

class ClienteController
{
    public function VerTodos()
    {
    }
    public function VerUno()
    {
    }
    /**
     * Metodo que se encarga de registrar un nuevo cliente y redirigir segun sea necesario
     * para registrar conyugue o dependientes.
     *
     * @return void
     */
    public function Crear()
    {
        if (isset($_POST)) {
            $datos = new Titulares();
            $sentencia = $datos->Registrar($_POST);
            $cliente_id = $datos->Ultimo_Registro();
            $cliente_id = $cliente_id['id_cliente'];
            if ($sentencia) {

                if ($_POST['matrimonio'] == 1 && $_POST['dependientes'] == 0) {
                    header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id&depende=0");
                    exit;
                } elseif ($_POST['dependientes'] == 1 && $_POST['matrimonio'] == 1) {
                    header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id&depende=1");
                    exit;
                } elseif ($_POST['dependientes'] == 1 && $_POST['matrimonio'] == 0) {
                    header("Location: ?controller=Paneles&action=formularioDepende"."&id_cliente=$cliente_id&depende=1");
                    exit;
                } elseif ($_POST['matrimonio'] == 0 && $_POST['dependientes'] == 0) {
                    header('Location: ?controller=Paneles&action=index');
                    exit;
                } else {
                    header('Location: ?controller=Paneles&action=index');
                    exit;
                }
            }
        }
    }
    /**
     * Metodo que se encarga de registrar un nuevo conyugue y redirigir segun sea necesario
     * para registrar dependientes.
     *
     * @return void
     */
    public function Agregar_Conyuge()
    {
        if (isset($_POST)) {
            if ($_GET['id_cliente']) {
                $id_cliente = $_GET['id_cliente'];
            }
            require_once 'Modelos/Grupo.php';
            $registro = new Grupo();
            $registro->registrar($_POST, $id_cliente);
            if ($_GET['depende'] == 1) {

                header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
            }
            if ($_GET['depende'] == 0) {
                header("Location: ?controller=Paneles&action=info&cliente=$id_cliente");
            }

        }
    }

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

    public function Agregar_Depende()
    {
        if (isset($_POST)) {
            {
                if ($_GET['id_cliente']) {
                    $id_cliente = $_GET['id_cliente'];
                }
                require_once 'Modelos/Grupo.php';
                $registro = new Grupo();
                $registro->registrar($_POST, $id_cliente);
                header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
            }
        }
    }
    /**
     * Método para editar información de un cliente, ya sea conyugue, dependiente o titular.
     *
     * - Verifica si hay datos POST para procesar.
     * - Obtiene el ID del cliente de la consulta GET.
     * - Si el cliente es un conyugue o dependiente, actualiza su información en la base de datos.
     * - Si es un titular, actualiza la información correspondiente.
     * - Redirige al usuario a la página de información del cliente con un token para evitar volver al formulario.
     *
     * @return void
     */

    public function Editar()
    {
        if (isset($_POST)) {
            if (isset($_GET['cliente'])) {
                $id = $_GET['cliente'];
                if (isset($_GET['conyugue']) == 1 || isset($_GET['depende']) == 1) {
                    # Editar conyugue o dependiente
                    require_once 'Modelos/Grupo.php';
                    $registro = new Grupo();
                    $sentencia = $registro->editar($_POST, $id);
                    $titular = $registro->info_titular($id);
                    if ($sentencia && $titular) {
                        # El token es necesario para impedir que el usuario pueda retroceder al formulario
                        $token = md5(uniqid());
                        header("Location: ?controller=Paneles&action=info&cliente=$titular&token=$token");
                    }

                } else {
                    # Editar titular
                    $DB = new Titulares();
                    $sentencia = $DB->Editar($_POST, $id);
                    $token = md5(uniqid());
                    if ($sentencia) {
                        header("Location: ?controller=Paneles&action=info&cliente=$id&token=$token");
                    } else {
                        # ERROR
                        echo "Error al editar";
                    }
                }
            }
        }
    }
    /**
     * Elimina un cliente o un miembro del grupo en la base de datos.
     * 
     * - Verifica si se ha proporcionado el ID del cliente en la consulta GET.
     * - Si el cliente es un conyugue o dependiente, elimina su información en la base de datos.
     * - Si es un titular, elimina la información correspondiente.
     * - Redirige al usuario a la página de información del cliente o a la página de inicio si se ha eliminado un titular.
     * 
     * @return void
     */
    public function Eliminar()
    {
        if (isset($_GET['cliente'])) {
            $titular = isset($_GET['titular']) ? $_GET['titular'] : false;
            $id = $_GET['cliente'];
            require_once 'Modelos/Grupo.php';
            if (isset($_GET['depende']) == 1) {
                $grupo = new Grupo();
                $sentecia = $grupo->eliminar_uno($id);
                if ($sentecia) {
                    $_SESSION['advertencia'] = true;
                    header('Location: ?controller=Paneles&action=info&cliente='.$titular);
                } else {
                    die("Error al eliminar");
                }
                exit;
            }
            if (isset($_GET['conyugue']) == 1) {
                $grupo = new Grupo();
                $sentecia = $grupo->eliminar_uno($id);
                if ($sentecia) {
                    $_SESSION['advertencia'] = true;
                    header('Location: ?controller=Paneles&action=info&cliente='.$titular);
                } else {
                    die("Error al eliminar");
                }
                exit;
            }
            $registro = new Grupo();
            $sentencia = $registro->eliminar_todos($_GET['cliente']);
            if ($sentencia) {
                $_SESSION['advertencia'] = true;
                header('Location: ?controller=Paneles&action=index');
            } else {
                echo "Error al eliminar";
            }
        }

    }
    /**
     * Registra o edita la informacion del seguro de un cliente en la base de datos.
     *
     * - Verifica si hay datos POST para procesar.
     * - Obtiene el ID del cliente de la consulta GET.
     * - Si se ha proporcionado el par;metro 'editar' y su valor es 1, actualiza la informacion del seguro.
     * - De lo contrario, registra la informacion del seguro en la base de datos.
     * - Redirige al usuario a la pagina de informacion del seguro correspondiente.
     *
     * @return void
     */
    public function registrar_editar_seguro()
    {
        if (isset($_POST)) {
            $id = $_GET['cliente'];
            require_once 'Modelos/Seguros.php';
            $registro = new Seguros();
            # Editar
            if (isset($_GET['editar']) && $_GET['editar'] == 1) {
                $sentencia = $registro->actualizar($_POST, $id);
                if ($sentencia) {
                    # Centinela que vigila si se ha editado la informacion
                    $_SESSION['editarSeguro'] = true;
                    header('Location: ?controller=Paneles&action=InfoSeguros&cliente='.$id);
                } else {
                    echo "Error al actualizar";
                }
            } else {
                $sentencia = $registro->registrar($_POST, $id);
                if ($sentencia) {
                    header('Location: ?controller=Paneles&action=InfoSeguros&cliente='.$id);
                } else {
                    echo "Error al registrar";
                }
            }

        }
    }
    /**
     * Registra o edita la información bancaria de un cliente en la base de datos.
     *
     * - Verifica si hay datos POST para procesar.
     * - Obtiene el ID del cliente de la consulta GET.
     * - Si se ha proporcionado el parámetro 'editar' y su valor es 1, actualiza la información bancaria.
     * - De lo contrario, registra la información bancaria en la base de datos.
     * - Redirige al usuario a la página de información del banco correspondiente.
     *
     * @return void
     */

    public function registrar_editar_banco()
    {
        if (isset($_POST)) {
            $id = $_GET['cliente'];
            require_once 'Modelos/Cuentas.php';
            $registro = new Cuentas();
            # Editar
            if (isset($_GET['editar']) && $_GET['editar'] == 1) {
                $sentencia = $registro->actualizar($_POST, $id);
                if ($sentencia) {
                    # Centinela que vigila si se ha editado la informacion
                    $_SESSION['editarBanco'] = true;
                    header('Location: ?controller=Paneles&action=InfoBanco&cliente='.$id);
                } else {
                    echo "Error al actualizar";
                }
            } else {
                $sentencia = $registro->registrar($_POST, $id);
                if ($sentencia) {
                    header('Location: ?controller=Paneles&action=InfoBanco&cliente='.$id);
                }
            }
        }
    }

    /**
     * Elimina un seguro asociado a un cliente de la base de datos.
     *
     * - Verifica si el ID del cliente está presente en la consulta GET.
     * - Llama al método eliminar del modelo Seguros para realizar la eliminación.
     * - Redirige al usuario a la página de información del cliente si la eliminación es exitosa.
     * - Muestra un mensaje de error en caso de fallo.
     */

    public function eliminar_seguro()
    {
        if (isset($_GET)) {
            $id = $_GET['cliente'];
            require_once 'Modelos/Seguros.php';
            $registro = new Seguros();
            $sentencia = $registro->eliminar($id);
            if ($sentencia) {
                header('Location: ?controller=Paneles&action=info&cliente='.$id);
            } else {
                echo "Error al eliminar";
            }
        }
    }

    /**
     * Elimina la información bancaria asociada a un cliente de la base de datos.
     *
     * - Verifica si el ID del cliente está presente en la consulta GET.
     * - Llama al método eliminar del modelo Cuentas para realizar la eliminación.
     * - Redirige al usuario a la página de información del cliente si la eliminación es exitosa.
     * - Muestra un mensaje de error en caso de fallo.
     */
    public function eliminar_banco()
    {
        if (isset($_GET)) {
            $id = $_GET['cliente'];
            require_once 'Modelos/Cuentas.php';
            $registro = new Cuentas();
            $sentencia = $registro->eliminar($id);
            if ($sentencia) {
                header('Location: ?controller=Paneles&action=info&cliente='.$id);
            } else {
                echo "Error al eliminar";
            }
        }
    }

    /**
     * Agrega una imagen asociada a un cliente en la base de datos.
     *
     * - Verifica si el método de la petición es POST.
     * - Obtiene los datos del formulario (id, nombre y descripción).
     * - Verifica si se ha proporcionado una imagen.
     * - Sube la imagen en la carpeta 'Vistas/img/' y la registra en la base de datos.
     * - Redirige al usuario a la página de información de imagenes del cliente si la subida es exitosa.
     * - Muestra un mensaje de error en caso de fallo.
     *
     * @return void
     */
    public function agregarImg()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'Modelos/IMGmanager.php';
            $datos = [
                'id' => $_POST['id'],
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion']
            ];
            $location = 'Location: ?controller=Paneles&action=info&cliente='.$_POST['id'];
            $modelo = new IMGmanager("Vistas/img/"); // Verifica la url
            $imagen = $modelo->uploadImage($_FILES['imagen'], $datos['nombre'], $location);
            if ($imagen) {
                require_once 'Modelos/Grupo.php';
                $DB = new Grupo();
                $sentencia = $DB->registrar_img($datos, $imagen);
                if ($sentencia) {
                    header('Location: ?controller=Paneles&action=pagina_img&cliente='.$_POST['id'].'&add=0');
                }
            } else {
                echo "Error al subir la imagen.";
            }
        }

    }
    /**
     * Elimina una imagen asociada a un cliente de la base de datos.
     *
     * - Verifica si el ID de la imagen y el ID del cliente están presentes en la consulta GET.
     * - Obtiene la ruta de la imagen y la elimina del servidor.
     * - Elimina la imagen de la base de datos.
     * - Verifica si hay más imágenes asociadas al cliente en la base de datos.
     * - Si no hay más imágenes, redirige al usuario a la página de información del cliente.
     * - Si hay más imágenes, redirige al usuario a la página de información de imágenes del cliente.
     * - Muestra un mensaje de error en caso de fallo.
     *
     * @return void
     */
    public function eliminarImg()
    {
        if (isset($_GET)) {
            $id = isset($_GET['img']) ? $_GET['img'] : null;
            $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : null;
            if ($id) {
                require_once 'Modelos/IMGmanager.php';
                $img = new IMGmanager();
                $consulta = $img->ConseguirImg("WHERE id_img = $id");
                $consulta = $consulta->fetch();
                $nombre = $consulta['imagen'];
                // Eliminar la propia imagen
                $img->borrarImagen($nombre);
                require_once 'Modelos/Grupo.php';
                $grupo = new Grupo();
                // Eliminar la imagen de la base de datos
                $grupo->Eliminar_Img($id);
                $consulta = $img->ConseguirImg("WHERE id_cliente = $cliente");
                // Verifica si hay mas imagenes en la base de datos
                $consulta = $consulta->fetchAll();
                if ($grupo) {
                    if (!$consulta) {
                        header('Location: ?controller=Paneles&action=info&cliente='.$cliente);
                    } else {
                        header('Location: ?controller=Paneles&action=pagina_img&cliente='.$cliente.'&add=0');
                    }

                } else {
                    echo "Error al eliminar";
                }
            }

        }
    }

/**
 * Edita la información de una imagen asociada a un cliente.
 *
 * - Verifica si hay datos POST y archivos subidos.
 * - Si no se ha subido una nueva imagen, redirige al usuario y muestra un mensaje de advertencia.
 * - Si se ha subido una nueva imagen, elimina la imagen anterior del servidor y sube la nueva.
 * - Actualiza la información de la imagen en la base de datos.
 * - Redirige al usuario a la página de imágenes del cliente si la edición es exitosa.
 * - Muestra un mensaje de error si ocurre una falla.
 *
 * @return void
 */

    public function editarImg()
    {
        if (isset($_POST) && isset($_FILES)) {
            $cliente = $_POST['id'];
            $id_img = $_POST['id_img'];
            $nombre = $_POST['nombre'];
            $centinela = $_FILES['imagen']['name'];
            # Si no hay una nueva imagen
            if ($centinela == "") {
                $_SESSION['flash'] = "No se ha subido ninguna imagen!";
                header('Location: ?controller=Paneles&action=pagina_img&cliente='.$_POST['id'].'&add=0');
                // header('Location: ?controller=Paneles&action=info&cliente='.$_POST['id']);
            } else {

                require_once 'Modelos/IMGmanager.php';
                $img = new IMGmanager("Vistas/img/");
                $sentencia = $img->ConseguirImg("WHERE id_cliente = '$cliente' AND id_img = '$id_img'");
                if ($sentencia) {
                    $sentencia = $sentencia->fetch();
                    $rediret = "?controller=Paneles&action=info&cliente=".$_POST['id'];
                    $img->borrarImagen($sentencia['imagen']);
                    $imagen = $img->uploadImage($_FILES['imagen'], $nombre, $rediret);
                    require_once 'Modelos/Grupo.php';
                    $grupo = new Grupo();
                    $actualizar = $grupo->actualizar_img($_POST, $imagen, $centinela);
                    if ($actualizar) {
                        header('Location: ?controller=Paneles&action=pagina_img&cliente='.$_POST['id'].'&add=0');
                    }
                } else {
                    echo "error";
                }
                echo "error";
            }
        }
    }

    /**
     * Agrega un registro a la base de datos.
     *
     * - Verifica si hay datos POST.
     * - Obtiene el ID del cliente de la consulta POST.
     * - Registra el registro en la base de datos.
     * - Redirige al usuario a la página de información de registros del cliente.
     * - Muestra un mensaje de error en caso de fallo.
     *
     * @return void
     */
    public function agregarRegistro()
    {
        if (isset($_POST)) {
            require_once 'Modelos/Grupo.php';
            $registro = new Grupo();
            $sentencia = $registro->guardarRegistro($_POST);
            if ($sentencia) {
                header('Location: ?controller=Paneles&action=formularioRegistro&cliente='.$_POST['id_cliente']);
            }
        }
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * - Verifica si se ha proporcionado el ID del registro y el ID del cliente en la consulta GET.
     * - Llama al método eliminarRegistro del modelo Grupo para realizar la eliminación.
     * - Redirige al usuario a la página de información del cliente si la eliminación es exitosa.
     * - Muestra un mensaje de error en caso de fallo.
     *
     * @return void
     */
    public function eliminarRegistro()
    {
        if (isset($_GET)) {
            $r = isset($_GET['registro']) ? $_GET['registro'] : false;
            $c = isset($_GET['cliente']) ? $_GET['cliente'] : false;
            require_once 'Modelos/Grupo.php';
            $registro = new Grupo();
            $sentencia = $registro->eliminarRegistro($r, $c);
            if ($sentencia) {
                header('Location: ?controller=Paneles&action=info&cliente='.$_GET['cliente']);
            }
        }
    }
    /**
     * Edita un registro existente en la base de datos o muestra un formulario para editar.
     *
     * - Si se ha proporcionado el parámetro GET 'editar' con valor 1, se muestra un formulario para editar el registro
     *   correspondiente.
     * - Si se ha proporcionado una solicitud POST con los datos del registro a editar, llama al método actualizarRegistro
     *   del modelo Grupo para realizar la actualización.
     * - Redirige al usuario a la página de información de registros del cliente si la actualización es exitosa.
     * - Muestra un mensaje de error en caso de fallo.
     *
     * @return void
     */
    public function editarRegistro()
    {
        // Verifica si hay un parámetro GET
        if (isset($_GET['editar']) && $_GET['editar'] == 1) {
            global $cliente;
            $cliente = $_GET['cliente'];
            require_once 'Vistas/paneles/Formularios/formularioRegistro.php';
        }

        // Verifica si hay una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once "Modelos/Grupo.php";
            $registro = new Grupo();
            $sentencia = $registro->actualizarRegistro($_POST);

            if ($sentencia) {
                header('Location: ?controller=Paneles&action=formularioRegistro&cliente='.$_POST['id_cliente']);
            } else {
                die("Error al ejecutar actualización");
            }
        }
    }

    /**
     * Realiza una búsqueda en la base de datos de clientes.
     *
     * - Verifica si se ha proporcionado un término de búsqueda en la solicitud POST.
     * - Llama al método Conseguir_Registro del modelo Titulares para realizar la búsqueda.
     * - Si se encontraron coincidencias, muestra un listado con los resultados en la vista busqueda.php.
     * - Si no se encontraron coincidencias, muestra un mensaje de error y redirige al usuario a la página principal.
     * - Si no se ha proporcionado un término de búsqueda, redirige al usuario a la página principal.
     *
     * @return void
     */
    public function buscar()
    {

        if (isset($_POST['busqueda'])) {
            require_once 'Modelos/Titulares.php';
            $DB = new Titulares();
            global $sentencia;
            $sentencia = $DB->Conseguir_Registro("WHERE nombre LIKE '%".$_POST['busqueda']."%' OR primer_apellido LIKE '%".$_POST['busqueda']."%' OR segundo_apellido LIKE '%".$_POST['busqueda']."%'");
            if ($sentencia->rowCount() != 0) {
                require_once 'Vistas/paneles/busqueda.php';
            } else {
                $_SESSION['flash'] = "No se encontraron coincidencias en la base de datos";
                require_once 'Vistas/paneles/principal.php';
            }

        } else {
            header('Location: ?controller=Paneles&action=index');
        }
    }

}
