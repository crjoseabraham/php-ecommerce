<?php 
namespace Controller;

use \Model\Cart;
use \Model\Product;
use \Model\Session;
/**
 * Carts controller class
 * Add to/Remove from cart
 */
class Carts
{
  /**
   * From the store.html view
   * Check if user is logged in, if so, proceed to call Cart model
   * if not, redirect to login page
   * @param int $item_id  ID of item to add
   */
  public function add(int $item_id) : void
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

  /**
   * Call function to remove item from cart
   * @param  int $item_id   ID of item to remove
   */
  public function remove(int $item_id) : void
  {
    if (Cart::removeItem($item_id))
      redirect('/store');
    else
      die("Something went wrong");
  }
}