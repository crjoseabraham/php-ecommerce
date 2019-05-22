<?php
namespace Model;

use \App\Database;

/**
 * User class
 * Performs operations with 'user' table in the database
 * Register user, get a user's data, etc.
 */
class User extends Database
{
  /**
   * Error messages
   * @var array
   */
  private static $errors = [];

  /**
   * Constructor class
   * Set $this->email, $this->password, etc. from sent POST data
   * @param array $data   $_POST data
   */
  public function __construct(array $data)
  {
    foreach ($data as $key => $value)
      $this->$key = htmlspecialchars($value);
  }

  /**
   * Return $errors array
   * @return  array   Array with error messages
   */
  public function getErrors() : array
  {
    return self::$errors;
  }

  /**
   * Set a new $errors value
   * @param  string $value The value to be stored in $errors array
   */
  public function setError(string $value) : void
  {
    self::$errors[] = $value;
  }

  /**
   * Register a new user
   * @return boolean  True if insert was successful, False if not
   */
  public function registerUser() : bool
  {
    $this->validateData();

    if (empty(self::$errors)) 
    {
      $db = static::getDB();
      $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
      $stmt = $db->prepare("INSERT INTO user (`email`, `name`, `password`) VALUES (:e, :n, :p);");
      $stmt->bindValue(':e', $this->email, \PDO::PARAM_STR);
      $stmt->bindValue(':n', $this->name, \PDO::PARAM_STR);
      $stmt->bindValue(':p', $hashed_password, \PDO::PARAM_STR);
      if ($stmt->execute())
      {
        // Now create user's associated cart and return true if everything ok.
        return Cart::createNewCart($this->findByEmail($this->email)) ? true : false;
      }
    }
    
    return false;
  }

  /**
   * Check if email already exists in the database
   * @param  string $email Email to check
   * @return mixed         Array if records found, if not returns false
   */
  public function findByEmail($email = '')
  {
    if ($email === '') 
      $email = $this->email;

    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM user WHERE email = :email;");
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Get a user's data by passed id
   * @param  string $id    ID to check
   * @return mixed         Array if records found
   */
  public function findById($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM user WHERE id = :id;");
    $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Update information from user profile
   * @param  array $data POST data sent by user
   * @return boolean     Result of execution: true or false
   */
  public function updateInformation($data) : bool
  {
    $query = 'UPDATE user SET ';
    $fields = [];
    
    if (isset($data['name']))
      $fields[] = '`name` = :name';

    if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL))
      $fields[] = '`email` = :email';

    if (isset($data['password']))
    {
      if ($data['password'] === $data['password_confirm'])
      {
        if (strlen($data['password']) < 6)
          self::$errors[] = PASSWORD_TOO_SHORT;

        if (preg_match('/.*[a-z]+.*/i', $data['password']) == 0)
          self::$errors[] = PASSWORD_NEEDS_LETTER;

        if (preg_match('/.*\d+.*/i', $data['password']) == 0)
          self::$errors[] = PASSWORD_NEEDS_NUMBER;
      }
      else
        self::$errors[] = PASSWORD_MATCH;

      if (empty(self::$errors))
      {
        $fields[] = '`password` = :pass';
        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
      }
      else
        return false;
    }

    $query .= implode(', ', $fields);
    $query .= ' WHERE `id` = :user';

    $db = static::getDB();
    $stmt = $db->prepare($query);

    if (isset($data['name']))
      $stmt->bindValue(':name', $data['name'], \PDO::PARAM_STR);

    if (isset($data['email']))
      $stmt->bindValue(':email', $data['email'], \PDO::PARAM_STR);

    if (isset($hashed_password))
      $stmt->bindValue(':pass', $hashed_password, \PDO::PARAM_STR);

    $stmt->bindValue(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
    return $stmt->execute();
  }

  /**
   * Sanitize inputs
   */
  private function validateData() : void
  {
    // Name
    if ($this->name === '')
      self::$errors[] = NAME_MISSING;

    // Email address
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
      self::$errors[] = EMAIL_INVALID;

    // Password
    if ($this->password != $this->password_confirm)
      self::$errors[] = PASSWORD_MATCH;

    if (strlen($this->password) < 6)
      self::$errors[] = PASSWORD_TOO_SHORT;

    if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
      self::$errors[] = PASSWORD_NEEDS_LETTER;

    if (preg_match('/.*\d+.*/i', $this->password) == 0)
      self::$errors[] = PASSWORD_NEEDS_NUMBER;

    if ($this->findByEmail() !== false)
      self::$errors[] = EMAIL_EXISTS;
  }
}