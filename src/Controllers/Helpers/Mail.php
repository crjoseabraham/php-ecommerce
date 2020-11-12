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
    public static function send($to, $subject, $text, $html, $attachment = null, $attachment_title = null) {
        $brand_email = $_ENV['BRAND_EMAIL'];
        $brand_email_pass = $_ENV['BRAND_EMAIL_PASS'];
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();                    //Set PHPMailer to use SMTP.
            $mail->Host = "smtp.gmail.com";     //Set SMTP host name
            $mail->SMTPAuth = true;             //Because SMTP host requires authentication to send email
            //Provide username and password
            $mail->Username = $brand_email;
            $mail->Password = $brand_email_pass;
            $mail->SMTPSecure = "tls";          //If SMTP requires TLS encryption then set it
            $mail->Port = 587;                  //Set TCP port to connect to
            $mail->From = $brand_email;
            $mail->FromName = 'About The Fit';

            // Destination info
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = $text;

            // Attachment
            if ($attachment !== null)
                $mail->addStringAttachment($attachment, $attachment_title);

            $mail->send();
        } catch (Exception $e) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }
    }
}