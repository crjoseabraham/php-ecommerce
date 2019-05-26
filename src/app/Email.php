<?php 
namespace App;

use Mailgun\Mailgun;

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
    // First, instantiate the SDK with your API credentials
    $mg = Mailgun::create(MAILGUN_API_KEY); // For US servers

    // Now, compose and send your message.
    // $mg->messages()->send($domain, $params);
    $mg->messages()->send(MAILGUN_DOMAIN, [
      'from'    => 'joseabraham@myminimarket.com',
      'to'      => $to,
      'subject' => $subject,
      'text'    => $text,
      'html'    => $html
    ]);
  }
}