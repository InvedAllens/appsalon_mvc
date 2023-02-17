<?php 

    
    namespace Classes;
    use PHPMailer\PHPMailer\PHPMailer;
    class Email{
        public $email;
        public $nombre;
        public $token;

        public function __construct($email, $nombre, $token){
            $this->email=$email;
            $this->nombre=$nombre;
            $this->token=$token;
        }

        public function enviarConfirmacion(){

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '546e99008c2430';
            $mail->Password = '5481afa33c809f';
            $mail->SMTPSecure='tls';
            $mail->Port = 2525;
            //define transmisor y receptor
            $mail->setFrom('cuentas@appsalon.com');//quien lo envia
            $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
            $mail->Subject='Confirma tu cuenta en AppSalon';
            //establecer html
            $mail->isHTML(true);
            $mail->CharSet='utf-8';

            $contenido="<html>";
            $contenido.="<p><strong>Hola ".$this->nombre."</strong> Has creado tu cuenta en App Salon, solo debes confirmarla
            presionando el siguiente enlace</p>";
            $contenido.="<p>Presiona aqui<a href='http://localhost:3000/confirmar-cuenta?token="
            .$this->token."'>Confirmar Cuenta</a></p>";
            $contenido.="<p>Si usted no solicito esta cuenta, puede ignorar el mensaje</p>";
            $contenido.="</html>";
            $mail->Body=$contenido;
            $mail->AltBody="un nuevo mensaje desde appsalon confirmar cuenta";
            $mail->send();
            //debugear($resultado=$mail->send());

        }
        public function enviarRecuperar(){

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '546e99008c2430';
            $mail->Password = '5481afa33c809f';
            $mail->SMTPSecure='tls';
            $mail->Port = 2525;
            //define transmisor y receptor
            $mail->setFrom('cuentas@appsalon.com');//quien lo envia
            $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
            $mail->Subject='Restablecer Password en AppSalon';
            //establecer html
            $mail->isHTML(true);
            $mail->CharSet='utf-8';

            $contenido="<html>";
            $contenido.="<p><strong>Hola ".$this->nombre."</strong> Has solicitado recuperar tu cuenta en App Salon, solo debes
            presionar el siguiente enlace</p>";
            $contenido.="<p>Presiona aqui<a href='http://localhost:3000/recuperar?token="
            .$this->token."'>Restablecer Password</a></p>";
            $contenido.="<p>Si usted no solicito recuperar su cuenta, puede ignorar este mensaje</p>";
            $contenido.="</html>";
            $mail->Body=$contenido;
            $mail->AltBody="un nuevo mensaje desde appsalon Restablecer cuenta";
            $mail->send();

        }
    }