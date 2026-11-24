<?php

namespace Model;

class Blog extends ActiveRecord {

    protected static $tabla = 'blog';

    protected static $columnasDB = [
        'id',
        'titulo',
        'fecha',
        'descripcion',
        'imagen',
        'blogId'
    ];

    public $id;
    public $titulo;
    public $fecha;
    public $descripcion;
    public $imagen;
    public $blogId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y-m-d');
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->blogId = $args['blogId'] ?? '';
    }

    public function validar() {

        static::$errores = [];

        if (!$this->titulo) {
            static::$errores[] = "El título es obligatorio";
        } else if (strlen($this->titulo) > 45) {
            static::$errores[] = "Título demasiado largo";
        }

        if (!$this->imagen) {
            static::$errores[] = "La imagen es obligatoria";
        }

        if (!$this->descripcion) {
            static::$errores[] = "La descripción es obligatoria";
        } else if (strlen($this->descripcion) < 50) {
            static::$errores[] = "La descripción debe tener al menos 50 caracteres";
        }

        if (!$this->blogId) {
            static::$errores[] = "Elige un titular";
        }

        return static::$errores;
    }
}
