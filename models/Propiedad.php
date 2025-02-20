<?php

namespace App;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "La propiedad debe tener un <strong>título</strong>";
        }

        if(!$this->precio) {
            self::$errores[] = "La propiedad debe tener un <strong>precio</strong>";
        }

        if(strlen($this->descripcion) < 50) {
            self::$errores[] = "La propiedad debe tener una <strong>descripcion</strong>, y debe tener al menos 50 caracteres para más posibilidades de venta";
        }

        if(!$this->habitaciones) {
            self::$errores[] = "La propiedad debe tener <strong>habitaciones</strong>";
        }

        if(!$this->wc) {
            self::$errores[] = "La propiedad debe especificar cuantos <strong>baños</strong> tiene";
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "La propiedad debe especificar cuantos <strong>estacionamientos</strong> tiene";
        }

        if(!$this->vendedores_id) {
            self::$errores[] = "Debes elegir un  <strong>vendedor</strong>";
        }

        if(!$this->imagen) {
            self::$errores[] = "La propiedad debe contener una <strong>imagen</strong>";
        }

        return self::$errores;
    }

}