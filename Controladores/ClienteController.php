<?php
require_once 'Modelos/DatosManager.php';

class ClienteController
{
    public function VerTodos() {
    }
    public function VerUno() {
    }
    public function Crear() {
        //echo "Soy el formulario para un nuevo cliente";
        if(isset($_POST)) {

            $datos = new DatosManager(tabla : 'Titulares');
            $sentencia = $datos->Registrar($_POST);
            $cliente_id = $datos->Ultimo_Registro();
            $cliente_id = $cliente_id['id_cliente'];
            if($sentencia){

            if($_POST['matrimonio'] == 1 && $_POST['dependientes'] == 0){
                header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id&depende=0");
                //die('detenido en matrimonio 1 y dependientes 0');
            }
            if($_POST['dependientes'] == 1 && $_POST['matrimonio'] == 1){
                header("Location: ?controller=Paneles&action=formularioConyugal"."&id_cliente=$cliente_id&depende=1");
                //die('detenido en dependientes 1 y matrimonio 1');
            }
            if($_POST['dependientes'] == 1 && $_POST['matrimonio'] == 0){
                header("Location: ?controller=Paneles&action=formularioDepende"."&id_cliente=$cliente_id&depende=1");
                //die('detenido en dependientes 1 y matrimonio 0');
            }
            if($_POST['matrimonio'] == 0 && $_POST['dependientes'] == 0){
                header('Location: ?controller=Paneles&action=principal');
            }
            }else{
                header('Location: ?controller=Paneles&action=principal');
            }}
    }
    public function Agregar_Conyugue() {
        # Verificar si se puede usar sin datosmanager
        if(isset($_POST)) {
        if($_GET['id_cliente']){
            $id_cliente = $_GET['id_cliente'];
        }
        $DB = new DatosManager(tabla: 'Conyugues_Dependientes');
        require_once 'Modelos/Grupo.php';
        $registro = new Grupo($DB);
        $registro->registrar($_POST, $id_cliente);
        if($_GET['depende'] == 1){

            header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
        }
        if($_GET['depende'] == 0){
            header("Location: ?controller=Paneles&action=info&cliente=$id_cliente");
        }

    }}

