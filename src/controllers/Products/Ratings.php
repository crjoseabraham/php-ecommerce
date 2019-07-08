<?php
namespace Controller;

use \Model\Session;
use \Model\Product;

class Ratings
{
  /**
   * Return an item with its rating and reviews values
   * @param int $product_id     ID of the product to look for
   */
  public function getProductReviews($product_id)
  {
    return Product::getItemReviews($product_id);
  }

	/**
	 * Process review content before submitting
	 * @param  int $item_id    ID of the item
	 * @return void
	 */
  public function review($item_id)
  {
  	if (Session::getUser())
  	{
  		$content = htmlspecialchars($_POST['content']);
	  	$product = Products::productExists($item_id);

	  	if ($product)
	  	{
	  		Product::submitReview($content, $product->product_id);
	  		flash(REVIEW_SUBMITTED);
	  	}
  	}
  	else
      flash(LOGIN_REQUIRED, INFO);

  	redirect('/');
  }

  /**
   * Submit a rating vote for a product
   * Called when user clicks a star
   * @param  int $product_id    ID of product users desires to rate
   * @return void
   */
  public function submit($product_id)
  {
    if (Session::getUser())
    {
      // Validate the rating value submitted is a number between 1 and 5
      $rating_value = ($_POST['stars'] >= 1 && $_POST['stars'] <= 5) ? intval($_POST['stars']) : false;
      $product = Products::productExists($product_id);

      // Verify if product id passed is valid and submit the vote
      if ($product && $rating_value)
      {
        Product::submitRatingVote($product->product_id, $rating_value);
        flash(VOTE_SUBMITTED);
      }
      else
        flash(ERROR_MESSAGE, ERROR);
    }
    else
      flash(LOGIN_REQUIRED, INFO);

    redirect('/');
  }

  /**
   * Delete user's review
   * @param  int  $product_id ID of the product
   * @return void
   */
  public function delete($product_id)
  {
  	if (Session::getUser())
  	{
	  	$product = Products::productExists($product_id);

	  	if ($product)
	  	{
	  		Product::deleteReview($product->product_id);
	  		flash(REVIEW_DELETED);
	  	}
  	}
  	else
      flash(LOGIN_REQUIRED, INFO);

  	redirect('/');
  }
}