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

  public function getItem($id)
  {
  	$db = static::getDB();
  	$stmt = $db->prepare("SELECT * FROM product WHERE product_id = :id");
  	$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
  	return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }
}