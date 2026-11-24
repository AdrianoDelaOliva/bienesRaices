<?php

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';

    protected static $columnasDB = [
        'id',
        'titulo',
        'precio',
        'imagen',
        'descripcion',
        'habitaciones',
        'wc',
        'estacionamiento',
        'creado',
        'vendedorId'
    ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar() {

        static::$errores = [];

        if (!$this->titulo) {
            static::$errores[] = "Debes añadir un título";
        }

        if (!is_numeric($this->precio) || $this->precio <= 0) {
            static::$errores[] = "El precio debe ser mayor a cero";
        }

        if (strlen($this->descripcion) < 50) {
            static::$errores[] = "La descripción debe tener al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            static::$errores[] = "El número de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            static::$errores[] = "El número de baños es obligatorio";
        }

        if ($this->estacionamiento === '' ||
            !is_numeric($this->estacionamiento) ||
            $this->estacionamiento < 0) {

            static::$errores[] = "El número de estacionamientos es obligatorio";
        }

        if (!$this->vendedorId) {
            static::$errores[] = "Elige un vendedor";
        }

        if (!$this->imagen) {
            static::$errores[] = "La imagen de la propiedad es obligatoria";
        }

        return static::$errores;
    }
}
