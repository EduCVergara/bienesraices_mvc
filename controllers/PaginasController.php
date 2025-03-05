<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::limite(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros (Router $router) {
        $router->render('paginas/nosotros');
    }
    public static function anuncios (Router $router) {

        $propiedades = Propiedad::limite(12);

        $router->render('paginas/anuncios', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad (Router $router) {

        // Validacion de Id válido
        $id = ValidarORedireccionar('/anuncios');

        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog (Router $router) {
        $router->render('paginas/blog');
    }
    public static function entrada (Router $router) {
        $router->render('paginas/entrada', [

        ]);
    }
    public static function contacto (Router $router) {

        $mensajeExito = null;
        $mensajeError = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];
            
            // Crear una instancia de PHPmailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'bienesraices.mvc@gmail.com';
            $mail->Password = 'huxaxznlteprqrgy';
            $mail->SMTPSecure = 'tls';

            // Configurar el contenido del E-Mail
            $mail->setFrom('bienesraices.mvc@gmail.com');
            $mail->addAddress('bienesraices.mvc@gmail.com', 'APP BienesRaices MVC');
            $mail->Subject = 'INFORMACIÓN // Tienes un nuevo mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir Contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: <strong>' . $respuestas['nombre'] . '</strong> </p>';
            $contenido .= '<p>Precio o Presupuesto: <strong>$' . $respuestas['presupuesto'] . '</strong> </p>';
            $contenido .= '<p>Deseo: <strong>' . $respuestas['tipo'] . '</strong> una propiedad</p>';
            $contenido .= '<p>Mensaje: <strong>' . $respuestas['mensaje'] . '</strong> </p>';

            // Envío condicional (Email o Teléfono)
            if ($respuestas['forma'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado por Teléfono:</p>';
                $contenido .= '<p>Teléfono: <strong>' . $respuestas['telefono'] . '</strong> </p>';
                $contenido .= '<p>Fecha preferida: <strong>' . $respuestas['fecha'] . '</strong> </p>';
                $contenido .= '<p>Hora preferida: <strong>' . $respuestas['hora'] . '</strong> </p>';
            } else {
                $contenido .= '<p>Eligió ser contactado por Email:</p>';
                $contenido .= '<p>Correo: <strong>' . $respuestas['email'] . '</strong> </p>';
            }
            
            $contenido .= '</html>';

            // Lo asignamos al cuerpo del mensaje
            $mail->Body = $contenido;
            $mail->AltBody = 'Texto alternativo sin HTML';

            if ($mail->send()) {
                $mensajeExito = 'Mensaje enviado correctamente';
            } else {
                $mensajeError = 'Hubo un error al enviar el mensaje';
            }
            
        }

        $router->render('paginas/contacto', [
            'mensajeExito' => $mensajeExito,
            'mensajeError' => $mensajeError
        ]);
    }
}