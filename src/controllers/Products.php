<?php 
namespace Controller;

use \Model\Product;
use \Model\Session;

class Products
{
  /**
   * Get an object containing all products
   * @return object Products
   */
  public function getAllProducts()
  {
    return Product::getAll();
  }

  /**
   * Check if specific product exists in the dabatase
   * @param  int $product_id    ID of the product to check
   * @return mixed              Object with the product info if it was found, false if not
   */
  public function productExists($product_id)
  {
    return Product::getItem($product_id);
  }

  /**
   * Submit a rating vote for a product
   * Called when user clicks a star
   * @param  int $product_id    ID of product users desires to rate
   * @return void
   */
  public function rateProduct($product_id)
  {
    if (Session::getUser())
    {
      // Validate the rating value submitted is a number between 1 and 5
      $rating_value = (preg_match('/\d+/', $_POST['star']) && ($_POST['star'] >= 1 && $_POST['star'] <= 5 )) ? intval($_POST['star']) : false;

      // Verify if product id passed is valid and submit the vote
      if (self::productExists($product_id) && $rating_value)
      {
        Product::submitRatingVote($product_id, $rating_value);
        flash(VOTE_SUBMITTED);
      }
      else
        flash(ERROR_MESSAGE, ERROR);
    }
    else
    {
      flash(LOGIN_REQUIRED, INFO);
      redirect('/login');
    }

    redirect('/store');
  }
}