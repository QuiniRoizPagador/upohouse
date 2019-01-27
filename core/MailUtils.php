<?php

namespace core;

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
    static function sendMail($to, $subject, $message, $headers) {
        
    }

}
