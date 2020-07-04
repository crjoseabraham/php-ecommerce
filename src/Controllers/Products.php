<?php
namespace App\Controller;

use App\Model\Product;

class Products {

    public function __construct() {
        $this->model = new Product();
    }

    /**

    * Retrieve all products from the database
     *
     * @return void
     */
    public function getProducts() {
        $products = $this->model->getAll();

        foreach ($products as &$product) {
            $product["sizes"] = explode(', ', $product["sizes"]);
        }

        return $products;
    }

    /**
     * Retrieve the data of an specific product by its ID
     *
     * @param int $id
     * @return array
     */
    public function getItem($id) : array {
        $product = $this->model->getItemById($id);
        $product["sizes"] = explode(', ', $product["sizes"]);
        return $product;
    }

    public function getNotReallyRandomProducts() {
        return $this->model->getTestItems();
    }
}