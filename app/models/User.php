<?php 
/**
 * Users controller
 * To show a different view depending on whether user is logged in or not.
 */
class User extends Controller
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getUserById($id)
	{
		$this->db->query("SELECT * FROM user WHERE id = :id");
		$this->db->bind(":id", $id);
		return $this->db->resultSingle();
	}

	public function verifyUserData(string $user, string $password) : int
	{
		$this->db->query("SELECT id FROM user WHERE email = :user AND password = :password");
		$this->db->bind(':user', $user);
		$this->db->bind(':password', $password);
		return $this->db->resultSingleValue();
	}
}