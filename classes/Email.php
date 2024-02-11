<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    protected $nombre;
    protected $email;
    protected $token;

    public function __construct($nombre, $email, $token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }


    public function enviarConfirmacion(){
        
        // Crear el objeto para los E-Mails.
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['EMAIL_PORT'];
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASSWORD'];

        $email->setFrom('cuentas@uptask.com');
        $email->addAddress('cuentas@uptask.com', 'uptask.com');
        $email->Subject = 'Confirma tu Cuenta';

        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Uptask. Para confirmar la misma, ingresa al siguiente enlace.</p>";
        $contenido .= "<p>Presiona Aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= '<p>Si tu no creaste esta cuenta, ignora este mensaje</p>';
        $contenido .= '</html>';

        $email->Body = $contenido;

        // Enviar Email.
        $email->send();
    }


    public function enviarInstrucciones(){
        // Crear el objeto para los E-Mails.
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = "sandbox.smtp.mailtrap.io";
        $email->SMTPAuth = true;
        $email->Port = 2525;
        $email->Username = '6e5719b482996e';
        $email->Password = "c1a05719ea49a5";

        $email->setFrom('cuentas@uptask.com');
        $email->addAddress('cuentas@uptask.com', 'uptask.com');
        $email->Subject = 'Reestablece tu Contraseña';

        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Parece que has solicitado reestablecer tu contraseña en Uptask. Sigue las instrucciones para recuperar el acceso.</p>";
        $contenido .= "<p>Presiona Aqui: <a href='" . $_ENV['APP_URL'] . "/reestablecer?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $contenido .= '<p>Si tu no realizaste esta acción, por favor, ignora este mensaje.</p>';
        $contenido .= '</html>';

        $email->Body = $contenido;

        // Enviar Email.
        $email->send();
    }
}