<?php
namespace App\Model;

use App\Core\Database;

class Cart extends Database {

    /**
     * This method is called right after a new user is registered
     * Creates associated cart to the new user
     * @param  object   User ID
     * @return void
     */
    public function createCart($user) : void {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO cart (`user_id`) VALUES(:id)");
        $stmt->bindValue(':id', $user, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Get current user's cart items
     *
     * @return mixed    Array if ev. ok, false if error
     */
    public static function getCart() {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT `cart_items`.`product_id`, `product`.`description`, `product`.`price`, `cart_items`.`quantity`, `cart_items`.`size`, `product`.`discount`, `cart_items`.`subtotal` FROM `user` RIGHT JOIN `cart` ON `user`.`id` = `cart`.`user_id` RIGHT JOIN `cart_items` ON `cart`.`id` = `cart_items`.`cart_id` INNER JOIN `product` ON `cart_items`.`product_id` = `product`.`product_id` WHERE `user`.`id` = :u");
        $stmt->bindValue(':u', $_SESSION['user'], \PDO::PARAM_INT);
        return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
    }

    /**
     * Utility. Get corresponding cart ID from 'cart' table for the current user
     *
     * @return mixed
     */
    public function getUsersCartId() {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT `id` FROM `cart` WHERE `user_id` = :u");
        $stmt->bindValue(':u', $_SESSION['user'], \PDO::PARAM_INT);
        return $stmt->execute() ? $stmt->fetchColumn() : null;
    }

    /**
     * Find an item in the current user's cart by its ID
     *
     * @param integer $item
     * @return mixed            The item data if it was found. Or "null" if not
     */
    public function findItemInCart(int $item) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `cart_items` LEFT JOIN `cart` ON `cart_items`.cart_id = `cart`.id AND `cart`.user_id = :u WHERE `cart_items`.product_id = :i;");
        $stmt->bindValue(':u', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->bindValue(':i', $item, \PDO::PARAM_INT);
        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : null;
    }

    /**
     * Add an item to the cart
     *
     * @param int $cart
     * @param int $item
     * @param string $size
     * @param int $quantity
     * @param float $subtotal
     * @return void
     */
    public function addItem($cart, $item, $size, $quantity, $subtotal) : void {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `cart_items` VALUES(:c, :i, :si, :q, :su)");
        $stmt->bindValue(':c', $cart, \PDO::PARAM_INT);
        $stmt->bindValue(':i', $item, \PDO::PARAM_INT);
        $stmt->bindValue(':si', $size, \PDO::PARAM_STR);
        $stmt->bindValue(':q', $quantity, \PDO::PARAM_INT);
        $stmt->bindValue(':su', $subtotal, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Update an item's values (quantity, subtotal) that are already in the cart
     *
     * @param int $cart
     * @param int $item
     * @param string $size
     * @param int $quantity
     * @param float $subtotal
     * @return void
     */
    public function updateItem($cart, $item, $size, $quantity, $subtotal) : void {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `cart_items` SET `size` = :si, `quantity` = :q, `subtotal` = :su WHERE `cart_id` = :c AND `product_id` = :i");
        $stmt->bindValue(':si', $size, \PDO::PARAM_STR);
        $stmt->bindValue(':q', $quantity, \PDO::PARAM_INT);
        $stmt->bindValue(':su', $subtotal, \PDO::PARAM_STR);
        $stmt->bindValue(':c', $cart, \PDO::PARAM_INT);
        $stmt->bindValue(':i', $item, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Remove an item from the cart
     *
     * @param int $cart         Cart ID
     * @param int $item         Item ID
     * @return void
     */
    public function deleteItem(int $cart, int $item) : void {
        $db = static::getDB();
        $stmt = $db->prepare("DELETE FROM `cart_items` WHERE `cart_id` = :c AND `product_id` = :i");
        $stmt->bindValue(':c', $cart, \PDO::PARAM_INT);
        $stmt->bindValue(':i', $item, \PDO::PARAM_INT);
        $stmt->execute();
    }

//   /**
//    * Get data from table 'cart'. Mostly and utility function
//    * @param  int    User's id
//    * @return mixed  Array if records found, false if not
//    */
//   public function getUserCartId($user)
//   {
//     $db = static::getDB();
//     $stmt = $db->prepare("SELECT * FROM cart WHERE user_id = :user");
//     $stmt->bindValue(':user', $user, \PDO::PARAM_STR);
//     return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
//   }

//   /**
//    * Get cart items for the current user
//    * @return mixed  Array if records found, false if not
//    */
//   public function cartItems()
//   {
//     $db = static::getDB();
//     $stmt = $db->prepare("SELECT cart_items.* FROM cart_items INNER JOIN cart on cart_items.cart_id = cart.id WHERE cart.user_id = :user");
//     $stmt->bindValue(':user', intval($_SESSION['user_id']), \PDO::PARAM_INT);
//     return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
//   }

//   /**
//    * Get cart total;
//    * @return float    Total
//    */
//   public function cartTotal()
//   {
//     $cart = self::cartItems();
//     $subtotal = 0;
//     foreach ($cart as $item)
//     {
//       $subtotal += $item->subtotal;
//     }

//     return $subtotal;
//   }

//   /**
//    * Add item to cart, if the item is already there then updates de information
//    * @param object $item      Gotten item data from Product::getItem()
//    * @param int    $quantity  Quantity the user wants to add
//    * @return boolean          True if everything ok, false if not
//    */
//   public function addItem($item, $quantity) : bool
//   {
//     if (!preg_match('/[^\d+]/', $quantity))
//     {
//       $userCart = self::getUserCartId($_SESSION['user_id']);
//       $db = static::getDB();

//       // First check if the item is in the cart already, if so, update quantity and subtotal
//       if (self::itemIsAlreadyInCart($item->product_id, $userCart->id))
//         $stmt = $db->prepare("UPDATE cart_items SET quantity = :quantity, subtotal = :subtotal WHERE product_id = :item AND cart_id = :cart");
//       else
//         $stmt = $db->prepare("INSERT INTO cart_items VALUES(:cart, :item, :quantity, :subtotal)");

//       $stmt->bindValue(':cart', intval($userCart->id), \PDO::PARAM_INT);
//       $stmt->bindValue(':item', intval($item->product_id), \PDO::PARAM_INT);
//       $stmt->bindValue(':quantity', intval($quantity), \PDO::PARAM_INT);
//       $stmt->bindValue(':subtotal', ($item->price * intval($quantity)), \PDO::PARAM_STR);
//       return $stmt->execute() ? true : false;
//     }
//     else
//       return false;
//   }

//   /**
//    * Remove an item from the cart
//    * @param  int      ID of item to remove
//    */
//   public function removeItem($item)
//   {
//     $db = static::getDB();

//     $stmt = $db->prepare("DELETE cart_items.* FROM cart_items INNER JOIN cart on cart_items.cart_id = cart.id WHERE cart.user_id = :user AND cart_items.product_id = :product");
//     $stmt->bindValue(':user', intval($_SESSION['user_id']), \PDO::PARAM_INT);
//     $stmt->bindValue(':product', intval($item), \PDO::PARAM_INT);
//     echo json_encode($stmt->execute() ? true : false);
//   }

//   /**
//    * Check if an item is already in the user's cart
//    * @param  int  $item     ID of item to check
//    * @param  int  $cart_id  ID of corresponding cart
//    * @return mixed          Array if item was found, false if not.
//    */
//   private function itemIsAlreadyInCart($item, $cart_id)
//   {
//     $db = static::getDB();

//     $stmt = $db->prepare("SELECT * FROM cart_items WHERE product_id = :product AND cart_id = :cart");
//     $stmt->bindValue(':product', intval($item), \PDO::PARAM_INT);
//     $stmt->bindValue(':cart', intval($cart_id), \PDO::PARAM_INT);
//     return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
//   }

//   /**
//    * Empty cart
//    */
//   public function emptyCart()
//   {
//     $db = static::getDB();
//     $stmt = $db->prepare("TRUNCATE `cart_items`");
//     $stmt->execute();
//   }
}