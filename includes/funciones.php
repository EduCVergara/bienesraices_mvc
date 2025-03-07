<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function Autenticado() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /login.php');
    }
}

function ValidarORedireccionar(string $url) {
    // Validacion de Id válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: $url");
    }

    return $id;
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitiza el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad', 'entrada'];

    return in_array($tipo, $tipos);
}

function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        case 4:
            $mensaje = 'No se puede eliminar un Vendedor con una Propiedad asociada';
            break;
        
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}