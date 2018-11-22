<?php 
/**
 * Cart Actions Model Class
 * Performs all requests to the database respect to what's in the shopping cart
 */
class CartActions
{
	private $db;
	
	public function __construct()
	{
		$this->db = new Database;
	}

	public function getCart() : array
	{
		$this->db->query("SELECT * FROM cart_details");
		return $this->db->resultSet();
	}

	/**
	 *  Insert item into database's table 'cart_details'
	 * 	@param array 	Product ID, Quantity to add, Subtotal
	 */
	public function addItem(array $data) : bool
	{
		// First check if the item is already in the cart
		$cartItems = $this->getCart();
		foreach ($cartItems as $item) {
			// If so, then replace database data with $data
			if ($item['cart_product_id'] === $data['id']) {
				$this->db->query("UPDATE cart_details SET quantity = :q, subtotal = :subt WHERE cart_product_id = :id");
				$this->db->bind(':q', $data['quantity']);
				$this->db->bind(':subt', $data['subtotal']);
				$this->db->bind(':id', $data['id']);
				if ($this->db->execute()) {
					return true;
				} else {
					return false;
				}
			}
		}

		// Otherwise, add new record to cart table
		$this->db->query("INSERT INTO cart_details VALUES (:id, :q, :subt)");
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':q', $data['quantity']);
		$this->db->bind(':subt', $data['subtotal']);
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}
}