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
		$this->db->query("SELECT * FROM `user` WHERE id = :id");
		$this->db->bind(":id", $id);
		return $this->db->resultSingle();
	}

	public function getUserByEmail($email)
	{
		$this->db->query("SELECT * FROM `user` WHERE email = :email");
		$this->db->bind(":email", $email);
		return $this->db->resultSingle();
	}

	public function verifyPassword (string $submittedPassword, string $password)
	{
		$correctPassword = password_verify($submittedPassword, $password);
		return $correctPassword;
	}

	public function validateEmail(string $email)
	{
		if (!empty($email)) {
			// Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                return false;

            return $email;
		} else
			return false;
	}

	public function validatePassword(string $password, string $confirm_password)
	{
		if (!empty($password) || !empty($confirm_password)) {
			if (!preg_match("#[0-9]+#", $password)) {
                return false;
            }
            if (!preg_match("#[A-Z]+#", $password)) {
                return false;
            }
            if (!preg_match("#[a-z]+#", $password)) {
                return false;
            }
            if ($password !== $confirm_password) {
            	return false;
            }
		} else
			return false;

		return $password;
	}

	public function isEmailAvailable(string $email)
	{
		$this->db->query("SELECT COUNT(email) FROM `user` WHERE email = :email");
		$this->db->bind(':email', $email);
		return !$this->db->resultSingleValue();
	}

	public function encryptPassword(string $password)
	{
		return password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
	}

	public function registerNewUser(string $email, string $password, string $created_at) : bool
	{	
		$this->db->query("INSERT INTO user (email, password, created_at) VALUES (:email, :pass, :created)");
		$this->db->bind(':email', $email);
		$this->db->bind(':pass', $password);
		$this->db->bind(':created', $created_at);
		if ($this->db->execute())
			return true;
		else
			return false;
	}
}