<?php 
/**
 *  Products Class Controller
 *	Show lists of products
 */

class Products extends Controller
{
	public function __construct()
	{
		$this->productModel = $this->createModel('Product');
		$this->cartModel = $this->createModel('CartActions');
	}

	/**
	 *  Load index view
	 */
	public function home() : void
	{
		$products = $this->productModel->getItems();
		$cartItems = $this->cartModel->getCart();
		$this->loadView('index', $products, $cartItems);
	}
}