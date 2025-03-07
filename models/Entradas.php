<?php

namespace Model;

class Entradas extends ActiveRecord {

    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'fecha', 'contenido'];

    public $id;
    public $titulo;
    public $imagen;
    public $fecha;
    public $contenido;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
    }

    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "La entrada debe tener un <strong>título</strong>";
        }
        
        if(!$this->imagen) {
            self::$errores[] = "La entrada debe contener una <strong>imagen</strong>";
        }

        if(!$this->fecha) {
            self::$errores[] = "La entrada debe tener una <strong>fecha</strong>";
        }

        if(strlen($this->contenido) < 50) {
            self::$errores[] = "La entrada debe tener un <strong>contenido</strong>, y debe tener al menos 50 caracteres";
        }

        return self::$errores;
    }

}