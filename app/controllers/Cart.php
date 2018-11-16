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
	}

	public function add(array $params)
	{
		echo "
		Params: <br>
		<pre>";
		var_dump($params);
		echo "</pre>";
	}

	public function delete(array $params)
	{
		echo "Delete";
	}
}