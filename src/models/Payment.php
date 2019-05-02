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

  public function newPurchase()
  {
    $db = static::getDB();
    $stmt = $db->prepare("INSERT INTO `order` VALUES(null, :user, :created, :costs, :total)");
    $stmt->bindValue(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(':created', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
    //TODO: Transport costs, for now it's a static value
    $stmt->bindValue(':costs', 10, \PDO::PARAM_INT);
    $stmt->bindValue(':total', (self::cartTotal() + 10), \PDO::PARAM_STR);
    if ($stmt->execute())
      return self::saveOrderDetails($db->lastInsertId());

    return false;
  }

  public function saveOrderDetails($order_id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `subtotal`)
                          SELECT :order_id, `cart_items`.`product_id`, `cart_items`.`quantity`, `cart_items`.`subtotal`
                          FROM `cart_items`");
    $stmt->bindValue(':order_id', $order_id, \PDO::PARAM_INT);
    return $stmt->execute();
  }
}