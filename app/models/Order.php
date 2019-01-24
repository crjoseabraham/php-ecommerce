<?php
/*
	Calculate total
	✔ First get SUM(subtotal) FROM cart_items
	✔ Add transport costs to (1)
	✔ Register order
	✔ Move cart_items rows to order_items
	   ✔ Empty cart_items
	✔ Subtract total from $_SESSION['cash']
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

	public function setOrderItems(string $cartId) : bool
	{
		$this->db->query("	INSERT INTO `order_items`
							SELECT order_id, product_id, quantity, subtotal 
							FROM `cart_items`
							INNER JOIN `order` 
							ON `cart_items`.cart_id = `order`.cart_id
							WHERE `cart_items`.cart_id = :cart");
		$this->db->bind(':cart', $cartId);
		if ($this->db->execute())
			return true;
		return false;
	}
}