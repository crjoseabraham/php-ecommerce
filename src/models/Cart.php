<?php 
namespace Model;

use \App\Database;

class Cart extends Database
{
  public function createNewCart($user) : bool
  {
    $db = static::getDB();
    $stmt = $db->prepare("INSERT INTO cart (`user_id`) VALUES(:id)");
    $stmt->bindValue(':id', $user->id, \PDO::PARAM_STR);
    return $stmt->execute() ? true : false;
  }

  public function getUserCartId($user)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM cart WHERE user_id = :user");
    $stmt->bindValue(':user', $user, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }


  public function getCartItems()
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT cart_items.* FROM cart_items INNER JOIN cart on cart_items.cart_id = cart.id WHERE cart.user_id = :user");
    $stmt->bindValue(':user', intval($_SESSION['user']), \PDO::PARAM_INT);
    return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
  }

  public function addItem($item, $quantity)
  {
    if (preg_match('/\d+/', $quantity))
    {
      $userCart = self::getUserCartId($_SESSION['user']);
      $db = static::getDB();

      // First check if the item is in the cart already, if so, update quantity and subtotal
      if (self::itemIsAlreadyInCart($item->product_id, $userCart->id))
        $stmt = $db->prepare("UPDATE cart_items SET quantity = :quantity, subtotal = :subtotal WHERE product_id = :item AND cart_id = :cart");
      else
        $stmt = $db->prepare("INSERT INTO cart_items VALUES(:cart, :item, :quantity, :subtotal)");

      $stmt->bindValue(':cart', intval($userCart->id), \PDO::PARAM_INT);
      $stmt->bindValue(':item', intval($item->product_id), \PDO::PARAM_INT);
      $stmt->bindValue(':quantity', intval($quantity), \PDO::PARAM_INT);
      $stmt->bindValue(':subtotal', ($item->price * intval($quantity)), \PDO::PARAM_STR);
      return $stmt->execute() ? true : false;
    }
    else
      return false;
  }

  public function removeItem($item)
  {
    $db = static::getDB();

    $stmt = $db->prepare("DELETE cart_items.* FROM cart_items INNER JOIN cart on cart_items.cart_id = cart.id WHERE cart.user_id = :user AND cart_items.product_id = :product");
    $stmt->bindValue(':user', intval($_SESSION['user']), \PDO::PARAM_INT);
    $stmt->bindValue(':product', intval($item), \PDO::PARAM_INT);
    return $stmt->execute() ? true : false;
  }

  private function itemIsAlreadyInCart($item, $cart_id)
  {
    $db = static::getDB();

    $stmt = $db->prepare("SELECT * FROM cart_items WHERE product_id = :product AND cart_id = :cart");
    $stmt->bindValue(':product', intval($item), \PDO::PARAM_INT);
    $stmt->bindValue(':cart', intval($cart_id), \PDO::PARAM_INT);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
  }
}