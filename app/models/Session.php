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
		$_SESSION["user_id"] = $user_id;
		$_SESSION["is_logged_in"] = true;
		$_SESSION["session_start_time"] = date("Y-m-d H:i:s");
		$_SESSION["cash"] = 100;
	}

	public function logout()
	{
		if ($this->registerSessionLogout(session_id(), date("Y-m-d H:i:s"))) {
			unset($_SESSION["user_id"]);
			unset($_SESSION["is_logged_in"]);
			unset($_SESSION["session_start_time"]);
			unset($_SESSION["cash"]);
			session_destroy();
			return true;
		} else {
			return false;
		}
	}

	public function isUserLoggedIn() 
	{
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_logged_in']))
			return false;
		else 
			return true;
	}

	public function registerSessionLogin(string $user_id, string $session_id, string $session_start_time) : void
	{
		$this->db->query("INSERT INTO `session` VALUES (:sessionid, :userid, :starttime, null, 1)");
		$this->db->bind(':sessionid', $session_id);
		$this->db->bind(':userid', $user_id);
		$this->db->bind(':starttime', $session_start_time);
		$this->db->execute();
	}

	// Update session data to set 'session_end_time' and 'status'
	public function registerSessionLogout(string $session_id, string $session_end_time)
	{
		$this->db->query("UPDATE `session` SET `end` = :sessionend, `status` = 0 WHERE session_id = :sessionid");
		$this->db->bind(':sessionend', $session_end_time);
		$this->db->bind(':sessionid', $session_id);
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function isSessionActive(string $user_id) : bool
	{
		$this->db->query("SELECT status FROM `session` WHERE user_id = :userid AND status = 1");
		$this->db->bind(':userid', $user_id);
		return $this->db->resultSingleValue();
	}

	public function getSessionValue($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}
}