<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Blog;
use Model\Vendedor;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $blogs = Blog::get(2);
        $vendedores = Vendedor::all();
        $inicio = true;
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
            'blogs' => $blogs,
            'vendedores' => $vendedores,
            'tituloSEO' => 'Inicio | Bienes Raíces',
            'descripcionSEO' => 'Encuentra casas y departamentos en venta. Explora propiedades, consejos y oportunidades inmobiliarias.',
            'robotsSEO' => 'index, follow'
        ]);
    }
    public static function nosotros(Router $router) {
        $router->render('paginas/nosotros', [
            'tituloSEO' => 'Sobre Nosotros | Bienes Raíces',
            'descripcionSEO' => 'Conoce Bienes Raíces, un espacio dedicado a encontrar viviendas y ofrecer asesoría para la compra de propiedades.',
            'robotsSEO' => 'index, follow'
        ]);
    }
    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
            'tituloSEO' => 'Propiedades en Venta | Bienes Raíces',
            'descripcionSEO' => 'Descubre casas y departamentos en venta. Explora nuestro catálogo inmobiliario y encuentra la propiedad ideal para ti.',
            'robotsSEO' => 'index, follow'
        ]);
    }
    public static function propiedad(Router $router) {
        $id = validarRedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad,
            'tituloSEO' => $propiedad->titulo . ' | Bienes Raíces',
            'descripcionSEO' => mb_substr(
               strip_tags($propiedad->descripcion),
               0,
               155,
               'UTF-8'),
            'robotsSEO' => 'index, follow'
        ]);
    }
    public static function blog(Router $router) {
        $blogs = Blog::all();
        $vendedores = Vendedor::all();
        $router->render('paginas/blog', [
            'blogs' => $blogs,
            'vendedores' => $vendedores,
            'tituloSEO' => 'Blog Inmobiliario | Bienes Raíces',
            'descripcionSEO' => 'Consejos sobre compra, venta e inversión inmobiliaria.',
            'robotsSEO' => 'index, follow'
        ]);
    }
    public static function entrada(Router $router) {
        $id = validarRedireccionar('/blog');
        $blogs = Blog::find($id);
        $vendedores = Vendedor::all();
        $router->render('paginas/entrada', [
            'blogs' => $blogs,
            'vendedores' => $vendedores,
            'tituloSEO' => $blogs->titulo . ' | Bienes Raíces',
            'descripcionSEO' => mb_substr(
                strip_tags($blogs->descripcion),
                0,
                155,
                'UTF-8'
            ),
            'robotsSEO' => 'index, follow'
        ]);
    }
    public static function contacto(Router $router) {

        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $respuestas = $_POST['contacto'] ?? [];
            //Crear instancia de phpmailer
            $mail = new PHPMailer();
            

            //Configuar smtp
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '8f23e7de873606';
            $mail->Password = '6c2785f73fe343';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Configurar contenido
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BieneRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UFT-8';

            //Definir contenido 
            $contenido = '<html> ';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: '. $respuestas['nombre'] . '</p>';
            $contenido .= '<p>Contactado : '. $respuestas['contacto'] . '</p>';
            //Enviar de forma condicional email o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Teléfono: '. $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha de contacto : '. $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora : '. $respuestas['hora'] . '</p>';
            } else {
                $contenido .='<p>Eligió ser contactado por email</p>';
                $contenido .= '<p>Email: '. $respuestas['email'] . '</p>';
            }
            
            $contenido .= '<p>Mensaje: '. $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o compra: '. $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o presupuesto: $'. $respuestas['precio'] . '</p>';
            
            $contenido .= ' </html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Texto alternativo sin html';

            //Enviar el email
            if ($mail->send()){
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje = "EL mensaje no se envió correctamente";
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje,
            'tituloSEO' => 'Contáctanos | Bienes Raíces',
            'descripcionSEO' => 'Comunícate con Bienes Raíces para consultar sobre propiedades, solicitar información o recibir asesoría inmobiliaria.',
            'robotsSEO' => 'index, follow'
        ]);
    }
}