<?php
namespace Model;

use \App\Database;

class User
{
  private $db;
  public $errors = [];

  /**
   * Constructor class
   * Connects to the database and stores all $_POST data into $this variables
   * @param array $data   $_POST data
   */
  public function __construct(array $data)
  {
    $this->db = new Database;

    foreach ($data as $key => $value) {
      $this->$key = htmlspecialchars($value);
    }
  }

  /**
   * Login authentication
   * Compare email and password combination with database records
   * @return array if records found, false if not.
   */
  public function authenticate()
  {
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
    {
      $this->errors[] = EMAIL_INVALID;
      return false;
    }

    $user = $this->findByEmail();
    
    if (password_verify($this->password, $user['password']))
      return $user;
    else
      $this->errors[] = LOGIN_ERROR;

    return false;
  }

  /**
   * Register a new user
   * @return boolean  True if insert was successful, False if not
   */
  public function registerUser() : bool
  {
    $this->validateData();

    if (empty($this->errors)) 
    {
      $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
      $this->db->query("INSERT INTO user (`email`, `name`, `password`) VALUES (:e, :n, :p);");
      $this->db->bind(':e', $this->email);
      $this->db->bind(':n', $this->name);
      $this->db->bind(':p', $hashed_password);
      if ($this->db->execute())
        return true;
      else
        return false;
    }
    
    return false;
  }

  /**
   * Check if email already exists in the database
   * @param  string $email Email to check
   * @return               Array if records found, if not returns false
   */
  private function findByEmail()
  {
    $this->db->query("SELECT * FROM user WHERE email = :email;");
    $this->db->bind(':email', $this->email);
    return $this->db->resultSingleRow() ? $this->db->resultSingleRow() : false;
  }

  /**
   * Sanitize inputs
   * @return void
   */
  private function validateData() : void
  {
    // Name
    if ($this->name === '')
      $this->errors[] = NAME_MISSING;

    // Email address
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
      $this->errors[] = EMAIL_INVALID;

    // Password
    if ($this->password != $this->password_confirm)
      $this->errors[] = PASSWORD_MATCH;

    if (strlen($this->password) < 6)
      $this->errors[] = PASSWORD_TOO_SHORT;

    if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
      $this->errors[] = PASSWORD_NEEDS_LETTER;

    if (preg_match('/.*\d+.*/i', $this->password) == 0)
      $this->errors[] = PASSWORD_NEEDS_NUMBER;

    if ($this->findByEmail() !== false)
      $this->errors[] = EMAIL_EXISTS;
  }
}