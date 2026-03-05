<?php
namespace Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    public static function send($to, $subject, $message) {
        // Necesitás cargar la librería (ajustá la ruta según tu carpeta)
        require_once(ROOT . "Vendor/PHPMailer/src/Exception.php");
        require_once(ROOT . "Vendor/PHPMailer/src/PHPMailer.php");
        require_once(ROOT . "Vendor/PHPMailer/src/SMTP.php");

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor (Mailtrap)
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = '338f8fde96e8a3';
            $mail->Password   = '1f204a9274ee81';
            $mail->Port       = 2525;

            // Remitente y Destinatario
            $mail->setFrom('admin@letswork.com', 'Lets Work System');
            $mail->addAddress($to);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}