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

    // Obtener la ruta actual
    private function obtenerRuta() {

        $url = parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        return rtrim($url ?: '/', '/') ?: '/';
    }

    public function comprobarRutas() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $auth = $_SESSION['login'] ?? false;

        // Rutas protegidas
        $rutas_protegidas = [
            '/admin',
            '/propiedades/crear',
            '/propiedades/actualizar',
            '/propiedades/eliminar',
            '/vendedores/crear',
            '/vendedores/actualizar',
            '/vendedores/eliminar',
            '/blog/crear',
            '/blog/actualizar',
            '/blog/eliminar'
        ];

        $urlActual = $this->obtenerRuta();

        $metodo = $_SERVER['REQUEST_METHOD'];

        $fn = null;

        if ($metodo === 'GET') {

            $fn = $this->rutasGET[$urlActual] ?? null;

        } else if ($metodo === 'POST') {

            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas, true) && !$auth) {

            header('Location: /');
            exit;
        }

        if ($fn) {

            call_user_func($fn, $this);

        } else {

            http_response_code(404);
            echo "Página no encontrada";
        }
    }

    public function render($view, $datos = []) {

        $urlActual = $this->obtenerRuta();

        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}
