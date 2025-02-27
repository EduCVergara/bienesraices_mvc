<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::limite(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros (Router $router) {
        $router->render('paginas/nosotros');
    }
    public static function anuncios (Router $router) {

        $propiedades = Propiedad::limite(12);

        $router->render('paginas/anuncios', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad (Router $router) {
        echo "desde propiedad";
    }
    public static function blog (Router $router) {
        $router->render('paginas/blog', [

        ]);
    }
    public static function entrada (Router $router) {
        echo "desde entrada";
    }
    public static function contacto (Router $router) {
        $router->render('paginas/contacto', [

        ]);
    }
}