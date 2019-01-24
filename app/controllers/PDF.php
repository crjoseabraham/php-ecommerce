<?php 
require_once APPROOT . '\\libs\\fpdf.php';

/**
 * PDF
 */
class PDF extends FPDF
{	
	public function __construct()
	{
		require_once APPROOT . '\\app\\models\\User.php';
		require_once APPROOT . '\\app\\models\\Cart.php';
		require_once APPROOT . '\\app\\models\\Order.php';
		require_once APPROOT . '\\app\\models\\Session.php';

		$this->user = new User;
		$this->session = new Session;
		$this->cart = new Cart;
		$this->order = new Order;
		parent::__construct();

		session_start();
		if (!$this->session->isUserLoggedIn()) {
			session_regenerate_id();
		}
	}

	public function printReceipt()
	{
		$user = $this->session->getSessionValue('user_id');
		$order = $this->order->getOrder(38);
		$order_details = $this->order->getOrderItems($order['order_id']);

		$this->AddPage();
		$this->SetFont('Arial','B',12);
		$this->Cell(50, 6, "User ID: $user", 0, 'L');
		$this->Ln();
		$this->Cell(50, 6, "Order ID:" . $order['order_id'], 0, 'L');	
		$this->Ln();
		$this->Ln();
		$this->Cell(30, 6, "Product", 1, 'C');
		$this->Cell(30, 6, "Quantity", 1, 'C');
		$this->Cell(30, 6, "Subtotal", 1, 'C');
		$this->Ln();
		foreach ($order_details as $item) {
			$this->Cell(30, 6, $item['product_id'], 1, 'C');
			$this->Cell(30, 6, $item['quantity'], 1, 'C');
			$this->Cell(30, 6, $item['subtotal'], 1, 'C');
			$this->Ln();
		}
		
		$this->Output();
	}
}