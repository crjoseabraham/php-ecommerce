<?php 
/**
 * Users controller
 * Performs all operations related to User's data
 */
class User extends Controller
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	/**
	 * Get specific user by their ID
	 * @param  string $id User ID
	 * @return array 	  Row containing user data
	 */
	public function getUserById(string $id) : array
	{
		$this->db->query("SELECT * FROM `user` WHERE id = :id");
		$this->db->bind(":id", $id);
		return $this->db->resultSingle();
	}

	/**
	 * Get specific user by their email
	 * @param  string $email User email
	 * @return array 	  Row containing user data
	 */
	public function getUserByEmail($email)
	{
		$this->db->query("SELECT * FROM `user` WHERE email = :email");
		$this->db->bind(":email", $email);
		return $this->db->resultSingle();
	}

	/**
	 * Register a new user
	 * @param  string $email      User email
	 * @param  string $password   User password
	 * @param  string $created_at Current date and time
	 * @return boolean
	 */
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

	/**
	 * Sanitize and validate email address
	 * @param  string $email User email
	 * @return string 		 Validated Email
	 */
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

	/**
	 * Validate user password
	 * @param string $password 	User password
	 * @param string $confirm_password
	 * @return string  			Validated password
	 */
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

	/**
	 * Encrypt user password
	 * @param  string $password User password
	 * @return string           Hashed password
	 */
	public function encryptPassword(string $password) : string
	{
		return password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
	}

	/**
	 * Verify if submitted password is correct when logging in
	 * @param  string $submittedPassword Typed password by user
	 * @param  string $password          Password stored in db
	 */
	public function verifyPassword (string $submittedPassword, string $password)
	{
		$correctPassword = password_verify($submittedPassword, $password);
		return $correctPassword;
	}

	/**
	 * Check if email is already registered
	 * @param  string  $email Typed email by user
	 * @return boolean
	 */
	public function isEmailAvailable(string $email) : bool
	{
		$this->db->query("SELECT COUNT(email) FROM `user` WHERE email = :email");
		$this->db->bind(':email', $email);
		return !$this->db->resultSingleValue();
	}	
}