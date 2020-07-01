<?php
namespace App\Controller;

use \App\Model\Product;

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
        return $this->model->getAll();
    }

    /**
     * Retrieve the data of an specific product by its ID
     *
     * @param int $id
     * @return array
     */
    public function getItem($id) : array {
        return $this->model->getItemById($id);
    }

    public function getNotReallyRandomProducts() {
        return $this->model->getTestItems();
    }
}