    public function Agregar_Depende(){
        if(isset($_POST)){ {
        if($_GET['id_cliente']){
            $id_cliente = $_GET['id_cliente'];
        }
        require_once 'Modelos/Grupo.php';
        $registro = new Grupo();
        $registro->registrar($_POST, $id_cliente);
        header('Location: ?controller=Paneles&action=formularioDepende'."&id_cliente=$id_cliente");
    }}}
    public function Editar() {
        if(isset($_POST)){
            if(isset($_GET['cliente'])){
            $id = $_GET['cliente'];
            if(isset($_GET['conyugue']) == 1 || isset($_GET['depende']) == 1){
                # Editar conyugue o dependiente
                require_once 'Modelos/Grupo.php';
                $registro = new Grupo();
                $sentencia = $registro->editar($_POST,$id);
                $titular = $registro->info_titular($id);
                if($sentencia && $titular){
                # El token es necesario para impedir que el usuario pueda retroceder al formulario
                $token = md5(uniqid());
                header("Location: ?controller=Paneles&action=info&cliente=$titular&token=$token");
                }

            }else{
            # Editar titular
            require_once 'Modelos/DatosManager.php';
            $DB = new DatosManager(tabla: 'Titulares');
            $sentencia = $DB->Editar($_POST, $id);
            $token = md5(uniqid());
            if($sentencia){
        header("Location: ?controller=Paneles&action=info&cliente=$id&token=$token");
            }else{
                # ERROR
                echo "Error al editar";
            }
            }
            //header('Location: ?controller=Paneles&action=principal');
        }
    }}
    public function Eliminar() {
        if(isset($_GET['cliente'])){
        $titular = $_GET['titular'];
        $id = $_GET['cliente'];
        require_once 'Modelos/Grupo.php';
        if(isset($_GET['depende']) == 1){
            $grupo = new Grupo();
            $sentecia = $grupo->eliminar_uno($id);
            if($sentecia){
                header("Location: ?controller=Paneles&action=info&cliente=$titular");
            }else{
                die("Error al eliminar");
            }
        }
        if(isset($_GET['conyugue']) == 1){
            $grupo = new Grupo();
            $sentecia = $grupo->eliminar_uno($id);
            if($sentecia){
                header('Location: ?controller=Paneles&action=info&cliente='.$titular);
            }else{
                die("Error al eliminar");
            }
        }
        $registro = new Grupo();
        $sentencia = $registro->eliminar_todos($_GET['cliente']);
        if($sentencia){
            header('Location: ?controller=Paneles&action=principal');
        }else{
            echo "Error al eliminar";
        }
    }

    }
    public function registrar_editar_seguro(){
        if(isset($_POST)){
        $id = $_GET['cliente'];
        require_once 'Modelos/Seguros.php';
        $registro = new Seguros();
        # Editar
        if(isset($_GET['editar']) && $_GET['editar'] == 1){
        $sentencia = $registro->actualizar($_POST, $id);
        if($sentencia){
            # Centinela que vigila si se ha editado la informacion
            $_SESSION['editar'] = true;
            header('Location: ?controller=Paneles&action=InfoSeguros&cliente='.$id);
        }else{
            echo "Error al actualizar";
        }
        }else{
        $sentencia = $registro->registrar($_POST, $id);
        if($sentencia){
            header('Location: ?controller=Paneles&action=InfoSeguros&cliente='.$id);
        }else{
            echo "Error al registrar";
        }
        }

    }}
    public function registrar_editar_banco(){
        if(isset($_POST)){
        $id = $_GET['cliente'];
        require_once 'Modelos/Cuentas.php';
        $registro = new Cuentas();
        # Editar
        if(isset($_GET['editar']) && $_GET['editar'] == 1){
        $sentencia = $registro->actualizar($_POST, $id);
        if($sentencia){
            # Centinela que vigila si se ha editado la informacion
            $_SESSION['editar'] = true;
            header('Location: ?controller=Paneles&action=InfoBanco&cliente='.$id);
        }else{
            echo "Error al actualizar";
        }
        }else{
        $sentencia = $registro->registrar($_POST, $id);
        if($sentencia){
            header('Location: ?controller=Paneles&action=InfoBanco&cliente='.$id);
        }
        }}}

    public function eliminar_seguro(){
            if(isset($_GET)){
            $id = $_GET['cliente'];
            require_once 'Modelos/Seguros.php';
            $registro = new Seguros();
            $sentencia = $registro->eliminar($id);
            if($sentencia){
                header('Location: ?controller=Paneles&action=info&cliente='.$id);
            }else{
                echo "Error al eliminar";
            }
        }}

    public function eliminar_banco(){
            if(isset($_GET)){
            $id = $_GET['cliente'];
            require_once 'Modelos/Cuentas.php';
            $registro = new Cuentas();
            $sentencia = $registro->eliminar($id);
            if($sentencia){
                header('Location: ?controller=Paneles&action=info&cliente='.$id);
            }else{
                echo "Error al eliminar";
            }
    }}

