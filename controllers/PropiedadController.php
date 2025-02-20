<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedores;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all(); // método estático se llama con ::
        $resultado = null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedores::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('propiedades/crear', [
           'propiedad' => $propiedad,
           'vendedores' => $vendedores
        ]);
    }

    public static function actualizar() {
        echo "actualizar propiedad";
    }

}