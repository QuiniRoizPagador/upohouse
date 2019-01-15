<?php

namespace core;

class MailUtils {

    static function sendMail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }

}
