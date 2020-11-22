<?php
namespace App\Model\Merchandise;

use App\Core\Database;

class Product extends Database {

    /**
     * Get all items in `product` table or just one item
     * @param  mixed $id        ID if it's a single record search, default is null
     * @param  boolean $all     True if it should get all items, false if it's only one
     * @return mixed            Object if item(s) found, null otherwise
     */
    public static function get($id = null, $all = true) {
        $db = static::getDB();
        $sql = "SELECT * FROM `product`";

        if (!is_null($id)) {
            $sql .= " WHERE `product_id` = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
        }
    }

    /**
     * Return all items that pass a provided condition
     * Example: To get items with discount -> "`discount` > 0"
     * @param  string $condition    Condition to find matches for
     * @return mixed                Object if product found, null otherwise
     */
    public static function getAllWith(string $condition) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `product` WHERE {$condition}");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Get all categories
     *
     * @return void
     */
    public static function getCategories() {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `categories`");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? null;
    }
}