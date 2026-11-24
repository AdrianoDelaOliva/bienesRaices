<?php

namespace Model;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';

    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'telefono'
    ];

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

        static::$errores = [];

        if (!$this->nombre) {
            static::$errores[] = "El nombre es obligatorio";
        }

        if (!$this->apellido) {
            static::$errores[] = "El apellido es obligatorio";
        }

        if (!$this->telefono) {
            static::$errores[] = "El teléfono es obligatorio";
        } else if (!preg_match('/^[0-9]{9}$/', $this->telefono)) {
            static::$errores[] = "El teléfono no es válido";
        }

        return static::$errores;
    }
}
