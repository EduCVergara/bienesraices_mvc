<?php

namespace Model;

class Admin extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';

    }

    public function validar() {
        
        if(!$this->email) {
            self::$errores[] = "El <strong>E-Mail</strong> es obligatorio";
        }

        if(!$this->password) {
            self::$errores[] = "El <strong>password</strong> o <strong>contraseña</strong>, es obligatorio(a)";
        }
        
        return self::$errores;
    }

    public function existeUsuario() {
        // Revisar si existe el usuario o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if (!$resultado->num_rows) {
            self::$errores[] = "El Usuario no existe";
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object(); // Obtenemos el objeto de la base de datos

        $autenticado = password_verify($this->password, $usuario->password);

        if (!$autenticado) {
            self::$errores[] = "El Password es incorrecto";
        }

        return $autenticado;
    }

    public function autenticar() {
        session_start();

        // Llenar arreglo de sesión
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}