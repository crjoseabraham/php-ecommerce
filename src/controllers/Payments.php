<?php 
namespace Controller;

use \Model\Payment;
/**
 * Payments controller
 * Handle needed methods and data to process payment
 */
class Payments
{
  
  public function processPayment()
  {
    # code...
  }

  public function getCartTotal()
  {
    return Payment::cartTotal();
  }
}