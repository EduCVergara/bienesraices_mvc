<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedores;

class VendedorController {

    public static function crear(Router $router) {

        $vendedor = new Vendedores;
        // Array con mensajes de errores
        $errores = Vendedores::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Creamos una nueva instancia del objeto "vendedor"
            $vendedor = new Vendedores($_POST['vendedor']);
        
            // Validar que no haya campos vacíos
            $errores = $vendedor->validar();
        
            // Si no hay $errores (no estén vacíos los campos)
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }
        // Renderizar lo que va hacia la vista (de lo contrario arrojará errores lo que no está definido)
        $router->render('vendedores/crear', [
           'vendedor' => $vendedor,
           'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        
        $id = ValidarORedireccionar('/admin');

        $vendedor = Vendedores::find($id);
        // Array con mensajes de errores
        $errores = Vendedores::getErrores();

        // Ejecutar el código luego de que el usuario envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar los valores actualizados por el usuario
            $args = $_POST['vendedor'];
            // Sincronizar objeto en memoria con lo que el usuario escribió
            $vendedor->sync($args);
            // Validación
            $errores = $vendedor->validar();
        
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        // Eliminación de vendedores
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if ($id) {
    
                $tipo = $_POST['tipo'];
    
                if (validarTipoContenido($tipo)) {
                    // Compara lo que vamos a eliminar
                    if ($tipo === 'vendedor' ) {
                        $vendedor = Vendedores::find($id);
                        $vendedor->eliminar();
                    }
                }
            }
        }
    }
}