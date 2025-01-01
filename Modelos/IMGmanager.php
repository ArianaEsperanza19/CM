<?php
class IMGmanager {
    private $url_img;

    /**
     * Constructor de la clase IMGmanager.
     * 
     * @param string $url_img Ruta del directorio donde se almacenarán las imágenes.
     */
    public function __construct($url_img) {
        $this->url_img = $url_img;
    }

    /**
     * Borrar una imagen del directorio.
     * 
     * @param string $imagen Nombre del archivo de imagen a borrar.
     * @return string Mensaje indicando el resultado de la operación.
     */
    public function borrarImagen($imagen) {
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
     * Subir una imagen al directorio.
     * 
     * @param array $image Array que contiene información de la imagen a subir (como se obtiene de $_FILES en PHP).
     * @return string|null Nombre de la imagen subida o mensaje de error si la extensión no es permitida.
     */
    public function uploadImage($image) {
        // Validar la extensión del archivo
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensiones_permitidas)) {
            return "Solo se permiten archivos con extensión .jpg, .jpeg y .png";
        }

        if ($image['name'] !== NULL && $image !== false) {
            $fecha = new DateTime();
            $imageName = $image['name']. '_' . $fecha->getTimestamp() . '.' . $extension;
            $imagenTemporal = $image['tmp_name'];
            move_uploaded_file($imagenTemporal, $this->url_img . $imageName);
            return $imageName;
        } else {
            return NULL;
        }
    }
}
/*
// Ejemplo de uso
$imgManager = new IMGmanager("assets/img/");
$imagen = "nombre_de_la_imagen.jpg";

// Borrar imagen
$resultadoBorrar = $imgManager->borrarImagen($imagen);
echo $resultadoBorrar;

// Subir imagen
$image = $_FILES['imagen'];
$resultadoSubir = $imgManager->uploadImage($image);
echo $resultadoSubir;
*/