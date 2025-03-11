<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedores;
use Model\Entradas;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all(); // método estático se llama con ::
        $vendedores = Vendedores::all();
        $entradas = Entradas::all();
        
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'entradas' => $entradas,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedores::all();

        // Array con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $propiedad = new Propiedad($_POST['propiedad']);

            // Validamos que la imagen no supere los 8mb
            if ($_FILES['propiedad']['tmp_name']['imagen'] && $_FILES['propiedad']['size']['imagen'] > 8 * 1024 * 1024) {
                $errores[] = 'La imagen no debe superar los 8MB.';
            }

            // Generamos nombre único a la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);// $manager es la variable para intervention image (subir imágenes con POO instalada con Composer)
                $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);    
            }

            // Asignamos el precio correcto enviado por POST (sin formato para la BBDD)
            $propiedad->precio = $_POST['precio'];
            $errores = $propiedad->validar();

            if (empty($errores)) {

                // * SUBIDA DE ARCHIVOS *//
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en el servidor
                if (isset($imagen)) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }
        }
        // Renderizar lo que va hacia la vista (de lo contrario arrojará errores lo que no está definido)
        $router->render('propiedades/crear', [
           'propiedad' => $propiedad,
           'vendedores' => $vendedores,
           'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        
        $id = ValidarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedores::all();
        // Array con mensajes de errores
        $errores = Propiedad::getErrores();

        // Ejecutar el código luego de que el usuario envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sync($args);

            // Verificar tamaño de la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen'] && $_FILES['propiedad']['size']['imagen'] > 8 * 1024 * 1024) {
                $errores[] = 'La imagen no debe superar los 8MB.';
                debuguear($errores);
            }

            // Validación de campos
            $errores = $propiedad->validar();

            // Genera un nombre único a la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);// $manager es la variable para intervention image (subir imágenes con POO instalada con Composer)
                $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            // Revisar que el arreglo de errores esté vacío
            if (empty($errores)) {
                // Almacenar la imagen
                if ($_FILES['propiedad']['tmp_name']['imagen']){
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    if ($tipo === 'propiedad' ) {
                        $propiedad = Propiedad::find($id);
                        $propiedad->eliminar();
                    }
                }
            }
        }
    }
}