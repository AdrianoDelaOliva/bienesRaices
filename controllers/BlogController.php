<?php

    namespace Controllers;
    use MVC\Router;
    use Model\Blog;
    use Model\Vendedor;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    class BlogController {
        public static function crear(Router $router) {
            $blogs = new Blog();
            $vendedores = Vendedor::all();
            $errores = Blog::getErrores();
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $blogs = new Blog($_POST['blogs']);

            //Generar nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) .".jpg";

            if($_FILES['blogs']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->decode($_FILES['blogs']['tmp_name']['imagen'])->cover(800, 600);
                $blogs->setImagen($nombreImagen);
            }

            $errores = $blogs->validar();

            //Revisar el arreglo de errores 
            if (empty($errores)) {

                //Subida de archivos
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                //Guardar imagen en el servidor 
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                $blogs->guardar();
            }
        }   
            $router->render('blog/crear' , [
            'errores' => $errores,
            'blogs' => $blogs,
            'vendedores' => $vendedores
        ]);
        }   
        public static function actualizar(Router $router) {
            $id = validarRedireccionar('/admin');
            $blogs = Blog::find($id);
            $vendedores = Vendedor::all();
            $errores = Blog::getErrores();

            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
            $args = $_POST['blogs'];
        
            $blogs->sincronizar($args);
        
            $errores = $blogs->validar();
        
            $nombreImagen = md5( uniqid( rand(), true ) ) .".jpg";

            if($_FILES['blogs']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->decode($_FILES['blogs']['tmp_name']['imagen'])->cover(800, 600);
                $blogs->setImagen($nombreImagen);
            }

            if (empty($errores)) {

                if (isset($imagen)) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                }
                $blogs->guardar();

            }

        }
        $router->render('/blog/actualizar', [
            'blogs' => $blogs,
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
    
                    $blogs = Blog::find($id);
                    $blogs->eliminar();
            }
            
        }
        }
    }
    }