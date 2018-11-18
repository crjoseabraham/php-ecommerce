<?php 
/**
 *  Cart Class Controller
 *	Performs all actions refered to the cart: show list, add to cart,
 *	delete from cart and process payment
 */
class Cart extends Controller
{
	
	public function __construct()
	{
		$this->cartModel = $this->createModel('CartActions');
	}

	/**
	*	Sanitize $_POST data before sending it to the model
	*/
	public function add() : void
	{
		if (isset($_POST)) {
			$subtotal = $_POST['quantity'] * $_POST['product_price'];
			if ($this->cartModel->addItem($_POST['product_id'], $_POST['quantity'], $subtotal)) {
				header('location: ' . URLROOT);
			} else {
				die('Something went horribly wrong');
			}
		}
	}

	public function delete(array $params)
	{
		echo "Delete";
	}
}