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
	}

	/**
	 *  Load index view
	 */
	public function home() : void
	{
		$items = $this->productModel->getItems();
		$this->loadView('index', $items);
	}
}