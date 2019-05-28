<?php
namespace Model;

use \App\Database;
use \Controller\Auth;

/**
 * User class
 * Performs operations with 'user' table in the database
 * Register user, get user's data, etc.
 */
class User extends Database
{
  /**
   * Constructor class
   * Inmediately register the passed data and set user properties
   * @param array $data   $_POST data
   */
  public function __construct(array $data)
  {
    if ($this->registerUser($data))
    {
      $user = $this->findByEmail($data['email']);
      foreach ($user as $key => $value) 
      {
        $this->$key = $value;
      }
    }
  }

  /**
   * Check if email already exists in the database
   * @param  string $email Email to check
   * @return mixed         Array if records found, if not returns false
   */
  public function findByEmail($email)
  {
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
   * Register a new user
   * @param  array  $data   Name, email and password to register
   * @return boolean        True if insert was successful, False if not
   */
  public function registerUser($data) : bool
  {
    $db = static::getDB();
    $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO user (`email`, `name`, `password`) VALUES (:e, :n, :p);");
    $stmt->bindValue(':e', $data['email'], \PDO::PARAM_STR);
    $stmt->bindValue(':n', $data['name'], \PDO::PARAM_STR);
    $stmt->bindValue(':p', $hashed_password, \PDO::PARAM_STR);
    if ($stmt->execute())
    {
      // Now create user's associated cart and return true if everything ok.
      return Cart::createNewCart($this->findByEmail($data['email'])) ? true : false;
    }

    return false;
  }

  /**
   * Update information from user profile
   * @param  array $data    POST data sent by user
   * @param  array $fields  Partial strings for final SQL query
   * @return boolean        Result of execution: true or false
   */
  public function updateInformation($data, $fields) : bool
  {
    $query = 'UPDATE user SET ' . implode(', ', $fields) . ' WHERE `id` = :user';

    $db = static::getDB();
    $stmt = $db->prepare($query);

    if (isset($data['name']))
      $stmt->bindValue(':name', $data['name'], \PDO::PARAM_STR);

    if (isset($data['email']))
      $stmt->bindValue(':email', $data['email'], \PDO::PARAM_STR);

    if (isset($data['hashed_password']))
      $stmt->bindValue(':pass', $hashed_password, \PDO::PARAM_STR);

    $stmt->bindValue(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
    
    return $stmt->execute();
  }

  /**
   * Delete user account
   */
  public function deleteUserAccount()
  {
    $db = static::getDB();
    $stmt = $db->prepare("DELETE FROM `user` WHERE `id` = :id");
    $stmt->bindValue(':id', $_SESSION['user_id'], \PDO::PARAM_INT);
    return $stmt->execute();
  }
}