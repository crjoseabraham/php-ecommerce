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
		$this->productModel = $this->createModel('Product');
	}

	/**
	*	Sanitize $_POST data before sending it to the model
	*/
	public function add() : void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['quantity'])) 
		{
			$data = [
				"id" => $_POST['product_id'],
				"quantity" => $_POST['quantity'],
				"subtotal" => ($_POST['quantity'] * $_POST['price'])
			];

			// Check that post quantity is integer
			$pattern = '/^\d[^\.]*$/';
			if (!preg_match_all($pattern, $_POST['quantity'])) {
				$data = $this->setErrorMessage("Invalid value");
				$this->loadView('index', $data);
			}
			// If insertion was susccessful
			if ($this->cartModel->addItem($data))
				header('Location: ' . URLROOT);
			else 
				die("Something went wrong");
		} else {
			// If quantity = '', redirects to homepage adding error message
			$data = $this->setErrorMessage("This field is required");
			$this->loadView('index', $data);
		}
	}

	public function delete(array $params)
	{
		echo "Delete";
	}

	/**
	* Get all items, find the one where the error message should be, and set the message
	* @param string 	Message to show
	* @return array 	Data with error message
	*/ 
	private function setErrorMessage(string $message) : array
	{
		$data = $this->productModel->getItems();
		foreach ($data as &$item) {
			if ($item['product_id'] == $_POST['product_id']) 
				$item['quantity_err'] = "*$message";
		}
		return $data;
	}
}