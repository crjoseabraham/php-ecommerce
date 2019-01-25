<?php 
/**
 * Index controller
 * To show a different view depending on whether user is logged in or not.
 */
class Index extends Controller
{
	private $cart;
	private $product;

	public function __construct()
	{
		$this->cart = $this->createModel('Cart');
		$this->product = $this->createModel('Product');
		$this->order = $this->createModel('Order');
		parent::__construct();
		session_start();
		if (!$this->session->isUserLoggedIn()) {
			session_regenerate_id();
		}
	}

	public function login() 
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$user = $_POST["login_email"];
			$pass = $_POST["login_password"];
			$verifiedUserId = $this->user->verifyUserData($user, $pass);

			if (!$this->session->isSessionActive($verifiedUserId)) {
				$this->session->login($verifiedUserId);
				$this->session->registerSessionLogin($verifiedUserId, session_id(), date("Y-m-d H:i:s"));
			}
		}

		header('Location: ' . URLROOT . '/index/home');
	}

	public function logout()
	{
		if ($this->session->isUserLoggedIn()) {
			if (!$this->session->logout()) echo "Something went wrong when session->logout()";
		}

		header('Location: ' . URLROOT . '/index/home');
	}

	public function home()
	{
		if ($this->session->isUserLoggedIn()) {
			$data = [];
			$data["cart"] = $this->cart->getCart($this->session->getSessionValue('user_id'));
			$data["product"] = $this->product->getProducts();
			$data["user"] = $this->user->getUserById($this->session->getSessionValue('user_id'));
			$data["receipt"] = $this->order->getOrdersByUser($this->session->getSessionValue('user_id'));

			$this->loadView('dashboard', $data);
		} else {
			$this->loadView('index');
		}		
	}
}