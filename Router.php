<?php

namespace MVC;

class Router {
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }
    
    public function comprobarRutas() {
        session_start();

        $auth = $_SESSION['login'] ?? null;
        //Rutas protegidas(arreglo)
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/blog/crear', '/blog/actualizar', '/blog/eliminar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else if($metodo === 'POST') {
            $fn = $this->rutasPOST[$urlActual] ?? null;
                
        }

        //Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) and !$auth) {
            header ('Location: /');
        }

        if ($fn) {
            call_user_func($fn, $this);

        } else {
            echo "Pagina no encontrada";
        }
    }
    
    public function render($view, $datos = []) {
        
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        
        foreach ($datos as $key => $value) {
            $$key = $value;
        } 

        ob_start();

        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
        
    }
}