<?php 
namespace Model;

use \App\Database;

class Product extends Database
{
  public function getAll() : array
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM product");
    return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_OBJ) : false;
  }
}