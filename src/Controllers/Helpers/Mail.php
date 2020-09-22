<?php
namespace App\Controller\Helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {

    /**
     * Send email
     *
     * @param string $to        Destination email
     * @param string $subject   Subject of the email
     * @param string $text      Plain text version of the content
     * @param string $html      Full HTML version of the content
     * @return void
     */
    public static function send($to, $subject, $text, $html) {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();                    //Set PHPMailer to use SMTP.
            $mail->Host = "smtp.gmail.com";     //Set SMTP host name
            $mail->SMTPAuth = true;             //Because SMTP host requires authentication to send email
            //Provide username and password
            $mail->Username = BRAND_EMAIL;
            $mail->Password = BRAND_EMAIL_PASS;
            $mail->SMTPSecure = "tls";          //If SMTP requires TLS encryption then set it
            $mail->Port = 587;                  //Set TCP port to connect to
            $mail->From = BRAND_EMAIL;
            $mail->FromName = BRAND_NAME;

            // Destination info
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = $text;
            $mail->send();
        } catch (Exception $e) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }
    }
}