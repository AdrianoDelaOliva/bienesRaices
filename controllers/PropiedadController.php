<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Blog;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $blogs = Blog::all();
        $resultado = $_GET['resultado'] ?? null;
        $router->render('propiedades/admin' , [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado,
            'blogs' => $blogs
        ]);
    }
    public static function crear(Router $router){
        
        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $propiedad = new Propiedad($_POST['propiedad']);

            //Generar nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) .".jpg";

            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->decode($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            $errores = $propiedad->validar();

            //Revisar el arreglo de errores 
            if (empty($errores)) {

                //Subida de archivos
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                //Guardar imagen en el servidor 
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                $propiedad->guardar();
            }
        }   

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarRedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
            $args = $_POST['propiedad'];
        
            $propiedad->sincronizar($args);
        
            $errores = $propiedad->validar();
        
            $nombreImagen = md5( uniqid( rand(), true ) ) .".jpg";

            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->decode($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            if (empty($errores)) {

                if (isset($imagen)) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                }
                $propiedad->guardar();

            }

        }
        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            $tipo = $_POST['tipo'];
            if (validarTipoContenido($tipo)){
    
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
            }
            
        }
        }
    }
}