    public function agregarImg() {
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
        if($sentencia){
            header('Location: ?controller=Paneles&action=pagina_img&cliente='.$_POST['id'].'&add=0');
        }
    } else {
        echo "Error al subir la imagen.";
    }
}

    }
    public function eliminarImg() {
        if(isset($_GET)){
        $id = isset($_GET['img']) ? $_GET['img'] : null;
        $cliente = isset($_GET['cliente']) ? $_GET['cliente'] : null;
        if($id){
        require_once 'Modelos/DatosManager.php';
        $DB = new DatosManager(tabla: 'Img', id: $id);
        $consulta = $DB->Conseguir_Registro("WHERE id_img = $id");
        $consulta = $consulta->fetch();
        $nombre = $consulta['imagen'];
        require_once 'Modelos/IMGmanager.php';
        $img = new IMGmanager("Vistas/img/");
        $img->borrarImagen($nombre);
        $sentencia = $DB->Eliminar();
        if($sentencia){
            header('Location: ?controller=Paneles&action=pagina_img&cliente='.$cliente.'&add=0');

        }else{
echo "Error al eliminar";
}
}

    }}

    public function editarImg() {
        if(isset($_POST) && isset($_FILES)){
        $cliente = $_POST['id'];
        $id_img = $_POST['id_img'];
        $nombre = $_POST['nombre'];
        $centinela = $_FILES['imagen']['name'];
        # Si no hay una nueva imagen
        if($centinela == ""){
            $_SESSION['flash'] = "No se ha subido ninguna imagen!";
            header ('Location: ?controller=Paneles&action=pagina_img&cliente='.$_POST['id'].'&add=0');
            // header('Location: ?controller=Paneles&action=info&cliente='.$_POST['id']);
}else{

        require_once 'Modelos/DatosManager.php';
        $DB = new DatosManager(tabla: 'Img');
        $sentencia = $DB->Conseguir_Registro("WHERE id_cliente = '$cliente' AND id_img = '$id_img'");
        if($sentencia){
            $sentencia = $sentencia->fetch();
            require_once 'Modelos/IMGmanager.php';
            $rediret = "?controller=Paneles&action=info&cliente=".$_POST['id'];
            $img = new IMGmanager("Vistas/img/");
            $img->borrarImagen($sentencia['imagen']);
            $imagen = $img->uploadImage($_FILES['imagen'], $nombre, $rediret);
            require_once 'Modelos/Grupo.php';
            $DB = new Grupo();
            $actualizar = $DB->actualizar_img($_POST, $imagen, $centinela);
            if($actualizar){
            header ('Location: ?controller=Paneles&action=pagina_img&cliente='.$_POST['id'].'&add=0');
            }
            }else{ echo "error";}
            echo "error";}}}

    public function agregarRegistro() {
        if(isset($_POST)){
            require_once 'Modelos/Grupo.php';
            $registro = new Grupo();
$sentencia = $registro->guardarRegistro($_POST);
            if($sentencia){
                header('Location: ?controller=Paneles&action=formularioRegistro&cliente='.$_POST['id_cliente']);
            }
        }
    }

    public function eliminarRegistro() {
        if(isset($_GET)){
            require_once 'Modelos/Grupo.php';
            $registro = new Grupo();
            $sentencia = $registro->eliminarRegistro($_GET['cliente']);
            if($sentencia){
                header('Location: ?controller=Paneles&action=info&cliente='.$_GET['cliente']);
            }
        }
    }
public function editarRegistro() {
    // Verifica si hay un parámetro GET
    if(isset($_GET['editar']) && $_GET['editar'] == 1){
        global $cliente;
        $cliente = $_GET['cliente'];
        require_once 'Vistas/paneles/Formularios/formularioRegistro.php';
    }

    // Verifica si hay una solicitud POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once "Modelos/Grupo.php";
        $registro = new Grupo();
        $sentencia = $registro->actualizarRegistro($_POST);

        if($sentencia){
            header('Location: ?controller=Paneles&action=formularioRegistro&cliente='.$_POST['id_cliente']);
        } else {
            die("Error al ejecutar actualización");
        }
    }
}


    public function buscar() {

        if(isset($_POST['busqueda'])) {
            require_once 'Modelos/DatosManager.php';
            $DB = new DatosManager(tabla: 'Titulares');
            global $sentencia;
            $sentencia = $DB->Conseguir_Registro("WHERE nombre LIKE '%".$_POST['busqueda']."%' OR primer_apellido LIKE '%".$_POST['busqueda']."%' OR segundo_apellido LIKE '%".$_POST['busqueda']."%'");
            if($sentencia->rowCount() != 0){
            require_once 'Vistas/paneles/busqueda.php';
            }else{
            $_SESSION['flash'] = "No se encontraron coincidencias en la base de datos";
            require_once 'Vistas/paneles/principal.php';
            }

        }else{
            header('Location: ?controller=Paneles&action=principal');
        }
    }

}
