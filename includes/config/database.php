<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');
    $db -> set_charset('utf8');

    try {
        if (!$db) {
            echo "Ha ocurrido un error al conectar a la Base de Datos";
            exit;
        }

        return $db;
    } catch (\Throwable $th) {
        echo "Error al conectar a la Base de Datos: {$th}";
    }
}