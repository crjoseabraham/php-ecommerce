<?php
namespace Model;

use \App\Database;

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

  private function validateData()
  {
    // Name
    if ($this->name === '')
      $this->errors[] = 'Name is required';

    // Email address
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
      $this->errors[] = 'Invalid email';

    // Password
    if ($this->password != $this->password_confirm)
      $this->errors[] = 'Password must match confirmation';

    if (strlen($this->password) < 6)
      $this->errors[] = 'Password must be at least 6 characters long';

    if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
      $this->errors[] = 'Password needs at least one letter';

    if (preg_match('/.*\d+.*/i', $this->password) == 0)
      $this->errors[] = 'Password needs at least one number';
  }
}