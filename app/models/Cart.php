<?php 
/**
 * Cart Model Class
 * Performs all requests to the database respect to what's in the shopping cart
 */
class Cart
{
	private $db;
	
	public function __construct()
	{
		$this->db = new Database;
	}

	/**
	* Get all items in the cart
	* @return array 	All items
	*/ 
	public function getCart($user_id) : array
	{
		// First get cart associated to user's id, then get the corresponding cart
		$this->db->query("SELECT * FROM cart WHERE user_id = :userid");
		$this->db->bind(":userid", $user_id);

		$cartID = $this->db->resultSingleValue();

		$this->db->query("SELECT * FROM cart_items WHERE cart_id = :cartid");
		$this->db->bind(":cartid", $cartID);
		return $this->db->resultSet();
	}

	/**
	 *  Insert item into database's table 'cart_details'
	 * 	@param array 	Product ID, Quantity to add, Subtotal
	 */
	public function addItem(array $data) : bool
	{
		// First check if the item is already in the cart
		if ($this->updateItem($data))
			return true;		

		// Otherwise, add new record to cart table
		$this->db->query("INSERT INTO cart_items VALUES (null, :cart, :id, :q, :subt)");
		$this->db->bind(':cart', $data['cart']);
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':q', $data['quantity']);
		$this->db->bind(':subt', $data['subtotal']);
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Update Item
	* If user submits data for an item that is already in the cart
	* then update data instead of inserting it
	* @param string 	Message to show
	* @return array 	Data with error message
	*/ 
	private function updateItem(array $data) : bool
	{
		$cartItems = $this->getCart();
		foreach ($cartItems as $item) {
			// If exists, then replace database data with $data
			if ($item['cart_product_id'] === $data['id']) {
				$this->db->query("UPDATE cart_items SET quantity = :q, subtotal = :subt WHERE product_id = :id");
				$this->db->bind(':q', $data['quantity']);
				$this->db->bind(':subt', $data['subtotal']);
				$this->db->bind(':id', $data['id']);
				if ($this->db->execute()) 
					return true;
				else 
					return false;
			}
		}

		return false;
	}

	/**
	* Delete item from cart
	* @param int 	 Product ID
	* @return bool True if success, False if something is wrong
	*/ 
	public function deleteItem(int $product_id) : bool
	{
		$this->db->query("DELETE FROM cart_items WHERE product_id = :id");
		$this->db->bind(':id', $product_id);
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}
}