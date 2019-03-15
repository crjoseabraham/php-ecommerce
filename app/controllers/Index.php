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
			$this->userData = $this->user->getUserByEmail(strtolower($_POST['login_email']));

			// 2. Now verify that submittedPassword match userData
			$correctPassword = $this->user->verifyPassword($_POST['login_password'], $this->userData['password']);

			if(!$correctPassword || !$this->userData)
				die("Incorrect email or password.");
			else {
				// 3. If user left session unclosed, close it
				$oldSessionId = $this->session->isSessionActive($this->userData['id']);
				if (isset($oldSessionId))
					$this->session->registerSessionLogout($oldSessionId, date('Y-m-d H:i:s'));

				// 4. Create SESSION data
				$this->session->login($this->userData['id']);
				$this->session->registerSessionLogin($this->userData['id'], session_id(), date("Y-m-d H:i:s"));
			}
		}

		header('Location: ' . URLROOT . '/index/home');
	}

	/**
	 * Logout Controller
	 * @return void
	 */
	public function logout() : void
	{
		if (!$this->session->logout())
			die("Something went wrong when session->logout");

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
		if (isset($_SESSION['user_id']) && $_SESSION['is_logged_in']) {
			$data = [];
			$data["cart"] = $this->cart->getCart($this->session->getSessionValue('user_id'));
			$data["product"] = $this->product->getProducts();
			$data["user"] = $this->user->getUserById($this->session->getSessionValue('user_id'));
			$data["receipt"] = $this->order->getOrdersByUser($this->session->getSessionValue('user_id'));

			$this->loadView('dashboard', $data);
		} else
			$this->loadView('index');
	}
}