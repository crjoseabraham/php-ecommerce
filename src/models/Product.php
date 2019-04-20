<?php 
namespace Model;

use \App\Database;

/**
 * Product class
 * Get data from 'product' table in the database
 */
class Product extends Database
{
  /**
   * Get all products
   * @return mixed  Array if records found, false if not
   */
  public function getAll()
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM product");
    return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Get item by its ID
   * @param  int $id  ID of item to search for
   * @return mixed    Array if records found, false if not
   */
  public function getItem($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM product WHERE product_id = :id");
    $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }
}