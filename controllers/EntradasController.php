<?php

namespace Controllers;
use MVC\Router;
use Model\Entradas;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class EntradasController {

    public static function crear(Router $router) {

        $entrada = new Entradas;

        // Array con mensajes de errores
        $errores = Entradas::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entrada = new Entradas($_POST['entrada']);

            // Generar nombre único a imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['entrada']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);// $manager es la variable para intervention image (subir imágenes con POO instalada con Composer)
                $imagen = $manager->read($_FILES['entrada']['tmp_name']['imagen'])->cover(800, 600);
                $entrada->setImagen($nombreImagen);
            }
            
            $errores = $entrada->validar();
            if (empty($errores)) {

                // * SUBIDA DE ARCHIVOS *//
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en el servidor
                if (isset($imagen)) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $entrada->guardar();
            }
        }
        // Renderizar lo que va hacia la vista (de lo contrario arrojará errores lo que no está definido)
        $router->render('entradas/crear', [
           'entrada' => $entrada,
           'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        
        $id = ValidarORedireccionar('/admin');

        $entrada = Entradas::find($id);
        // Array con mensajes de errores
        $errores = Entradas::getErrores();

        // Ejecutar el código luego de que el usuario envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar los atributos
            $args = $_POST['entrada'];

            $entrada->sync($args);

            // Validación de campos
            $errores = $entrada->validar();

            // Genera un nombre único a la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if ($_FILES['entrada']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);// $manager es la variable para intervention image (subir imágenes con POO instalada con Composer)
                $imagen = $manager->read($_FILES['entrada']['tmp_name']['imagen'])->cover(800, 600);
                $entrada->setImagen($nombreImagen);
            }
            // Revisar que el arreglo de errores esté vacío
            if (empty($errores)) {
                // Almacenar la imagen
                if ($_FILES['entrada']['tmp_name']['imagen']){
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $entrada->guardar();
            }
        }

        $router->render('entradas/actualizar', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        // Eliminación de propiedades
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    
            if ($id) {
                $tipo = $_POST['tipo'];
    
                if (validarTipoContenido($tipo)) {
                    // Compara lo que vamos a eliminar
                    if ($tipo === 'entrada' ) {
                        $entrada = Entradas::find($id);
                        $entrada->eliminar();
                    }
                }
            }
        }
    }
}