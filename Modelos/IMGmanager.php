<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir . '/CustomersManager/Config/DB.php';

class IMGmanager
{
    private $DB;
    private $url_img;

    /**
     * Constructor de la clase IMGmanager.
     *
     * @param string $url_img Ruta del directorio donde se almacenarán las imágenes.
     */
    public function __construct($url_img = "Vistas/img/")
    {
        $this->url_img = $url_img;
        $this->DB = DB::Connect();
    }

    /**
     * Borrar una imagen del directorio.
     *
     * @param string $imagen Nombre del archivo de imagen a borrar.
     * @return string Mensaje indicando el resultado de la operación.
     */
    public function borrarImagen($imagen)
    {
        // Verificar si la imagen existe en el directorio
        if (file_exists($this->url_img . $imagen)) {
            // Borrar la imagen
            if (unlink($this->url_img . $imagen)) {
                return "Imagen borrada exitosamente.";
            } else {
                return "Error al borrar la imagen.";
            }
        } else {
            return "La imagen no existe en el directorio.";
        }
    }


    /**
     * Subir una imagen al directorio especificado.
     *
     * @param array $image Información del archivo de imagen a subir, que incluye 'name' y 'tmp_name'.
     * @return string|null Nombre del archivo subido en caso de éxito, mensaje de error en caso de extensión no permitida, o NULL si el archivo no es válido.
     */

    public function uploadImage($image, $nombre = null, $rediret = null)
    {
        // Validar la extensión del archivo
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $extensiones_permitidas)) {
            header("Location: $rediret");
        } else {
            # Si el archivo tiene un nombre
            if ($nombre !== null) {
                $fecha = new DateTime();
                $imageName = $nombre . '_' . $fecha->getTimestamp();
                $imagenTemporal = $image['tmp_name'];
                $m = move_uploaded_file($imagenTemporal, $this->url_img . $imageName . '.' . $extension);
                if ($m) {
                    return $imageName . '.' . $extension;
                }
                return $m;
            } else {
                # Si el archivo no tiene un nombre
                if ($image['name'] !== null && $image !== false) {
                    $fecha = new DateTime();
                    $imageName = pathinfo($image['name'], PATHINFO_FILENAME) . '_' . $fecha->getTimestamp();
                    $imagenTemporal = $image['tmp_name'];
                    $m = move_uploaded_file($imagenTemporal, $this->url_img . $imageName . '.' . $extension);
                    if ($m) {
                        return $imageName . '.' . $extension;
                    }
                    return $m;
                } else {
                    return null;
                }

            }
        }
    }
    public function ConseguirImg($condicion)
    {
        /**
         * Consigue un registro de la tabla de Conyuges_Dependientes.
         *
         * @param string $condicion La condicion de busqueda para el registro.
         * @return PDOStatement La sentencia de selección ejecutada.
         * @throws Exception Si la tabla no existe.
         */
        $tabla = "Img";
        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$tabla'";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute();
        if ($sentencia->fetchColumn() == 0) {
            throw new Exception("La tabla $tabla no existe");
        } else {
            $sql = "SELECT * FROM $tabla $condicion";
            $sentencia = $this->DB->prepare($sql);
            $sentencia->execute();
        }
        return $sentencia;
    }
}
