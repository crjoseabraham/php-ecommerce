<?php
namespace App\Controller;

use App\Model\Product;

class Products {

    public function getProducts() {
        return (new Product())->getAll();
    }
}