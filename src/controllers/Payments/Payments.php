<?php 
namespace Controller;

use \Model\Payment;
use \Model\Session;
use \Model\Cart;

/**
 * Payments controller
 * Handle needed methods and data to process payment and print orders receipt
 */
class Payments
{  

  /**
   * Get all orders for the current user
   */
  public function getUserOrders()
  {
    return Payment::getOrders();
  }

  /**
   * Process Payment
   * Previous validations before the payment is processed
   * @return void
   */
  public function processPayment()
  {
    $subtotal = Carts::getCartTotal();

    // Get total adding shipping costs
    switch (intval($_POST['shipping'])) 
    {
      case 7:
        $shipping_costs = number_format(($subtotal * 0.07), 2, '.', '');
        $total = $subtotal + $shipping_costs;
        break;
      
      case 0:
        $shipping_costs = 0;
        $total = $subtotal;
        break;
    }

    $total_is_less_than_budget = $_SESSION['cash'] >= $total ?? false;

    if (!$total_is_less_than_budget || !Payment::newPurchase($shipping_costs, $total))
      \flash(OVER_BUDGET, ERROR);
    else
    {
      $_SESSION['cash'] -= $total;
      Session::updateSessionBudget();
      Cart::emptyCart();
      \flash(PURCHASE_COMPLETED);
    }
    
    redirect('/store');
  }
}