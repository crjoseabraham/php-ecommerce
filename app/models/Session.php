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

	/**
	 * Start session variables
	 * @param  string $user_id User ID
	 * @return void
	 */
	public function login($user_id) : void
	{
		$_SESSION["user_id"] = $user_id;
		$_SESSION["is_logged_in"] = true;
		$_SESSION["session_start_time"] = date("Y-m-d H:i:s");
		$_SESSION["cash"] = 100;
	}

	/**
	 * Destroy session, unset session variables
	 * @return boolen
	 */
	public function logout() : bool
	{
		if ($this->registerSessionLogout(session_id(), date("Y-m-d H:i:s"))) {
			unset($_SESSION["user_id"]);
			unset($_SESSION["is_logged_in"]);
			unset($_SESSION["session_start_time"]);
			unset($_SESSION["cash"]);
			session_destroy();
			return true;
		} else
			return false;
	}

	/**
	 * Check if there's a session running
	 * @return boolean
	 */
	public function isUserLoggedIn() : bool
	{
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_logged_in']))
			return false;
		else 
			return true;
	}

	/**
	 * Register session data when logging in
	 * @param  string $user_id            User ID
	 * @param  string $session_id         Session ID
	 * @param  string $session_start_time Datetime value when user started session
	 * @return void
	 */
	public function registerSessionLogin(string $user_id, string $session_id, string $session_start_time) : void
	{
		$this->db->query("INSERT INTO `session` VALUES (:sessionid, :userid, :starttime, null, 1)");
		$this->db->bind(':sessionid', $session_id);
		$this->db->bind(':userid', $user_id);
		$this->db->bind(':starttime', $session_start_time);
		$this->db->execute();
	}

	/**
	 * Register session logout info
	 * Update session data to set 'session_end_time' and 'status'
	 * @param  string $session_id       Session ID
	 * @param  string $session_end_time Datetime value when user logs out
	 * @return bool
	 */
	public function registerSessionLogout(string $session_id, string $session_end_time)
	{
		$this->db->query("UPDATE `session` SET `end` = :sessionend, `status` = 0 WHERE session_id = :sessionid");
		$this->db->bind(':sessionend', $session_end_time);
		$this->db->bind(':sessionid', $session_id);
		if ($this->db->execute()) {
			return true;
		} else
			return false;
	}

	/**
	 * Check if User has already a session running
	 * @param  string  $user_id User ID
	 * @return bool
	 */
	public function isSessionActive(string $user_id) : bool
	{
		$this->db->query("SELECT status FROM `session` WHERE user_id = :userid AND status = 1");
		$this->db->bind(':userid', $user_id);
		return $this->db->resultSingleValue();
	}

	/**
	 * Get specific $_SESSION value
	 * @param  string $key Desired $_SESSION value
	 * @return [type]      Return depends on condition, could be string or false
	 */
	public function getSessionValue($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}
}