<?php

namespace App\Library;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    static function enviaEmail($emailRemetente, $nomeRemetente, $assunto, $corpoEmail, $destinatario) 
    {
        // Carregar autoloader
        require 'third/phpmailer/vendor/autoload.php';

        //
        
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->CharSet      = "UTF-8";
        $mail->SMTPAuth     = true;                             // Ativa o SMTP autenticado
        $mail->SMTPSecure   = "tls";                            // Tipo de segurança
        $mail->Host         = "smtp.gmail.com";
        $mail->Port         = 587;
        $mail->Username     = "iigustavow@gmail.com";         // Usuário de e-mail para autenticação
        $mail->Password     = "f@@dy2021";                      // Senha do e-mail de autenticação
        $mail->From         = $emailRemetente;                  // E-mail remetente
        $mail->FromName     = $nomeRemetente;                   // Nome do Remetente
        
        $mail->addAddress( $destinatario );    // E-mail Destinatário 
        
        $mail->isHTML( true );                                  // Será HTML
        $mail->Subject      = $assunto;                         // Assunto do e-mail
        $mail->Body         = $corpoEmail;                      // Corpo do E-mail HTML
        // $mail->AltBody      = $corpoEmail;                      // Corpo do E-mail em formato text
        
        // $arquivo = $_FILES["arquivo"];
        // $mail->addAttachment($arquivo['tmp_name'], $arquivo['name']);

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}