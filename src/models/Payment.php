<?php 
namespace Model;

use \App\Database;

/**
 * Payment model
 */
class Payment extends Database
{

  public function cartTotal()
  {
    $cart = Cart::cartItems();
    $subtotal = 0;
    foreach ($cart as $item) 
    {
      $subtotal += $item->subtotal;
    }

    return $subtotal;
  }
}