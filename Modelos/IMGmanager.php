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
     * @return string Mensaje indicando el resultado de la operaci n.
     */
    public function borrarImagen(string $imagen): string
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

    /**
     * @param array{tmp_name: string, name: string} $image
     * @param string|null $nombre
     * @param string|null $rediret
     * @return string|null
     */
    public function uploadImage(array $image, ?string $nombre = null, ?string $rediret = null): ?string
    {
        // Validar la extensión del archivo
        // La variable $extensiones_permitidas contiene las extensiones de archivo permitidas
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        // La variable $extension contiene la extensión del archivo subido
        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        // Si la extensión no está en la lista de extensiones permitidas
        if (!in_array($extension, $extensiones_permitidas)) {
            // Redirigir al usuario a $rediret y terminar la función
            header("Location: $rediret");
            return null;
        } else {
            // Si el archivo tiene un nombre
            if ($nombre !== null) {
                // Crear un nombre aleatorio para el archivo
                $fecha = new DateTime();
                $imageName = $nombre . '_' . $fecha->getTimestamp();
                // Guardar el archivo temporal en una variable
                $imagenTemporal = $image['tmp_name'];
                // Intentar mover el archivo temporal a la ruta especificada
                $m = move_uploaded_file($imagenTemporal, $this->url_img . $imageName . '.' . $extension);
                // Si el archivo se ha movido con éxito
                if ($m) {
                    // Regresar el nombre del archivo guardado
                    return $imageName . '.' . $extension;
                }
                // Si no se ha podido mover el archivo
                return null;
            } else {
                // Si el archivo no tiene un nombre
                if ($image['name'] !== null && $image !== false) {
                    // Crear un nombre aleatorio para el archivo
                    $fecha = new DateTime();
                    $imageName = pathinfo($image['name'], PATHINFO_FILENAME) . '_' . $fecha->getTimestamp();
                    // Guardar el archivo temporal en una variable
                    $imagenTemporal = $image['tmp_name'];
                    // Intentar mover el archivo temporal a la ruta especificada
                    $m = move_uploaded_file($imagenTemporal, $this->url_img . $imageName . '.' . $extension);
                    // Si el archivo se ha movido con éxito
                    if ($m) {
                        // Regresar el nombre del archivo guardado
                        return $imageName . '.' . $extension;
                    }
                    // Si no se ha podido mover el archivo
                    return null;
                } else {
                    // Si el archivo no tiene nombre y no es un archivo válido
                    return null;
                }

            }
        }
    }
    /**
     * Consigue un registro de la tabla Img.
     *
     * @param string $condicion La condición de búsqueda para el registro.
     * @return PDOStatement La sentencia de selección ejecutada.
     * @throws Exception Si la tabla no existe.
     */
    public function ConseguirImg(string $condicion): PDOStatement
    {
        $tabla = "Img";
        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_name = :tabla";
        $sentencia = $this->DB->prepare($sql);
        $sentencia->execute([':tabla' => $tabla]);
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
