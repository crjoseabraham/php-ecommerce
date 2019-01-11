<?php
/**
 * Rating controller
 * Basically the only thing user can do with the rating system is to submit a value that'll be
 * stored in the database
 */
class Rate extends Controller
{
	
	public function __construct()
	{
 		$this->ratingModel = $this->createModel('Rating');

 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 			if ($this->ratingModel->addRating($_POST['product_id'], $_POST['rating_value']))
 			{
 				header('Location: ' . URLROOT);
 			} else {
 				echo "Something went wrong";
 			}
 		}
	}
}