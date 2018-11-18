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
	 * 	@param int 	Product ID
	 * 	@param int 	Quantity to add
	 *	@param float 	Quantity * Product's price
	 */
	public function addItem(int $id, int $quantity, float $subtotal) : bool
	{
		$this->db->query("INSERT INTO cart_details VALUES (:id, :q, :subt)");
		$this->db->bind(':id', $id);
		$this->db->bind(':q', $quantity);
		$this->db->bind(':subt', $subtotal);
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}
}