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
				"subtotal" => ($_POST['quantity'] * $_POST['price']),
				"quantity_err" => ''
			];
			// If insertion was susccessful
			if ($this->cartModel->addItem($data))
				header('Location: ' . URLROOT);
			else 
				die("Something went wrong");
		} else {
			// If quantity = '', redirects to homepage adding error message
			$data = $this->productModel->getItems();
			foreach ($data as &$item) {
				if ($item['product_id'] == $_POST['product_id']) {
					$item['quantity_err'] = "*This field is required";
				}
			}
			$this->loadView('index', $data);
		}
	}

	public function delete(array $params)
	{
		echo "Delete";
	}
}