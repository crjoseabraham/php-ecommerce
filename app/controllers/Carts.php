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
 		$this->order = $this->createModel('Order');
 		parent::__construct();

		if (!isset($_SESSION))
			session_start();
	}

	/**
	 * Get cart ID by sending user's ID
	 * @param  string $userId User ID
	 * @return string 				Cart ID
	 */
	public function getCartId($userId) : string
	{
		return $this->cart->getCartIdByUser($userId);
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

				if ($this->cart->isItemInCart($data))
					$this->cart->updateItem($data);
				else
					$this->cart->addItem($data);
			}
			else
				die("Invalid value.");
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
				die("Something went wrong. Item could not be deleted");
		}
	}

	/**
	 * Process payment
	 * @return void
	 */
	public function pay()
	{
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['transport-type'] === '0' ||	$_POST['transport-type'] === '4')) {
			$data = [
				'user' => $_SESSION['user_id'],
				'cart' => $this->getCartId($_SESSION['user_id']),
				'transport' => intval($_POST['transport-type']),
				'datetime' => date("Y-m-d H:i:s")
			];

			// 1. Get total amount
			$subtotal = $this->cart->getSubtotalSum($this->cart->getCartIdByUser($data['user']));
			if (!$subtotal) die("No items in cart"); 
			$data['total'] = round(($subtotal + $data['transport']), 2);

			// 2. If total is less than user's cash then payment can proceed
			if ($data['total'] < $_SESSION['cash']) {
				$_SESSION['cash'] -= $data['total'];

			// 3. Register purchase order
				if ($this->order->registerOrder($data))
					$this->order->setOrderItems($data['cart']);
				else 
					die("Order couldn't be registered");

			// 4. Empty cart
				$this->cart->emptyCart($data['cart']);
			}	else die("Not enough money");
		}	else die("You have to select transport type");

		header('Location: ' . URLROOT); 
	}
}