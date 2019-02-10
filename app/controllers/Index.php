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
		if (!$this->session->isUserLoggedIn())
			session_regenerate_id();
	}

	/**
	 * Login Controller
	 * @return void
	 */
	public function login() : void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// 1. Get user data by submitted email - Email gets verified here already
			$this->userData = $this->user->getUserByEmail($_POST['login_email']);
			if (!$this->userData) die("Email not found");

			// 2. Now verify that submittedPassword match userData
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

	/**
	 * Logout Controller
	 * @return void
	 */
	public function logout() : void
	{
		if ($this->session->isUserLoggedIn() !== false) {
			$this->session->restoreSession();
			
			if (!$this->session->logout()) 
				die("Something went wrong when session->logout");
		}

		header('Location: ' . URLROOT . '/index/home');
	}

	/**
	 * User Registration Controller
	 * @return void
	 */
	public function signup() : void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$this->session->isUserLoggedIn()) {
			// 1. Sanitize email & password
			$email = $this->user->validateEmail($_POST['signup_email']);
			$password = $this->user->validatePassword($_POST['signup_password'], $_POST['signup_confirm_password']);

			if(!$password)
				die("Invalid Password");

			// 2. Check if email is not already registered
			if ($this->user->isEmailAvailable($email))
			{
				if($this->user->registerNewUser($email, $this->user->encryptPassword($password), date('Y-m-d H:i:s')))
					$this->cart->createNewUserCart($this->user->getUserByEmail($email));
			} else
				die("Email is taken");
		}

		header('Location: ' . URLROOT);
	}

	/**
	 * Home controller
	 * Load home view depending if user's logged in or not
	 * @return void
	 */
	public function home() : void
	{
		$isUserLoggedInData = $this->session->isUserLoggedIn();
		if ($isUserLoggedInData !== false) {
			$this->session->restoreSession();
			$data = [];
			$data["cart"] = $this->cart->getCart($isUserLoggedInData['user_id']);
			$data["product"] = $this->product->getProducts();
			$data["user"] = $this->user->getUserById($isUserLoggedInData['user_id']);
			$data["receipt"] = $this->order->getOrdersByUser($isUserLoggedInData['user_id']);

			$this->loadView('dashboard', $data);
		} else
			$this->loadView('index');
	}
}