<?php
namespace Model;

use \App\Database;

/**
 * Product class
 * Get data from 'product' table in the database
 */
class Product extends Database
{
  /**
   * Get all products
   * @return mixed  Array if records found, false if not
   */
  public function getAll()
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM product");
    return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Get item by its ID
   * @param  int $id  ID of item to search for
   * @return mixed    Array if records found, false if not
   */
  public function getItemById($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("
      SELECT product.*, COUNT(`rating`.rating_value) AS total_rating_votes
      FROM product 
      INNER JOIN rating
      ON product.product_id = rating.rating_product_id
      WHERE product_id = :id");
    $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Get all reviews of certain item
   * @param  int    $id ID of the product
   * @return mixed      Object or false if execution fails
   */
  public function getItemReviews($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("
      SELECT review.review_user_id, user.name, review.review_content 
      FROM `review`
      INNER JOIN `user`
      ON review.review_user_id = user.id
      WHERE review.review_product_id = :product"
    );
    $stmt->bindValue(':product', $id, \PDO::PARAM_INT);
    return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Submit a review for an item
   * @param  string $content Review text
   * @param  int    $product ID of the product
   * @return void
   */
  public function submitReview($content, $product)
  {
    $db = static::getDB();

    // First check if there's a record for this item with current user
    // And prepare the query depending on the case
    if (self::userAlreadyReviewed($product))
      $stmt = $db->prepare("UPDATE `review` SET `review_content` = :review WHERE review_product_id = :rp AND review_user_id = :ru");
    else
      $stmt = $db->prepare("INSERT INTO `review` VALUES(null, :rp, :ru, :review)");

    $stmt->bindValue(':review', $content, \PDO::PARAM_STR);
    $stmt->bindValue(':rp', $product, \PDO::PARAM_INT);
    $stmt->bindValue(':ru', $_SESSION['user_id'], \PDO::PARAM_INT);
    $stmt->execute();
  }

  /**
   * Delete current user's review of certain product
   * @param  int $product ID of the product
   * @return void
   */
  public function deleteReview($product)
  {
    $db = static::getDB();
    $stmt = $db->prepare("DELETE FROM `review` WHERE review_product_id = :rp AND review_user_id = :ru");
    $stmt->bindValue(':rp', $product, \PDO::PARAM_INT);
    $stmt->bindValue(':ru', $_SESSION['user_id'], \PDO::PARAM_INT);
    $stmt->execute();
  }

  /**
   * Submit rating vote
   * If submission was successful, then update the average
   * @param  int $product_id   Product ID
   * @param  int $rating_value Value from 1 to 5
   * @return void
   */
  public function submitRatingVote($product, $value)
  {
    $db = static::getDB();

    // First check if there's a record for this item with current user
    // And repare the query depending on the case
    if (self::userAlreadyVoted($product))
      $stmt = $db->prepare("UPDATE `rating` SET rating_value = :rv WHERE rating_product_id = :rp AND rating_user_id = :ru");
    else
      $stmt = $db->prepare("INSERT INTO `rating` VALUES(null, :rp, :ru, :rv)");

    $stmt->bindValue(':rp', $product, \PDO::PARAM_INT);
    $stmt->bindValue(':ru', $_SESSION['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(':rv', $value, \PDO::PARAM_INT);
    if ($stmt->execute())
      self::updateRating($product, self::getAverageRating($product));
  }

  /**
   * Update rating in the `product` table
   * @param  int   $product_id         Product ID
   * @param  float $new_average_value  Updated average value for product's rating
   * @return void
   */
  public function updateRating($product_id, $new_average_value)
  {
    if ($new_average_value)
    {
      $db = static::getDB();
      $stmt = $db->prepare("UPDATE product SET rating = :rating WHERE product_id = :product");
      $stmt->bindValue(':rating', $new_average_value, \PDO::PARAM_STR);
      $stmt->bindValue(':product', $product_id, \PDO::PARAM_INT);
      $stmt->execute();
    }
    else
      die(ERROR_MESSAGE);
  }

  /**
   * Get average rating of specific product
   * @param  int    $product_id Product ID
   * @return mixed              Average if execution was succesful, false if not
   */
  public function getAverageRating(int $product_id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT AVG(`rating_value`) as `average` FROM rating WHERE rating_product_id = :id");
    $stmt->bindValue(':id', $product_id, \PDO::PARAM_INT);
    return $stmt->execute() ? number_format($stmt->fetchColumn(), 1, '.', '') : false;
  }


  // Utility functions
  
  // Check if there's a record in the `review` table for the current user and for an specific item
  public function userAlreadyReviewed($product)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM `review` WHERE review_product_id = :rp AND review_user_id = :ru");
    $stmt->bindValue(':rp', $product, \PDO::PARAM_INT);
    $stmt->bindValue(':ru', $_SESSION['user_id'], \PDO::PARAM_INT);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  // Check if there's a record in the `rating` table for the current user and for an specific item
  public function userAlreadyVoted($product)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM `rating` WHERE rating_product_id = :rp AND rating_user_id = :ru");
    $stmt->bindValue(':rp', $product, \PDO::PARAM_INT);
    $stmt->bindValue(':ru', $_SESSION['user_id'], \PDO::PARAM_INT);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }
  
}