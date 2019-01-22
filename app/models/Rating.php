<?php 
/**
 * Rating Class Model
 * Execute queries to add a rating value for X item and update its average rating
 * Basically a CRU
 */

class Rating
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	/**
	* Select all items from 'product' table
	* @param int 'id' -> Product id
	* @param int 'ratingValue' -> Value from 1 to 5 that user selected
	* @return bool
	*/
	public function addRating(int $id, int $ratingValue, string $session_id) : bool
	{
		$this->db->query("INSERT INTO rating VALUES (null, :id, :val, :session)");
		$this->db->bind(':id', $id);
		$this->db->bind(':val', $ratingValue);
		$this->db->bind(':session', $session_id);
		if ($this->db->execute()) {
			$this->updateRating($this->getAverage($id), $id);
			return true;
		}

		return false;
	}

	/**
	* Get average rating of specific item by ID
	* @param int 'id' -> Product id
	* @return string -> Average rating
	*/
	private function getAverage(int $id) : string
	{
		$this->db->query("SELECT AVG(`rating_value`) as `average` FROM rating WHERE rating_product_id = :id");
		$this->db->bind(':id', $id);
		return $this->db->resultSingleValue();
	}

	/**
	* Update the rating value of specific item on 'product' table
	* @param string 'rating' -> Item new average rating
	* @param int 'id' -> Product id
	* @return bool
	*/
	private function updateRating(string $rating, int $id) : bool
	{
		$this->db->query("UPDATE product SET rating = :rating WHERE product_id = :id");
		$this->db->bind(':rating', $rating);
		$this->db->bind(':id', $id);
		if ($this->db->execute()) 
			return true;
		else 
			return false;
	}

	public function checkRepeatedVote(int $product_id, string $session_id) : bool
	{
		//Check if user already voted that item in current session
		$this->db->query("SELECT * FROM rating WHERE rating_product_id = :id AND session_id = :session");
		$this->db->bind(':id', $product_id);
		$this->db->bind(':session', $session_id);
		if (!$this->db->resultSingleValue())
			return false;
		return true;
	}
}