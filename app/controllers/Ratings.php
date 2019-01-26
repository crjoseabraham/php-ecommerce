<?php
/**
 * Rating controller
 * Basically the only thing user can do with the rating system is to submit a value that'll be
 * stored in the database
 */
class Ratings extends Controller
{
	
	public function __construct()
	{
 		$this->rating = $this->createModel('Rating');
 		parent::__construct();
		
		session_start();
		if (!$this->session->isUserLoggedIn())
			session_regenerate_id();
	}

	/**
	 * Submit rating vote
	 * @return void
	 */
	public function vote()
	{
		if ($this->userAlreadyVoted($_POST['product_id'], session_id()))
			die("You already voted this item. You can vote only once per session");
		else { 
			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				if($this->rating->addRating($_POST['product_id'], $_POST['rating_value'], session_id()))
					header('Location: ' . URLROOT);
			}
		}
	}

	/**
	 * Check if user already voted X item during the same session
	 * @param  string $productId ID of product to check
	 * @param  string $sessionId Session ID to compare
	 * @return bool
	 */
	private function userAlreadyVoted($productId, $sessionId) : bool
	{
		return $this->rating->checkRepeatedVote($productId, $sessionId);
	}
}