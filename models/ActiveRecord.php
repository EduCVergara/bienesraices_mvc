<?php

namespace Model;

class ActiveRecord {
    // BD
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];
    
    // Definición de la conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }
    
    public function guardar() {
        if (!is_null($this->id)) {
            // Actualizar
            $this->actualizar();
        } else {
            // Creamos un nuevo registro
            $this->crear();
        }
    }

    public function crear() {
        // Sanitizar datos
        $atributos = $this->sanitizarDatos();

        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";
        
        $resultado = self::$db->query($query);

        if ($resultado) {
            // Determinar el parámetro y valor correctos
            $parametro = $this instanceof Vendedores ? 'nombre' : 'titulo';
            $valor = $this instanceof Vendedores ? $this->nombre : $this->titulo;

            // Redireccionar al Usuario
            header("Location: /admin?resultado=1&$parametro=" . urlencode($valor));
        }
    }

    public function actualizar() {
        // Sanitizar datos
        $atributos = $this->sanitizarDatos();

        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET "; 
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= "LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado) {
            // Determinar el parámetro y valor correctos
            $parametro = $this instanceof Vendedores ? 'nombre' : 'titulo';
            $valor = $this instanceof Vendedores ? $this->nombre : $this->titulo;

            // Redireccionar al Usuario
            header("Location: /admin?resultado=2&$parametro=" . urlencode($valor));
        }
    }

    // Eliminar un registro
    public function eliminar() {
        // Eliminar elemento
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        try {
            $resultado = self::$db->query($query);
        } catch (\Throwable $th) {
            header('Location: /admin?resultado=4&nombre=' . urlencode($this->nombre));
            exit;
        }
        
        if ($resultado) {
            $this->borrarImagen();
            // Determinar el parámetro y valor correctos
            $parametro = $this instanceof Vendedores ? 'nombre' : 'titulo';
            $valor = $this instanceof Vendedores ? $this->nombre : $this->titulo;

            // Redireccionar al Usuario
            header("Location: /admin?resultado=3&$parametro=" . urlencode($valor));
            exit;
        }
    }

    // Identificar y unir atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            
            if ($columna === 'creado' && empty($this->$columna)) {
                $atributos[$columna] = date('Y-m-d');
            } else {
                $atributos[$columna] = $this->$columna ?? '';
            }
        }
        return $atributos;
    }

    public function sanitizarDatos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value ?? '');
        }

        return $sanitizado;
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }


    // Subida de archivo imagen
    public function setImagen($imagen) {

        // Elimina la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    public function borrarImagen() {
        if (property_exists($this, 'imagen') && !empty($this->imagen)) { 
            $rutaImagen = CARPETA_IMAGENES . $this->imagen;
    
            if (file_exists($rutaImagen) && is_file($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
    }

    // Lista todas los elementos de la tabla seleccionada
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtiene determinado número de registros
    public static function limite($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $limite;
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca una propiedad por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id={$id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado); // la función array_shift de php retorna el primer elemento de un arreglo
    }

    public static function consultarSQL($query) {
        // Consultar la BD
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        
        // Liberar la memoria
        $resultado->free();
        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sync($args = []) {
        foreach($args as $key=> $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                // Si es el precio, limpiamos el formato
                if ($key === 'precio') {
                    $value = str_replace(['$', '.', ' '], '', $value);
                }
                $this->$key = $value;
            }
        }
    }
}