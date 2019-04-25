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

  public function getCartItems()
  {
    return Cart::cartItems();
  }

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
        flash(ITEM_ADDED);
      else
        flash(ERROR_MESSAGE, ERROR);

      redirect('/store');
    }
    else
    {
      flash(LOGIN_REQUIRED, INFO);
      redirect('/login');
    }
  }

  /**
   * Call function to remove item from cart
   * @param  int $item_id   ID of item to remove
   */
  public function remove(int $item_id) : void
  {
    if (Cart::removeItem($item_id))
      flash(ITEM_REMOVED);
    else
      flash(ERROR_MESSAGE, ERROR);

    redirect('/store');
  }
}