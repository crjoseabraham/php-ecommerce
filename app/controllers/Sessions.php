<?php
/* 	Session Controller Class
	Manage PHP $_SESSIONS,
	! Router class might need extending this class or vice versa
	Verify user data (login)
*/
class Sessions extends Controller
{
	private $cash = 100;
	
	public function __construct()
	{
		$this->user = $_POST['login_email'];
		$this->pass = $_POST['login_password'];
		$this->sessionModel = $this->createModel('Session');
	}

	public function login() : bool
	{
		$verifiedUser = $this->sessionModel->verify($this->user, $this->pass);
		if (count($verifiedUser)) {
			session_start();
			echo session_id();
			return true;
		} else {
			//Load view with error messsage
			echo "Error";
		}
		return false;
	}

	public function home()
	{
		session_start();
		$this->loadView('dashboard');
	}
}