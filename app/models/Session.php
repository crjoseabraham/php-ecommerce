<?php 
/*	Session Model Class
	Storing all sessions data
*/
class Session
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function login($user_id)
	{
		if (!isset($_SESSION))
		{
			session_id(uniqid());
			session_start();
			$_SESSION["user_id"] = $user_id;
			$_SESSION["is_logged_in"] = true;
			$_SESSION["session_start_time"] = date("Y-m-d H:i:s");
			$_SESSION["cash"] = 100;
		}
	}

	public function logout()
	{
		unset($_SESSION["user_id"]);
		unset($_SESSION["is_logged_in"]);
		unset($_SESSION["session_start_time"]);
		unset($_SESSION["cash"]);

		session_destroy();
	}

	public function isUserLoggedIn() 
	{
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_logged_in']))
			return false;
		else 
			return true;
	}

	public function registerSession(string $user_id, string $session_id, string $session_start_time)
	{
		$this->db->query("INSERT INTO `session` VALUES (:sessionid, :userid, :starttime, null, 1)");
		$this->db->bind(':sessionid', $session_id);
		$this->db->bind(':userid', $user_id);
		$this->db->bind(':starttime', $session_start_time);
		$this->db->execute();
	}

	public function getSessionValue($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/*
	public function isUserLoggedIn() 
	{
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_logged_in'])) {
			return false;
		} else {
			return true;
		}
	}
	*/
}