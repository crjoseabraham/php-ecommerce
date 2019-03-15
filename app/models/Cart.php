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
	 * After User is registered, this function is called
	 * to create new user's cart
	 * @param  array  $user User data
	 * @return void
	 */
	public function createNewUserCart(array $user) : void
	{
		$this->db->query("INSERT INTO cart (user_id) VALUES (:user)");
		$this->db->bind(':user', $user['id']);
		$this->db->execute();
	}

	/**
	* Get all items in user's cart
	* @param string $user_id User's ID to retrieve corresponding cart
	* @return array All items
	*/ 
	public function getCart($user_id) : array
	{
		$cartId = $this->getCartIdByUser($user_id);
		$this->db->query("SELECT * FROM cart_items WHERE cart_id = :cartid");
		$this->db->bind(":cartid", $cartId);
		return $this->db->resultSet();
	}

	/**
	* Get cart ID based on user's id
	* @param 	string $user_id User's ID to retrieve corresponding cart ID
	* @return 	string 			Cart ID 
	*/
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
	public function addItem(array $data) : void
	{
		$this->db->query("INSERT INTO cart_items VALUES (:cart, :product, :q, :subt)");
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
	* @return void
	*/ 
	public function updateItem(array $data) : void
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

	/**
	 * Sum all 'subtotal' values from user's cart to get purchase total
	 * @param  string $cart_id 	Cart ID
	 * @return float 			Purchase total amount
	 */
	public function getSubtotalSum($cart_id) : float
	{
		$this->db->query("SELECT SUM(subtotal) FROM cart_items WHERE cart_id = :id");
		$this->db->bind(':id', $cart_id);
		return floatval($this->db->resultSingleValue());
	}

	/**
	 * Check if X item is already on user's cart
	 * @param  array 	$data 	Product ID, Cart ID
	 * @return boolean			true if item is in cart, false if not
	 */
	public function isItemInCart($data) : bool
	{
		$this->db->query("SELECT * FROM cart_items WHERE product_id = :product AND cart_id = :cart");
		$this->db->bind(':product', $data['product']);
		$this->db->bind(':cart', $data['cart']);
		return !!$this->db->resultSingleValue();
	}

	/**
	 * Empty cart
	 * @param  int    $cart_id Cart ID
	 * @return void
	 */
	public function emptyCart(int $cart_id) : void
	{
		$this->db->query("DELETE FROM cart_items WHERE cart_id = :cart");
		$this->db->bind(':cart', $cart_id);
		$this->db->execute();
	}
}