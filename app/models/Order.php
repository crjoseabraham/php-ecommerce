<?php
/**
 * Order Model Class
 * Performs all requests related to purchases
 */
class Order
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	/**
	 * Get order row
	 * @param  string $orderId Order ID
	 * @return array           Order data
	 */
	public function getOrder($orderId) : array
	{
		$this->db->query("SELECT * FROM `order` WHERE order_id = :id");
		$this->db->bind(':id', $orderId);
		return $this->db->resultSingle();
	}

	/**
	 * Get all orders for a specific user
	 * @param  string $userId User ID
	 * @return array          Arrays array containing all orders
	 */
	public function getOrdersByUser($userId) : array
	{
		$this->db->query("SELECT * FROM `order` WHERE user_id = :id");
		$this->db->bind(':id', $userId);
		return $this->db->resultSet();
	}

	/**
	 * Get order details
	 * @param  string $orderId Order ID
	 * @return array           Arrays array containing all from order_items
	 */
	public function getOrderItems($orderId) : array
	{
		$this->db->query("SELECT * FROM `order_items` WHERE order_id = :id ORDER BY product_id ASC");
		$this->db->bind(':id', $orderId);
		return $this->db->resultSet();
	}

	/**
	 * Register a new order
	 * @param  array  $data User ID, Cart ID, Purchase date and time, transport costs, total
	 * @return boolean
	 */
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

	/**
	 * Load cart_items rows to order_items
	 * order_items contains the details of the order
	 * Same as cart_items but stored once purchased is completed
	 * @param string $cartId Cart ID
	 * @return boolean
	 */
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