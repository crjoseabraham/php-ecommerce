<?php 
namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Email class
 */
class Email
{
  /**
   * Send a message
   * @param string $to      Recipient
   * @param string $subject Subject
   * @param string $text    Text-only content of the message
   * @param string $html    HTML content of the message
   *
   * @return mixed
   */
  public static function send($to, $subject, $text, $html)
  {
    $mail = new PHPMailer(true);

    try 
    {
      //Server settings
      $mail->isSMTP();                        // Set mailer to use SMTP
      $mail->Host       = EMAIL_HOST;         // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true;               // Enable SMTP authentication
      $mail->Username   = EMAIL_USER;         // SMTP username
      $mail->Password   = EMAIL_PASS;         // SMTP password
      $mail->SMTPSecure = 'STARTTLS';
      $mail->Port       = 587;                // TCP port to connect to
      
      //Recipients
      $mail->setFrom(EMAIL_USER, EMAIL_NAME);
      $mail->addAddress($to);                 // Add a recipient

      // Content
      $mail->isHTML(true);                    // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $html;
      $mail->AltBody = $text;

      $mail->send();
    } 
    catch (Exception $e) 
    {
      echo EMAIL_ERROR;
    }
  }
}