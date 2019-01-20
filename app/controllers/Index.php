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
		parent::__construct();
	}

	public function login() 
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$user = $_POST["login_email"];
			$pass = $_POST["login_password"];
			$verifiedUser = $this->user->verifyUserData($user, $pass);

			if (count($verifiedUser)) {
				$this->session->login($verifiedUser["id"]);
				$this->session->registerSession($verifiedUser["id"], session_id(), $_SESSION["session_start_time"]);
			} else {
				//Load view with error messsage
				echo "This is 'else' of count($verifiedUser) line 20 Index.php";
				exit();
			}
		}

		$this->home();
	}

	public function logout()
	{
		$this->session->logout();
		header('Location: ' . URLROOT);
	}

	public function home()
	{
		if ($this->session->isUserLoggedIn()) {
			$data = [];
			$data["cart"] = $this->cart->getCart($this->session->getSessionValue('user_id'));
			$data["product"] = $this->product->getProducts();
			$data["user"] = $this->user->getUserById($this->session->getSessionValue('user_id'));

			$this->loadView('dashboard', $data);
		} else {
			var_dump($_SESSION);
			exit();
		}		
	}
}