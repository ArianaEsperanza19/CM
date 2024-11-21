<?php
session_start();
#require_once '../Config.php';

class Auth
{
    protected $id;
    protected $errores = [
        'mayusculas' => "Debe contener mayusculas.",
        'minusculas' => 'Debe contener minusculas.',
        'numeros' =>  'Debe contener numeros.',
        'caracteres_si' => 'Debe contener caracteres especiales.',
        'caracteres_no' => 'No debe contener caracteres especiales.',
        'espacios' => 'No debe contener espacios.',
        'longitud' => 'Debe contener entre 8 y 16 caracteres.',
        'vacio' => 'No debe estar vacio.'
    ];
    public function __construct($id = null)
    {
        $this->id = $id;
    }
    public function Autenticar_Registro_Contrasenna($datos)
    {   
    /**
     * Verifica si una contrasenna cumple con los requisitos de tener
     * entre 8 y 16 caracteres, mayusculas, minusculas, numeros y caracteres
     * especiales, y no contener espacios.
     *
     * @param string $datos La contrasenna a verificar
     * @return bool|array Si la contrasenna cumple con los requisitos, devuelve true.
     *                    Si no, devuelve un arreglo con los errores encontrados.
     */
        $errores = $this->errores;
        $mayusculas = $this->Mayusculas($datos);
        $minusculas = $this->Minusculas($datos);
        $numeros = $this->Numeros($datos);
        $caracteres = $this->Caracteres_especiales($datos);
        $espacios = $this->Espacios($datos);
        $longitud = $this->Longitud($datos);
        if ($mayusculas && $minusculas && $numeros && $caracteres && $espacios && $longitud) {
            return true;
        } else {
            $mensaje = array();
            if (strlen($datos) == 0) {
                array_push($mensaje, $errores['vacio']);
            } else {

                if (!$mayusculas) {
                    array_push($mensaje, $errores['mayusculas']);
                }
                if (!$minusculas) {
                    array_push($mensaje, $errores['minusculas']);
                }
                if (!$numeros) {
                    array_push($mensaje, $errores['numeros']);
                }
                if (!$caracteres) {
                    array_push($mensaje, $errores['caracteres_si']);
                }
                if (!$espacios) {
                    array_push($mensaje, $errores['espacios']);
                }
                if (!$longitud) {
                    array_push($mensaje, $errores['longitud']);
                }
            $mensaje = $this->Formatear_mensaje($mensaje);
            return $mensaje;
            }
        }
    }
    public function Nombre_Apellido($datos){
    /**
     * Verifica si una cadena cumple con los requisitos de tener solo letras y no tenga espacios.
     *
     * @param string $datos La cadena a verificar
     * @return bool Si la cadena cumple con los requisitos, devuelve true.
     *               Si no, devuelve false.
     */
        $numeros = $this->Numeros($datos);
        $caracteres = $this->Caracteres_especiales($datos);
        $espacios = $this->Espacios($datos);
        if(!$numeros && !$caracteres && $espacios){
            return true;
        }else{
            return false;
        }
    }
    public function Email($datos){
        if(filter_var($datos, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }
    public function Autenticar_Sesion()
    {   
    /**
     * Autentica una sesion de usuario. Verifica que exista el usuario y su contrasenna.
     * Si el usuario existe, inicia sesion y devuelve "Autenticado".
     * Si el usuario no existe, devuelve "Usuario no encontrado.".
     * Si ya hay un usuario activo, devuelve "Ya hay un usuario activo.".
     * @return string Mensaje de resultado de la autenticacion.
     */
        if ($_SESSION['user'] == false) {
            require_once "./DatosManager.php";
            $DB = new DatosManager(tabla: 'users');
            $id = $this->id;
            $datos = $DB->Conseguir_Registro("WHERE id = $id");
            if ($datos) {
                $this->Iniciar_sesion();
                require_once "./Admin.php";
                $admin = new Admin(id: $id, tabla: 'users');
                $admin->Iniciar_sesion();
                return "Autenticado";
            } else {
                return "Usuario no encontrado.";
            }
        } else {
            return "Ya hay un usuario activo.";
        }
    }
    public function Iniciar_sesion()
    {
    /**
     * Inicia la sesion del usuario.
     * Si el usuario no tiene sesion activa, se establece la variable de sesion 'user' con el id del usuario.
     * Si el usuario ya tiene sesion activa, no se hace nada.
     */
        //Nota, Aun no verifica si el usuario es administrador.
        if ($_SESSION['user'] == false) {
            $_SESSION['user'] = $this->id;
        }
    }
    public function Cerrar_Sesion()
    {
    /**
     * Cierra la sesion del usuario.
     * Si el usuario tiene sesion activa, se establece la variable de sesion 'user' en false.
     * Si el usuario no tiene sesion activa, se devuelve "No hay usuario".
     * @return string Mensaje de resultado de la operacion.
     */
        if ($_SESSION['user'] != false) {
            $_SESSION['user'] = false;
        } else {
            return "No hay usuario";
        }
    }
    public function Sesion_activa()
    {
    /**
     * Verifica si hay una sesion activa.
     * Si hay una sesion activa, devuelve el id del usuario.
     * Si no hay sesion activa, devuelve false.
     * @return int|bool id del usuario o false si no hay sesion activa.
     */
        if (is_numeric($_SESSION['user']) && $_SESSION['user'] != false) {
            return $_SESSION['user'];
        } else {
            return false;
        }
    }
    public function Minusculas($palabra)
    {
    /**
     * Verifica si una cadena tiene al menos una minuscula.
     * @param string $palabra La cadena a verificar.
     * @return bool True si la cadena tiene al menos una minuscula, false de lo contrario.
     */
        $patron = "/[a-z]/";
        if (preg_match($patron, $palabra)) {
            return true;
        } else {
            return false;
        }
    }
    public function Mayusculas($palabra)
    {
    /**
     * Verifica si una cadena tiene al menos una mayuscula.
     * @param string $palabra La cadena a verificar.
     * @return bool True si la cadena tiene al menos una mayuscula, false de lo contrario.
     */
        $patron = "/[A-Z]/";
        if (preg_match($patron, $palabra)) {
            return true;
        } else {
            return false;
        }
    }
    public function Numeros($palabra)
    {
    /**
     * Verifica si una cadena contiene al menos un numero.
     * @param string $palabra La cadena a verificar.
     * @return bool True si la cadena contiene al menos un numero, false de lo contrario.
     */
        $patron = "/[0-9]/";
        if (preg_match($patron, $palabra)) {
            return true;
        } else {
            return false;
        }
    }
    public function Caracteres_especiales($palabra)
    {
    /**
     * Verifica si una cadena contiene al menos un caracter especial.
     * @param string $palabra La cadena a verificar.
     * @return bool True si la cadena contiene al menos un caracter especial, false de lo contrario.
     */
        $patron = "/[^a-zA-Z0-9]/";
        if (preg_match($patron, $palabra)) {
            return true;
        } else {
            return false;
        }
    }
    public function Espacios($palabra)
    {
    /**
     * Verifica si una cadena contiene espacios.
     * @param string $palabra La cadena a verificar.
     * @return bool True si la cadena no contiene espacios, false de lo contrario.
     */
        $patron = "/\s/";
        if (preg_match($patron, $palabra)) {
            return false;
        } else {
            return true;
        }
    }
    public function Longitud($palabra)
    {
    /**
     * Verifica si una cadena tiene entre 8 y 16 caracteres.
     * @param string $palabra La cadena a verificar.
     * @return bool True si la cadena tiene entre 8 y 16 caracteres, false de lo contrario.
     */
        if (strlen($palabra) >= 8 && strlen($palabra) < 16) {
            return true;
        } else {
            return false;
        }
    }
    public function Formatear_mensaje($mensaje){
    /**
     * Formatea un arreglo de errores para ser mostrados en una pagina web.
     * @param array $mensaje El arreglo de errores a formatear.
     * @return string El arreglo formateado como una lista HTML.
     */
        $mensaje_formateado = '';
        foreach($mensaje as $linea){
            $echo = "<li>".$linea."</li>";
            $mensaje_formateado = sprintf('%s %s', $mensaje_formateado, $echo);
        }
        $mensaje_formateado = "<ul style='color:red;'>" . $mensaje_formateado . "</ul>";
        return $mensaje_formateado;
    }
}

//$auth = new Auth(id: 1);
//$datos = $auth->Autenticar_Registro_Contrasenna('1as@daLlll');
//$datos = $auth->Nombre_Apellido("asda");
//var_dump($datos);
