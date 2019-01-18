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

	public function verify(string $user, string $password) : array
	{
		$this->db->query("SELECT * FROM user WHERE email = :user AND password = :password");
		$this->db->bind(':user', $user);
		$this->db->bind(':password', $password);
		return $this->db->resultSet();
	}

	public function registerSession(string $user_id, string $session_id, string $session_start_time)
	{
		$this->db->query("INSERT INTO `session` VALUES (:sessionid, :userid, :sessionstart, null, 1)");
		$this->db->bind(':sessionid', $session_id);
		$this->db->bind(':userid', $user_id);
		$this->db->bind(':sessionstart', $session_start_time);
		
		if ($this->db->execute()) {
			return true;
		}

		return false;
	}
}