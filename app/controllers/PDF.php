<?php 
require_once APPROOT . '\\libs\\fpdf.php';

/**
 * PDF Class
 * Renders PDF to show order's details (receipt)
 */
class PDF extends FPDF
{	
	public function __construct()
	{
		require_once APPROOT . '\\app\\models\\User.php';
		require_once APPROOT . '\\app\\models\\Cart.php';
		require_once APPROOT . '\\app\\models\\Order.php';
		require_once APPROOT . '\\app\\models\\Product.php';
		require_once APPROOT . '\\app\\models\\Session.php';

		$this->user = new User;
		$this->session = new Session;
		$this->cart = new Cart;
		$this->order = new Order;
		$this->product = new Product;
		parent::__construct();

		session_start();
		if (!$this->session->isUserLoggedIn())
			session_regenerate_id();
	}

	/**
	 * Print receipt
	 * @return void
	 */
	public function printReceipt() : void
	{
		$user = $this->session->getSessionValue('user_id');
		$order['order_data'] = $this->order->getOrder($_POST['print_orderId']);
		$order['order_items'] = $this->order->getOrderItems($order['order_data']['order_id']);

		$this->AddPage();
		$this->SetFont('Arial','B',12);
		$this->Cell(50, 6, "User ID: $user", 0, 'L');
		$this->Ln();
		$this->Cell(50, 6, "Order ID: " . $order['order_data']['order_id'], 0, 'L');
		$this->Ln();
		$this->Cell(50, 6, "Order date: " . $order['order_data']['created_at'], 0, 'L');
		$this->Ln();
		$this->Ln();
		$this->Cell(10, 6, "ID", 1, 'C');
		$this->Cell(30, 6, "Product", 1, 'C');
		$this->Cell(30, 6, "Quantity", 1, 'C');
		$this->Cell(30, 6, "Subtotal", 1, 'C');
		$this->Ln();
		foreach ($order['order_items'] as $item) {
			$this->Cell(10, 6, $item['product_id'], 1, 'C');
			$this->Cell(30, 6, $this->product->getProductAtt($item['product_id'], 'description'), 1, 'C');
			$this->Cell(30, 6, $item['quantity'], 1, 'C');
			$this->Cell(30, 6, '$' . $item['subtotal'], 1, 'C');
			$this->Ln();
		}
		$this->Ln();
		$this->Cell(40, 6, 'Transport type: ', 0, 'L');
		$this->Cell(50, 6, ($order['order_data']['transport_costs'] === '4') ? 'UPS  (+ $4)' : 'Pick Up (+ $0)', 0, 'L');
		$this->Ln();
		$this->Cell(40, 6, 'Total: ', 0, 'L');
		$this->Cell(50, 6, '$' . $order['order_data']['total'], 0, 'L');
		
		$this->Output();
	}
}