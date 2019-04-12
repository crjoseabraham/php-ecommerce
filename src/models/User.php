<?php
namespace Model;

use \App\Database;
use \App\Config;

class User
{
  private $db;
  public $errors = [];

  /**
   * Constructor class
   * Connects to the database and stores all $_POST data into private array $user
   * @param array $data   $_POST data
   */
  public function __construct(array $data)
  {
    $this->db = new Database;

    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
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
      $hashed_password = \password_hash($this->password, PASSWORD_BCRYPT);
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
   * Sanitize inputs
   * @return void
   */
  private function validateData() : void
  {
    // Name
    if ($this->name === '')
      $this->errors[] = Config::NAME_MISSING;

    // Email address
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
      $this->errors[] = Config::EMAIL_INVALID;

    // Password
    if ($this->password != $this->password_confirm)
      $this->errors[] = Config::PASSWORD_MATCH;

    if (strlen($this->password) < 6)
      $this->errors[] = Config::PASSWORD_TOO_SHORT;

    if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
      $this->errors[] = Config::PASSWORD_NEEDS_LETTER;

    if (preg_match('/.*\d+.*/i', $this->password) == 0)
      $this->errors[] = Config::PASSWORD_NEEDS_NUMBER;

    if ($this->emailExists())
      $this->errors[] = Config::EMAIL_EXISTS;
  }

  /**
   * Check if email already exists in the database
   * @param  string $email Email to check
   * @return boolean       true if found record, false if not
   */
  private function emailExists() : bool
  {
    $this->db->query("SELECT * FROM user WHERE email = :email;");
    $this->db->bind(':email', $this->email);
    return !!$this->db->resultSet();
  }
}