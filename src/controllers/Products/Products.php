<?php
namespace Controller;

use \Model\Product;
use \Model\Session;

class Products
{
  /**
   * Get an object containing all products
   * @return object Products
   */
  public function getAllProducts()
  {
    return Product::getAll();
  }

  /**
   * Check if specific product exists in the dabatase
   * @param  int $product_id    ID of the product to check
   * @return mixed              Object with the product info if it was found, false if not
   */
  public function productExists($product_id)
  {
    return Product::getItemById($product_id);
  }
}