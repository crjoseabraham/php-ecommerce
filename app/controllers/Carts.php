<?php 
/**
 *  Cart Class Controller
 *	Performs all actions refered to the cart: show list, add to cart,
 *	delete from cart and process payment
 */
class Carts extends Controller
{
	
	public function __construct()
	{
		$this->product = $this->createModel('Product');
 		$this->cart = $this->createModel('Cart');
 		parent::__construct();

		if (!isset($_SESSION)) {
			session_start();
		}

	}
	
	/**	
	* Add item to cart
	* Sanitize $_POST data before sending it to the model
	* @return void
	*/
	public function add() : void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if (intval($_POST['quantity']) > 0) {
				$cartId = $this->getCartId($_SESSION['user_id']);
				$price = $this->product->getProductAtt($_POST['product_id'], 'price');

				$data = [
					"user" => $_SESSION['user_id'],
					"cart" => $cartId,
					"product" => $_POST['product_id'],
					"quantity" => $_POST['quantity'],
					"subtotal" => $_POST['quantity'] * $price 
				];

				$this->cart->addItem($data);
			}
			else
				echo "Invalid value.";			
		}

		header('Location: ' . URLROOT);
	}

	/**
	* Delete item from cart
	* @return void
	*/ 
	public function delete() : void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($this->cart->deleteItem(intval($_POST['product_id']))) 
				header('Location: ' . URLROOT);
			else
				echo "Something went wrong";
		} else {
			echo "GET";
		}
	}

	public function getCartId($userId)
	{
		return $this->cart->getCartIdByUser($userId);
	}

	/**
	* Set Error Message
	* Get all items, find the one where the error message should be, and set the message
	* @param string 	Message to show
	* @return array 	Data with error message
	*/ 
	private function setErrorMessage(string $message) : array
	{
		$data = $this->product->getItems();
		foreach ($data as &$item) {
			if ($item['product_id'] == $_POST['product_id']) 
				$item['quantity_err'] = "*$message";
		}
		return $data;
	}
}