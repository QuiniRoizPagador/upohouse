<?php

namespace core;

class MailUtils {

    static function sendMail($to, $subject, $message, $headers) {
        return mail($to, $subject, $message, $headers);
    }

}
