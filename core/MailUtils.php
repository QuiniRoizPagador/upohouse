<?php

namespace core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

/**
 * Clase encargada del envío de mensajes de correo
 */
class MailUtils {

    /**
     * Método estático que envía un mensaje de correo a través de un sistema 
     * smtp asociado a la aplicación.
     * 
     * @param String $to destinatario.
     * @param String $subject asunto del mensaje.
     * @param String $message contenido del correo.
     * @param String $headers cabecera del mensaje.
     * @return boolean True si mensaje enviado correctamente, Falso en caso contrario.
     */
    static function sendMail($to, $subject, $message) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0; // 2 para verlo           // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = MAIL_USER;                 // SMTP username
            $mail->Password = MAIL_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = SMTP_PROTOCOL;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = SMTP_PORT;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom(MAIL_USER, MAIL_NAME);
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    static function sendFreeMail($to, $subject, $message, $header) {
        mail($to, $subject, $message, $header);
    }

}
