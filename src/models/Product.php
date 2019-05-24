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
  public function getItem($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM product WHERE product_id = :id");
    $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Submit rating vote
   * If submission was successful, then update the average
   * @param  int $product_id   Product ID
   * @param  int $rating_value Value from 1 to 5
   * @return void
   */
  public function submitRatingVote($product_id, $rating_value)
  {
    $db = static::getDB();
    $stmt = $db->prepare("INSERT INTO `rating` VALUES(null, :product, :rating, :session)");
    $stmt->bindValue(':product', $product_id, \PDO::PARAM_INT);
    $stmt->bindValue(':rating', $rating_value, \PDO::PARAM_STR);
    $stmt->bindValue(':session', $_SESSION['session_id'], \PDO::PARAM_STR);
    if ($stmt->execute())
      self::updateRating($product_id, self::getAverageRating($product_id));
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

  /**
   * Check if the user already submitted a vote for an item in the same session
   * @param int $product_id Product ID
   * @return boolean        True if record found, false if not
   */
  public function userAlreadyRatedInThisSession(int $product_id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM rating WHERE rating_product_id = :product AND session_id = :session");
    $stmt->bindValue(':product', $product_id, \PDO::PARAM_INT);
    $stmt->bindValue(':session', $_SESSION['session_id'], \PDO::PARAM_STR);
    if ($stmt->execute())
    {
      if ($stmt->fetch())
        return true;
      else
        return false;
    }
  }
}