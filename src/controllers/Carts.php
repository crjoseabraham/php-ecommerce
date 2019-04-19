<?php 
namespace Controller;

use \Model\Cart;
use \Model\Product;
use \Model\Session;
/**
 * Carts class
 * Add to/Remove from cart
 */
class Carts
{
  
  public function add($item_id)
  {
    if (Session::getUser())
    {
      if (Cart::addItem(Product::getItem($item_id), $_POST['quantity']))
        redirect('/store');
      else
        die("Something went wrong");
    }
    else
      redirect('/login');
  }

  public function remove($item_id)
  {
    if (Cart::removeItem($item_id))
      redirect('/store');
    else
      die("Something went wrong");
  }
}