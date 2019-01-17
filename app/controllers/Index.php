<?php 
/**
 * Index redirects or whatevere
 */
class Index extends Controller
{
	
	function __construct()
	{
		echo "This is Index Controller <br>";
		$this->sessionsModel = $this->createModel("Session");
	}

	public function verify()
	{
		// 1) If there is a session started -> dashboard, else -> login
		if (isset($_SESSION))
			$this->loadView('dashboard');
		else
			$this->loadView('index');
	}

	private function login()
	{

	}

	private function dashboard()
	{

	}
}