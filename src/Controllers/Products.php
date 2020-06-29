<?php
namespace App\Controller;

use App\Model\Product;

class Products {

    public function getProducts() {
        return (new Product())->getAll();
    }

    public function getNotReallyRandomProducts() {
        return (new Product())->getTestItems();
    }

    public function getItem($id) {
        return (new Product())->getItemById($id);
    }
}