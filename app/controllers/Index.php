<?php 
/**
 * Index controller
 * To show a different view depending on whether user is logged in or not.
 */
class Index extends Controller
{
	private $cart;
	private $product;
	private $userData;

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
			// Get user data by submitted email - Email gets verified here already
			$this->userData = $this->user->getUserByEmail($_POST['login_email']);
			if (!$this->userData) die("Email not found");

			// Now verify that submittedPassword match userData
			$correctPassword = $this->user->verifyPassword($_POST['login_password'], $this->userData['password']);

			if($correctPassword)
			{
				if (!$this->session->isSessionActive($this->userData['id'])) {
					$this->session->login($this->userData['id']);
					$this->session->registerSessionLogin($this->userData['id'], session_id(), date("Y-m-d H:i:s"));
				}
			} else die("Incorrect");
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

	public function signup()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$this->session->isUserLoggedIn()) {
			// SANITIZE EMAIL & PASSWORD
			$email = $this->user->validateEmail($_POST['signup_email']);
			$password = $this->user->validatePassword($_POST['signup_password'], $_POST['signup_confirm_password']);

			if(!$password)
				die("Invalid Password");

			// CHECK IF EMAIL IS NOT TAKEN
			if ($this->user->isEmailAvailable($email))
			{
				if($this->user->registerNewUser($email, $this->user->encryptPassword($password), date('Y-m-d H:i:s')))
					$this->cart->createNewUserCart($this->user->getUserByEmail($email));
			} else
				die("Email is taken");
			
			header('Location: ' . URLROOT);
		}
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