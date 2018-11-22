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

	/**
	 *  Insert item into database's table 'cart_details'
	 * 	@param array 	Product ID, Quantity to add, Subtotal
	 */
	public function addItem(array $data) : bool
	{
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

	public function getCart() : array
	{
		$this->db->query("SELECT * FROM cart_details");
		return $this->db->resultSet();
	}
}