<?php

namespace Model;

use PDO;

class ActiveRecord {

    // Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    // Definir la conexión a DB
    public static function setDB($database) {
        self::$db = $database;
    }

    public function guardar() {
        if (!is_null($this->id)) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }

    // Crear registro
    public function crear() {

        $atributos = $this->atributos();

        $columnas = array_keys($atributos);

        $parametros = array_map(function($columna) {
            return ':' . $columna;
        }, $columnas);

        $query = "INSERT INTO " . static::$tabla;
        $columnasSQL = array_map(function($columna) {
            return '"' . $columna . '"';
        }, $columnas);
        $query .= " (" . implode(', ', $columnasSQL) . ")";
        $query .= " VALUES (" . implode(', ', $parametros) . ")";
        $query .= " RETURNING id";

        $stmt = self::$db->prepare($query);

        $resultado = $stmt->execute($atributos);

        if ($resultado) {
            $this->id = $stmt->fetchColumn();
            $stmt->closeCursor();

            header('Location: /admin?resultado=1');
        }

        return $resultado;
    }

    // Actualizar registro
    public function actualizar() {

        $atributos = $this->atributos();

        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "\"{$key}\" = :{$key}";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= implode(', ', $valores);
        $query .= " WHERE id = :id";

        $atributos['id'] = $this->id;

        $stmt = self::$db->prepare($query);

        $resultado = $stmt->execute($atributos);

        if ($resultado) {
            header('Location: /admin?resultado=2');
        }

        return $resultado;
    }

    // Eliminar registro
    public function eliminar() {

        $query = "DELETE FROM " . static::$tabla;
        $query .= " WHERE id = :id";

        $stmt = self::$db->prepare($query);

        $resultado = $stmt->execute([
            'id' => $this->id
        ]);

        if ($resultado && $stmt->rowCount() > 0) {
            $this->borrarImagen();

            header('Location: /admin?resultado=3');
        }

        return $resultado;
    }

    // Identificar los atributos de la DB
    public function atributos() {

        $atributos = [];

        foreach (static::$columnasDB as $columna) {

            if ($columna === 'id') continue;

            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    // Compatibilidad con los modelos existentes
    public function sanitizarAtributos() {
        return $this->atributos();
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];

        return static::$errores;
    }

    // Asignar imagen
    public function setImagen($imagen) {

        if ($imagen) {

            if (!is_null($this->id) && !empty($this->imagen)) {
                $this->borrarImagen();
            }

            $this->imagen = $imagen;
        }
    }

    // Eliminar imagen
    public function borrarImagen() {

        if (empty($this->imagen)) {
            return;
        }

        $archivo = CARPETA_IMAGENES . $this->imagen;

        if (is_file($archivo)) {
            unlink($archivo);
        }
    }

    // Listar todos los registros
    public static function all() {

        $query = "SELECT * FROM " . static::$tabla;

        return static::consultarSQL($query);
    }

    // Obtener determinado número de registros
    public static function get($cantidad) {

        $cantidad = max(0, (int) $cantidad);

        $query = "SELECT * FROM " . static::$tabla;
        $query .= " LIMIT " . $cantidad;

        return static::consultarSQL($query);
    }

    // Buscar registro por ID
    public static function find($id) {

        $query = "SELECT * FROM " . static::$tabla;
        $query .= " WHERE id = :id";

        $resultado = static::consultarSQL($query, [
            'id' => $id
        ]);

        return array_shift($resultado);
    }

    // Consultar la base de datos
    public static function consultarSQL($query, $parametros = []) {

        $stmt = self::$db->prepare($query);

        $stmt->execute($parametros);

        $array = [];

        while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[] = static::crearObjeto($registro);
        }

        $stmt->closeCursor();

        return $array;
    }

    // Crear objeto
    protected static function crearObjeto($registro) {

        $objeto = new static;

        foreach ($registro as $key => $value) {

            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincronizar los cambios realizados por el usuario
    public function sincronizar($args = []) {

        foreach ($args as $key => $value) {

            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
