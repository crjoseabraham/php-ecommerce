<?php
/*
	Calculate total
	✔ First get SUM(subtotal) FROM cart_items
	✔ Add transport costs to (1)
	✔ Register order
	4. Move cart_items rows to order_items
	   4.b. Empty cart_items
	5. Subtract total from $_SESSION['cash']
 */
class Order
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function registerOrder(array $data) : bool
	{
		$this->db->query("INSERT INTO `order` VALUES (null, :user, :cart, :created, :transport, :total)");
		$this->db->bind(':user', $data['user']);
		$this->db->bind(':cart', $data['cart']);
		$this->db->bind(':created', $data['datetime']);
		$this->db->bind(':transport', $data['transport']);
		$this->db->bind(':total', $data['total']);
		if ($this->db->execute()) 
			return true;
		return false;
	}
}