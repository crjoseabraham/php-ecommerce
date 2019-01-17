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
		$this->cartModel = $this->createModel('Cart');
	}

	public function getItems() : array
	{
		$products = $this->productModel->getItems();
		return $products;
	}

	public function getCart() : array
	{
		$cart = $this->cartModel->getCart();
		return $cart;
	}
	
	/**
	 *  Load index view
	 */
	public function home() : void
	{
		session_start();
		$this->loadView('dashboard', [$this->getItems(), $this->getCart()]);
	}
}