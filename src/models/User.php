<?php
namespace Model;

use \App\Database;
use \Controller\Auth;
use \Controller\Token;
use \Controller\Emails;

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
   * @return mixed         Object if records found, if not returns false
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
   * @return mixed         Object if records found, false if not
   */
  public function findById($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM `user` WHERE id = :id;");
    $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Search for certain email in the database for another user that's not the current user. Used as valdiation when users want to edit their e-mail address
   */
  public function findByEmailExceptCurrent($email)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM `user` WHERE email = :email AND NOT id = :id");
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->bindValue(':id', $_SESSION['user_id'], \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Get a user's data by the password_reset_hash column
   * @param string $token   Token to verify
   * @return mixed          Object if records found, false if not
   */
  public function findByPasswordReset($token)
  {
    $token = new Token($token);
    $hashed_token = $token->getHash();

    $db = static::getDB();
    $stmt = $db->prepare( "SELECT * FROM `user` WHERE password_reset_hash = :token");
    $stmt->bindValue(':token', $hashed_token, \PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_OBJ);

    if ($user)
    {
      // Check password reset token hasn't expired
      if (strtotime($user->password_reset_expires_at) > time())
      {
         return $user;
      }
    }

    return false;
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
   * Update information from user profile (name & email)
   * @param  string $name    New name
   * @param  string $email   New email
   * @return boolean         Result of execution: true or false
   */
  public function updateBasicInfo($name, $email) : bool
  {
    $db = static::getDB();
    $stmt = $db->prepare("UPDATE `user` SET `name` = :n, `email` = :e WHERE `id` = :id");
    $stmt->bindValue(':n', $name, \PDO::PARAM_STR);
    $stmt->bindValue(':e', $email, \PDO::PARAM_STR);
    $stmt->bindValue(':id', $_SESSION['user_id'], \PDO::PARAM_INT);
    return $stmt->execute();
  }

  /**
   * Change current user's password
   * @param  string $password   New password
   * @return boolean            Result of execution: true or false
   */
  public function changePassword($password): bool
  {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $db = static::getDB();
    $stmt = $db->prepare("UPDATE `user` SET `password` = :new_pass WHERE `id` = :user");
    $stmt->bindValue(':new_pass', $hashed_password, \PDO::PARAM_STR);
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

  /**
   * Password reset process
   */
  public function passwordResetProcess($email)
  {
    $user = self::findByEmail($email);

    if ($user)
    {
      // Start password reset process
      [$startPasswordReset, $token] = self::startPasswordReset($user);

      if ($startPasswordReset)
      {
        self::sendPasswordResetEmail($token, $email);
        return true;
      }
    }

    return false;
  }

  /**
   * Start password reset process
   */
  public function startPasswordReset($user)
  {
    $token = new Token;
    $hashed_token = $token->getHash();
    $expiry_timestamp = date('Y-m-d H:i:s', time() + 60 * 60 * 2);   // 2 hours from now
    $db = static::getDB();
    $stmt = $db->prepare("
      UPDATE user
      SET password_reset_hash = :token_hash,
          password_reset_expires_at = :expiry_date
      WHERE id = :user_id");
    $stmt->bindValue(':token_hash', $hashed_token, \PDO::PARAM_STR);
    $stmt->bindValue(':expiry_date', $expiry_timestamp, \PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user->id, \PDO::PARAM_STR);
    return [$stmt->execute(), $token->getValue()];
  }

  /**
   * Send password reset email
   */
  public function sendPasswordResetEmail($token, $email)
  {
    $url = URLROOT . '/password-reset/' . $token;

    $text = getTemplate('reset-email.txt', ['url' => $url]);
    $html = getTemplate('reset-email.html', ['url' => $url]);

    Emails::send($email, 'Password reset', $text, $html);
  }
}