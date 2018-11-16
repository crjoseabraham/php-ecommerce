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

	public function getItems()
	{
		$this->db->query("SELECT * FROM product");
		return $this->db->resultSet();
	}
}