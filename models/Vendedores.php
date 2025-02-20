<?php

namespace App;

class Vendedores extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = "El(La) vendedor(a) debe tener un <strong>nombre</strong>";
        }

        if(!$this->apellido) {
            self::$errores[] = "El(La) vendedor(a) debe tener un <strong>apellido</strong>";
        }

        if(!$this->telefono) {
            self::$errores[] = "El(La) vendedor(a) debe tener un <strong>teléfono</strong>";
            } elseif(!preg_match('/[0-9]{8,9}/', $this->telefono)) {
                self::$errores[] = "El(La) vendedor(a) debe tener un <strong>teléfono</strong> con formato válido";
            }

        return self::$errores;
    }
}