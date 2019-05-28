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
   * Get all items in the user's cart
   * @return object All items
   */
  public function getCartItems()
  {
    return Cart::cartItems();
  }

  /**
   * Get the total amount of user's cart
   * @return float    Total amount
   */
  public function getCartTotal()
  {
    return Cart::cartTotal();
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
      // Verify the id passed belongs to a registered product
      $item = Products::productExists($item_id);

      if ($item && Cart::addItem($item, $_POST['quantity']))
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
    // Verify the id passed belongs to a registered product
    $item = Products::productExists($item_id);

    if ($item && Cart::removeItem($item->product_id))
      flash(ITEM_REMOVED);
    else
      flash(ERROR_MESSAGE, ERROR);

    redirect('/store');
  }
}