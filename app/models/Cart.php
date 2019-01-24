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
		$cartId = $this->getCartIdByUser($user_id);
		$this->db->query("SELECT * FROM cart_items WHERE cart_id = :cartid");
		$this->db->bind(":cartid", $cartId);
		return $this->db->resultSet();
	}

	public function getCartIdByUser($user_id) : string
	{
		$this->db->query("SELECT id FROM cart WHERE user_id = :userid");
		$this->db->bind(":userid", $user_id);
		return $this->db->resultSingleValue();
	}

	/**
	*  Insert item into database's table 'cart_details'
	*  @param array 	Product ID, Quantity to add, Subtotal
	*/
	public function addItem(array $data)
	{
		$this->db->query("INSERT INTO cart_items VALUES (null, :cart, :product, :q, :subt)");
		$this->db->bind(':cart', $data['cart']);
		$this->db->bind(':product', $data['product']);
		$this->db->bind(':q', $data['quantity']);
		$this->db->bind(':subt', $data['subtotal']);
		$this->db->execute();
	}

	/**
	* Update Item
	* If user submits data for an item that is already in the cart
	* then update data instead of inserting it
	* @param string 	Message to show
	* @return array 	Data with error message
	*/ 
	public function updateItem(array $data)
	{
		$this->db->query("UPDATE cart_items SET quantity = :q, subtotal = :subt WHERE product_id = :productid AND cart_id = :cartid");
		$this->db->bind(':q', $data['quantity']);
		$this->db->bind(':subt', $data['subtotal']);
		$this->db->bind(':productid', $data['product']);
		$this->db->bind(':cartid', $data['cart']);
		$this->db->execute();
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

	public function isItemInCart($data) : bool
	{
		$this->db->query("SELECT * FROM cart_items WHERE product_id = :product AND cart_id = :cart");
		$this->db->bind(':product', $data['product']);
		$this->db->bind(':cart', $data['cart']);
		return !!$this->db->resultSingleValue();
	}

	public function getSubtotalSum($cart_id) : float
	{
		$this->db->query("SELECT SUM(subtotal) FROM cart_items WHERE cart_id = :id");
		$this->db->bind(':id', $cart_id);
		return floatval($this->db->resultSingleValue());
	}
}