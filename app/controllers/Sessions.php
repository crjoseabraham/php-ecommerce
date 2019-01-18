<?php
/* 	Session Controller Class
	Manage PHP $_SESSIONS,
	! Router class might need extending this class or vice versa
	Verify user data (login)
*/
class Sessions extends Controller
{
	private $cash;
	
	public function __construct()
	{
		$this->sessionModel = $this->createModel('Session');
	}

	public function login()
	{
		$user = $_POST["login_email"];
		$pass = $_POST["login_password"];

		$verifiedUser = $this->sessionModel->verify($user, $pass);

		if (count($verifiedUser)) {
			var_dump($verifiedUser);
			session_start();
			$_SESSION["user_id"] = $verifiedUser[0]["id"];
			$_SESSION["is_logged_in"] = true;
			$_SESSION["session_start_time"] = time();
			$_SESSION["cash"] = 100;

			if ($this->sessionModel->registerSession($verifiedUser[0]["id"], session_id(), $_SESSION["session_start_time"])) {
				echo "true";
				header('Location: ' . URLROOT . '/products/home');
			} else {
				echo "false";
			}
		} else {
			//Load view with error messsage
			echo "Error";
		}
	}

	public function home()
	{
		$this->loadView('dashboard');
	}

	public function isUserLoggedIn() 
	{
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_logged_in'])) {
			return false;
		} else {
			return true;
		}
	}
}