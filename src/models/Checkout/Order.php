<?php
namespace App\Model\Checkout;

use App\Core\Database;

class Order extends Database {

    /**
     * Create a new order record
     * @param array $order
     * @return void
     */
    public function new(array $order) {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `orders` VALUES (:id, :user, :dt, :ship, :amt, :stat, null)");
        $stmt->bindValue(':id', $order['id'], \PDO::PARAM_STR);
        $stmt->bindValue(':user', $order['user'], \PDO::PARAM_INT);
        $stmt->bindValue(':dt', $order['created_at'], \PDO::PARAM_STR);
        $stmt->bindValue(':ship', $order['shipping'], \PDO::PARAM_STR);
        $stmt->bindValue(':amt', $order['amount'], \PDO::PARAM_STR);
        $stmt->bindValue(':stat', $order['payment_status'], \PDO::PARAM_BOOL);
        $stmt->execute();
    }

    /**
     * Find an order by its ID
     * @param string $order_id
     * @return void
     */
    public static function find(string $order_id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `orders` WHERE `id` = :order_id");
        $stmt->bindValue(':order_id', $order_id, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Return all orders for X user
     * @param int $user
     * @return void
     */
    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `orders` WHERE `user` = :user");
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Get an order by its ID
     *
     * @param string $invoice_id
     * @return void
     */
    public static function getOrderById(string $invoice_id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `orders` WHERE `orders`.`id` = :id AND `orders`.`user` = :user");
        $stmt->bindValue(':id', $invoice_id, \PDO::PARAM_STR);
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Get an order items by the order's ID
     *
     * @param string $invoice_id
     * @return void
     */
    public static function getOrderItems(string $invoice_id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT `product`.`description`, `order_items`.* FROM `order_items` INNER JOIN `product` ON `order_items`.`product_id` = `product`.`product_id` WHERE `order_id` = :id");
        $stmt->bindValue(':id', $invoice_id, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Update an order status and set payment transaction ID
     * @param string $order_id
     * @param string $transaction_id
     * @param boolean $status
     * @return void
     */
    public function update(string $order_id, string $transaction_id, bool $status) {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `orders` SET `payment_status` = :stat, `payment_id` = :pid WHERE `id` = :order_id");
        $stmt->bindValue(':stat', $status, \PDO::PARAM_BOOL);
        $stmt->bindValue(':pid', $transaction_id, \PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $order_id, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Copy all the items in the cart to the order details table
     * @param integer $user
     * @param string $order_id
     * @return void
     */
    public function submitOrderDetails(int $user, string $order_id) {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `order_items` (order_id, product_id, size, quantity, total) SELECT :order_id, product_id, size, quantity, subtotal FROM `cart_items` RIGHT JOIN `cart` ON `cart_items`.cart_id = `cart`.id WHERE `cart`.`user_id` = :user");
        $stmt->bindValue(':order_id', $order_id, \PDO::PARAM_STR);
        $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
        $stmt->execute();
    }
}