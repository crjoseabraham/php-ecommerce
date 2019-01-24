<?php
/*
	Calculate total
	1. First get SUM(subtotal) FROM cart_items
	2. Add transport costs to (1)
	3. Register order
	4. Move cart_items rows to order_items
	   4.b. Empty cart_items
	5. Subtract total from $_SESSION['cash']
 */
class Payment
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function registerOrder(int $user_id, string $created_at, float $total_amount)
	{
		$this->db->query("INSERT INTO `order` VALUES (null, :user, :created, :total)");
		$this->db->bind(':user', $user_id);
		$this->db->bind(':created', $created_at);
		$this->db->bind(':total', $total_amount);
		if ($this->db->execute()) return true;
		return false;
	}
}