<?php 
namespace Model;

use \App\Database;
use \Controller\Token;
use \Controller\Auth;

/**
 * Session handler class
 * Start and destroy sessions
 */
class Session extends Database
{
  public function __construct($user)
  {
    session_regenerate_id(true);
    $_SESSION['session_id'] = session_id();
    $_SESSION['user_id'] = $user;
    $_SESSION['start'] = date('Y-m-d H:i:s');
    $_SESSION['cash'] = 100;
    self::registerNewSession();
  }

  /**
   * Log in user
   * Compare email and password combination with database records
   * If everything's correct, start a new PHP Session
   * @param string $email     Email submitted by the user
   * @param string $password  Password submitted by the user
   * @return mixed array if records found, false if not.
   */
  public function login(string $email, string $password)
  {
    $email = htmlspecialchars($email);
    $password = htmlspecialchars($password);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
      User::setError(EMAIL_INVALID);
      return false;
    }

    $user = User::findByEmail($email);

    if ($user && password_verify($password, $user->password))
      return $user;
    else
      User::setError(LOGIN_ERROR);

    return false;
  }

  /**
   * Log out user by destroying the session and cookies
   */
  public function logout() : void
  {
    // Unset all of the session variables
    $_SESSION = [];

    // Delete the session cookie
    if (ini_get('session.use_cookies')) 
    {
      $params = session_get_cookie_params();

      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
      );
    }

    // Finally destroy the session and forget the remembered login
    session_destroy();
    Auth::forgetLogin();
  }

  /**
   * Register new session in the `session` table
   * @return  void
   */
  public function registerNewSession()
  {
    $db = static::getDB();
    $stmt = $db->prepare("INSERT INTO `session` (session_id, user_id, cash, start) VALUES(:id, :user, :cash, :start)");
    $stmt->bindValue(':id', $_SESSION['session_id'], \PDO::PARAM_STR);
    $stmt->bindValue(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(':cash', $_SESSION['cash'], \PDO::PARAM_STR);
    $stmt->bindValue(':start', $_SESSION['start'], \PDO::PARAM_STR);
    $stmt->execute();
  }

  /**
   * Restore a session after it was found in the cookie
   * @param object $old_session Old session data gotten from table `session`
   * @return void
   */
  public function restoreSession($old_session)
  {
    self::logout();
    session_start();

    foreach ($old_session as $key => $value)
    {
      if (isset($key))
        $_SESSION[$key] = $value;
    }
  }
  
  /**
   * Get current user if a session is running
   * If there's no session, try to find a remembered session in a cookie
   * @return array      User info
   */
  public static function getUser()
  {
    if (isset($_SESSION['user_id']))
    {
      return User::findById($_SESSION['user_id']);
    }
    else
    {
      if(Auth::loginFromRememberedCookie())
        return User::findById($_SESSION['user_id']);
    }
  }

  /**
   * Remember the login by inserting a new unique token into the remembered_logins table
   * for this user record
   * @return  boolean true if execution was successful, false if not
   */
  public function rememberLogin()
  {
    $token = new Token();
    $hashed_token = $token->getHash();
    $this->original_token = $token->getValue();

    // Set expiry date to 30 days from now
    $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;

    $db = static::getDB();
    $stmt = $db->prepare('INSERT INTO remembered_logins (token_hash, session_id, expires_at) VALUES (:token, :session, :exp)');
    $stmt->bindValue(':token', $hashed_token, \PDO::PARAM_STR);
    $stmt->bindValue(':session', $_SESSION['session_id'], \PDO::PARAM_STR);
    $stmt->bindValue(':exp', date('Y-m-d H:i:s', $this->expiry_timestamp), \PDO::PARAM_STR);

    return $stmt->execute();
  }

  /**
   * Check if a cookie expiry date has passed
   * @param  string $cookie_expiry_date Date
   * @return boolean                    True if has expired, false otherwise
   */
  public function cookieHasExpired($cookie_expiry_date) : bool
  {
    return strtotime($cookie_expiry_date) < time();
  }

  /**
   * Get a session row found by its ID
   * @param  string $id Session ID
   * @return mixed      Object if records found, false otherwise
   */
  public function getSessionById($id)
  {
    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM session WHERE session_id = :id");
    $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Get a remembered session by the token
   * @param  string $token Original token of the session
   * @return mixed         Object if records found, false otherwise
   */
  public function findByToken($token)
  {
    $token = new Token($token);
    $token_hash = $token->getHash();

    $db = static::getDB();
    $stmt = $db->prepare("SELECT * FROM remembered_logins WHERE token_hash = :token");
    $stmt->bindValue(':token', $token_hash, \PDO::PARAM_STR);
    return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_OBJ) : false;
  }

  /**
   * Delete a remembered session
   * @param  string $token Hashed token of the session
   * @return boolean       True if execution was successful, false otherwise
   */
  public function deleteRememberedLogin($token)
  {
    $db = static::getDB();
    $stmt = $db->prepare("DELETE FROM remembered_logins WHERE token_hash = :token");
    $stmt->bindValue(':token', $token, \PDO::PARAM_STR);
    return $stmt->execute();
  }
}