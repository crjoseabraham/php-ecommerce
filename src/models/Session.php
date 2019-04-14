<?php 
namespace Model;

/**
 * Session Class
 */
class Session
{
  public function __construct(string $user_id)
  {
    session_regenerate_id(true);
    $_SESSION['id'] = session_id();
    $_SESSION['user'] = $user_id;
    $_SESSION['start_time'] = date('Y-m-d H:i:s');
    $_SESSION['budget'] = 100;
  }

  /**
   * Log in user
   * Compare email and password combination with database records
   * If everything's correct, start a new PHP Session
   * @return array if records found, false if not.
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
  public function logout()
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

    // Finally destroy the session
    session_destroy();
  }
  
  /**
   * Get current user by session id
   * @return array      User info
   */
  public static function getUser()
  {
    if (isset($_SESSION['user']))
    {
      return User::findById($_SESSION['user']);
    }
  }
}