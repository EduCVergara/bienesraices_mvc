<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;

$router = new Router();

$router->get('/admin', 'funcion_admin');
$router->get('/propiedades/crear', 'funcion_crear');
$router->get('/propiedades/actualizar', 'funcion_actualizar');

$router->comprobarRutas();  