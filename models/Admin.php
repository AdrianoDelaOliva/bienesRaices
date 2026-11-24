<?php

namespace Model;

use PDO;

class Admin extends ActiveRecord {

    protected static $tabla = 'usuarios';

    protected static $columnasDB = [
        'id',
        'email',
        'password'
    ];

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

        static::$errores = [];

        if (!$this->email) {
            static::$errores[] = "Ingrese su email";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            static::$errores[] = "El correo no es válido";
        }

        if (!$this->password) {
            static::$errores[] = "La contraseña es obligatoria";
        }

        return static::$errores;
    }

    public function existeUsuario() {

        $query = "SELECT * FROM " . static::$tabla;
        $query .= " WHERE email = :email LIMIT 1";

        $stmt = self::$db->prepare($query);

        $stmt->execute([
            'email' => $this->email
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$usuario) {
            static::$errores[] = "El usuario no existe";
            return false;
        }

        return $usuario;
    }

    public function comprobarPassword($resultado) {

        if (!$resultado || !isset($resultado->password)) {
            return false;
        }

        $autenticado = password_verify(
            $this->password,
            $resultado->password
        );

        if (!$autenticado) {
            static::$errores[] = "La contraseña es incorrecta";
            return false;
        }

        return true;
    }

    public function autenticar() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
        exit;
    }
}
