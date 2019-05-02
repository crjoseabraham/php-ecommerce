<?php 
namespace Controller;

use \Model\Payment;
use \Model\Session;
use \Model\Cart;
/**
 * Payments controller
 * Handle needed methods and data to process payment
 */
class Payments
{
  
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

  public function getCartTotal()
  {
    return Payment::cartTotal();
  }
}