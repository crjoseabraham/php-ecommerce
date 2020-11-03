<?php
namespace App\Model\Merchandise;

use App\Core\Database;

class Cart extends Database {

    /**
     * This method is called right after a new user is registered
     * Creates associated cart to the new user
     * @param  int   User ID
     * @return void
     */
    public function create(int $user_id) : void {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `cart` (`user_id`) VALUES(:id)");
        $stmt->bindValue(':id', $user_id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Get current user's cart items
     *
     * @return mixed    Array if ev. ok, false if error
     */
    public static function get() {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT `cart_items`.`product_id`, `product`.`description`, `product`.`price`, `cart_items`.`quantity`, `cart_items`.`size`, `product`.`discount`, `cart_items`.`subtotal` FROM `user` RIGHT JOIN `cart` ON `user`.`id` = `cart`.`user_id` RIGHT JOIN `cart_items` ON `cart`.`id` = `cart_items`.`cart_id` INNER JOIN `product` ON `cart_items`.`product_id` = `product`.`product_id` WHERE `user`.`id` = :u");
        $stmt->bindValue(':u', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Get current user's cart ID
     *
     * @return mixed    ID (int) if found, null if error
     */
    private function getId(object $db) {
        $stmt = $db->prepare("SELECT `id` FROM `cart` WHERE `user_id` = :id");
        $stmt->bindValue(':id', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?? null;
    }

    /**
     * Find an item in the current user's cart
     *
     * @return mixed    Object if item found, null otherwise
     */
    public function find(int $id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `cart_items` INNER JOIN `cart` ON `cart_items`.`cart_id` = `cart`.`id` WHERE `cart_items`.`product_id` = :id AND `cart`.`user_id` = :user");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Add item to the cart
     * @param int $id               Item ID
     * @param array $data           $_POST data (size and quantity)
     * @param float $subtotal       Cart subtotal
     * @return void
     */
    public function add(int $id, array $data, float $subtotal): void {
        $db = static::getDB();
        $cart = $this->getId($db);
        $stmt = $db->prepare("INSERT INTO `cart_items` VALUES(:cart, :item, :size, :quantity, :subtotal)");
        $stmt->bindValue(':cart', $cart, \PDO::PARAM_INT);
        $stmt->bindValue(':item', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $data['quantity'], \PDO::PARAM_INT);
        $stmt->bindValue(':size', $data['size'], \PDO::PARAM_STR);
        $stmt->bindValue(':subtotal', $subtotal, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Updata the values for an item that is already in the cart
     * @param int $id               Item ID
     * @param array $data           $_POST data (size and quantity)
     * @param float $subtotal       Cart subtotal
     * @return void
     */
    public function update(int $id, array $data, float $subtotal): void {
        $sql = "UPDATE `cart_items` SET ";

        if (isset($data['size']))
            $sql .= "`size` = :si, ";
        $sql .= "`quantity` = :q, `subtotal` = :su WHERE `cart_id` = :c AND `product_id` = :i";

        $db = static::getDB();
        $cart = $this->getId($db);
        $stmt = $db->prepare($sql);
        if (isset($data['size']))
            $stmt->bindValue(':si', $data['size'], \PDO::PARAM_STR);
        $stmt->bindValue(':q', $data['quantity'], \PDO::PARAM_INT);
        $stmt->bindValue(':su', $subtotal, \PDO::PARAM_STR);
        $stmt->bindValue(':c', $cart, \PDO::PARAM_INT);
        $stmt->bindValue(':i', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Remove an item from the cart
     * @param  int $item The item's ID
     * @return void
     */
    public function remove(int $item): void {
        $db = static::getDB();
        $stmt = $db->prepare("DELETE `cart_items` FROM `cart_items` LEFT JOIN `cart` ON `cart_items`.`cart_id` = `cart`.`id` WHERE `cart_items`.`product_id` = :id AND `cart`.`user_id` = :user");
        $stmt->bindValue(':id', $item, \PDO::PARAM_INT);
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Delete all records from `cart_items` for a user
     * @param integer $user
     * @return void
     */
    public function empty(int $user): void {
        $db = static::getDB();
        $stmt = $db->prepare("DELETE `cart_items` FROM `cart_items` LEFT JOIN `cart` ON `cart_items`.`cart_id` = `cart`.`id` WHERE `cart`.`user_id` = :user");
        $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
        $stmt->execute();
    }
}