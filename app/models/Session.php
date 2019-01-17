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
}