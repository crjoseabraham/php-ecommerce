<?php
namespace Controller;

use \Model\User;
use \Model\Payment;
use \Mpdf\Mpdf as mPDF;

/**
 * Receipts class
 */
class Receipts
{
  /**
   * Get all orders for the current user
   */
  public function getUserOrders()
  {
    return Payment::getOrders();
  }

  /**
   * Print an order's receipt in a PDF document
   * @param  int $receipt_id    ID of the order to print
   * @return void
   */
  public function print($receipt_id)
  {
    // Get user and order details
    $user = User::findById($_SESSION['user_id']);
    $order = Payment::getOrderById($receipt_id);

    // Page settings
    $mpdf = new mPDF([
      'format' => [93.6, 200],
      'default_font' => 'Courier',
      'default_font_size' => 9
    ]);

    // Browser tab title
    $mpdf->SetTitle('Purchase details');

    // Get .css file as string and create HTML markup
    $stylesheet = file_get_contents(dirname(dirname(dirname(__DIR__))) . '\public\css\receipts.css');
    $html = self::template($order, $user);

    // Import styles and markup :)
    $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

    // Print
    $mpdf->Output("receipt.pdf", "I");
    $mpdf->Output();
  }

  /**
   * HTML template for the PDF document
   * @param  object $order Order details and items
   * @param  object $user  User data to display the name in the receipt
   * @return string        Complete HTML template
   */
  private function template(object $order, object $user) : string
  {
    $order_subtotal = 0;

    $html = '
    <h1> myMiniMarket </h1>
    <p> 742 Evergreen Terrace <br>
        48184 <br>
        www.myminimarket.com
    </p>
    <br>
    <span> Order: #' . $order->details->order_id . '</span>
    <br>
    <span> Date/Hour: ' . $order->details->created_at . '</span>
    <br>
    <span> Client: ' . $user->name . '</span>
    <br><br>
    <hr>
    <table>
      <thead>
      <tr>
      <th> PRODUCT </th>
      <th> UNIT PRICE </th>
      <th> TOTAL </th>
      </tr>
      </thead>

      <tbody>';

    foreach ($order->items as $item)
    {
      $order_subtotal += $item->subtotal;
      $html .= '
      <tr>
        <td> ('. $item->quantity .') x '. $item->description.' </td>
        <td> '. $item->price .' </td>
        <td> '. $item->subtotal .'</td>
      </tr>';
    }

    $html .= '
      </tbody>
    </table>
    <hr>
    <div class="order_summary"> Subtotal: $'. $order_subtotal .' </div>
    <div class="order_summary"> Shipping costs: $'. $order->details->transport_costs .' </div>
    <div class="order_summary total"> TOTAL: $'. $order->details->total .' </div>

    <div class="footer"> Thanks for using my app :) </div>
    ';

    return $html;
  }
}