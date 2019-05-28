<?php 
namespace Model;

use \App\Database;

/**
 * Payment model
 * Contains functions to process a new purchase, register a new order and handle the order's data
 */
class Payment extends Database
{
  /**
   * Store the new purchase order in the database
   * @param  float $shipping_costs  Shipping costs value
   * @param  float $total         Total amount
   * @return mixed                ID of last inserted record, false if there's something wrong
   */
  public function newPurchase(float $shipping_costs, float $total)
  {
    $db = static::getDB();
    $stmt = $db->prepare("INSERT INTO `order` VALUES(null, :user, :created, :costs, :total)");
    $stmt->bindValue(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(':created', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
    $stmt->bindValue(':costs', $shipping_costs, \PDO::PARAM_STR);
    $stmt->bindValue(':total', $total, \PDO::PARAM_STR);
    if ($stmt->execute())
      return self::saveOrderDetails($db->lastInsertId());

    return false;
  }

  /**
   * Save order items by migrating th data from cart_items table to the order_details table
   * @param  int $order_id   ID of the respective order
   * @return boolean         Result of execution
   */
  public function saveOrderDetails($order_id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("
      INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `subtotal`)
      SELECT :order_id, `cart_items`.`product_id`, `cart_items`.`quantity`, `cart_items`.`subtotal`
      FROM `cart_items`");
    $stmt->bindValue(':order_id', $order_id, \PDO::PARAM_INT);
    return $stmt->execute();
  }

  /**
   * Get all orders for the current logged in user
   * @return mixed Array if records found, false otherwise
   */
  public function getOrders()
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM `order` WHERE user_id = :user ORDER BY created_at DESC");
    $stmt->bindValue(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
    return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : false;
  }

  /**
   * Get a specific order by its ID
   * @param  int $id    ID of the order to search for
   * @return object     Order details
   */
  public function getOrderById($id)
  {
    $order = [];

    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM `order` WHERE `order_id` = :order");
    $stmt->bindValue(':order', $id, \PDO::PARAM_INT);
    if ($stmt->execute())
      $order['details'] = $stmt->fetch(\PDO::FETCH_OBJ);
    else
      return false;

    $stmt = $db->prepare("
      SELECT 
      `order_details`.quantity, 
      `product`.description, 
      `product`.price,
      `order_details`.subtotal
      FROM `order_details` 
      INNER JOIN `product` 
      ON `order_details`.product_id = `product`.product_id 
      WHERE `order_details`.order_id = :order");

    $stmt->bindValue(':order', $id, \PDO::PARAM_INT);
    if ($stmt->execute())
      $order['items'] = $stmt->fetchAll(\PDO::FETCH_OBJ);
    else
      return false;

    return (object) $order;
  }
}