<?php
namespace App\Controller\Merchandise;

use App\Model\Merchandise\Product;

class Products {

    /**
     * Get all products or a specific one by its ID
     * By default it gets all products
     *
     * @param mixed $id     Item ID
     * @param boolean $all  True for getting all records, False for only one
     * @return mixed
     */
    public function get($id = null, $all = true) {
        $result = $all ? Product::get() : Product::get($id, false);
        // Convert sizes to array
        if (is_array($result) > 0) {
            foreach ($result as &$item) {
                $item->sizes = explode(', ', $item->sizes);
            }
        } else
            $result->sizes = explode(', ', $result->sizes);

        return $result;
    }

    /**
     * Get all items that pass the provided condition
     * Example: get all items with discount
     *
     * @param string $condition     Example: "`discount` > 0"
     * @return mixed
     */
    public function getAllWith(string $condition) {
        return Product::getAllWith($condition);
    }

    /**
     * Calculate an item's final price after applying the discount
     *
     * @param object $item      Item object with its price and discount value
     * @return float            Final price with 2 decimals
     */
    public static function calculateDiscount(object $item): float {
        return round($item->price - ($item->price * ($item->discount / 100)), 2);
    }

    /**
     * Get all items categories
     *
     * @return void
     */
    public function getCategories() {
        return Product::getCategories();
    }
}