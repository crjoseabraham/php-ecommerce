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
		if (!$this->session->isUserLoggedIn()) {
			session_regenerate_id();
		}
	}

	public function vote()
	{
		// 1. First check if user already voted this item
		if ($this->userAlreadyVoted($_POST['product_id'], session_id())) {
			// Show error message
			echo "You already voted this item. You can vote only once per session";
			// 2. Then let's proceed with their request
		} else { 
			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				if($this->rating->addRating($_POST['product_id'], $_POST['rating_value'], session_id()))
				header('Location: ' . URLROOT);
			}
		}
	}

	private function userAlreadyVoted($productId, $sessionId) : bool
	{
		return $this->rating->checkRepeatedVote($productId, $sessionId);
	}
}