<?php

namespace Model;

class Blog extends ActiveRecord {
    protected static $tabla = 'blog';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'descripcion', 'imagen', 'blogId'];

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
        $this->fecha = date('Y/m/d');
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->blogId = $args['blogId'] ?? '';
        
    }
    public function validar(){
        if (!$this->titulo) {
            self::$errores[] = "El titulo es obligatorio";
        } else if (strlen($this->titulo ) > 45) {
            self::$errores[] = "Título demasiado largo";
        }
        
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        } 
        if (!$this->descripcion) {
            self::$errores[] = "La descripción es obligatoria";
        } else if(strlen($this->descripcion) < 50) {        
            self::$errores[] = "La descripción debe ser mayor a 50 caracteres";
        }
        if (!$this->blogId) {
            self::$errores[] = "Eliger un titular";
        } 
        return self::$errores;
    }

}