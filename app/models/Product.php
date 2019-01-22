<?php 
/**
 * Product Class Model
 * Execute query to retrieve list of products and send it to controller
 */

class Product
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	/**
	* Select all items from 'product' table
	* @return array 
	*/
	public function getProducts() : array
	{
		$this->db->query("SELECT * FROM product");
		return $this->db->resultSet();
	}

	public function getProductAtt(string $productId, string $attribute)
	{
		$this->db->query("SELECT $attribute FROM product WHERE product_id = :id");
		$this->db->bind(':id', $productId);
		return $this->db->resultSingleValue();
	}
}