<?php 
namespace Controller;

use \Model\Payment;
use \Model\Session;
use \Model\Cart;
use \Mpdf\Mpdf as mPDF;
/**
 * Payments controller
 * Handle needed methods and data to process payment
 */
class Payments
{
  public function getCartTotal()
  {
    return Payment::cartTotal();
  }
  
  public function processPayment()
  {
    $total_is_less_than_budget = ($_SESSION['cash'] >= (self::getCartTotal() + 10)) ?? false;

    if (!$total_is_less_than_budget || !Payment::newPurchase())
      \flash(ERROR_MESSAGE, ERROR);
    else
    {
      $_SESSION['cash'] -= (self::getCartTotal() + 10);
      Session::updateSessionBudget();
      Cart::emptyCart();
    }
    
    redirect('/store');
  }

  public function printOrder($receipt_id)
  {
    // Page settings
    $mpdf = new mPDF([
      'format' => [93.6, 200],
      'default_font' => 'Arial',
      'default_font_size' => 9
    ]);

    // Browser tab title
    $mpdf->SetTitle('Purchase details');

    // Get .css file as string and create HTML markup
    $stylesheet = file_get_contents(dirname(dirname(__DIR__)) . '\public\css\receipts.css');
    $html = '<h1> Hello World! </h1>';

    // Import styles and markup :)
    $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

    $mpdf->Output("receipt.pdf", "I");
    $mpdf->Output();
  }
}