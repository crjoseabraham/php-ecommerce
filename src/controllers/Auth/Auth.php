<?php 
namespace Controller;

use \Model\User;
use \Model\Session;

/**
 * Authentication controller
 * Manage user login/logout/registration
 */
class Auth
{
  /**
   * Login controller for POST
   * Authenticate user and start session
   */
  public function login() : void
  {
    $user = Session::login($_POST['email'], $_POST['password']);
    $remember_me = isset($_POST['remember_login']);

    if ($user)
    {
      $session = new Session($user->id);

      if ($remember_me)
      {
        if ($session->rememberLogin())
          setcookie('remember_me', $session->original_token, $session->expiry_timestamp, '/');
        else
          die("Something went wrong. Please go back and try again");
      }

      redirect('/store');
    }
    else
      renderView('login.html', User::getErrors());
  }

  /**
   * Log out a user
   */
  public function logout() : void
  {
    Session::logout();
    redirect('');
  }

  /**
   * Register controller for POST
   * Create new user and start their session
   */
  public function register() : void
  {
    $userModel = new User($_POST);

    if ($userModel->registerUser())
    {
      $user = $userModel->findByEmail();
      $session = new Session($user->id);
      redirect('/store');
    }
    else
      renderView('register.html', User::getErrors());
  }

  /**
   * Login the user from a remembered login cookie
   * @return  boolean True if session was restored, false otherwise
   */
  public function loginFromRememberedCookie() : bool
  {
    $cookie = $_COOKIE['remember_me'] ?? false;

    if ($cookie)
    {
      $remembered_login = Session::findByToken($cookie);

      // If a 'remembered' login was found and it hasn't expired
      if ($remembered_login && !Session::cookieHasExpired($remembered_login->expires_at))
      {
        // Get that old session data and restore that session
        $old_session = Session::getSessionById($remembered_login->session_id);

        if ($old_session)
        {
          Session::restoreSession($old_session);
          return true;
        }
      }
    }

    return false;
  }

  /**
   * Delete a remembered login when user logs out and set the cookie expiry date to the past
   * @return void
   */
  public function forgetLogin()
  {
    $cookie = $_COOKIE['remember_me'] ?? false;

    if ($cookie)
    {
      $remembered_login = Session::findByToken($cookie);

      if ($remembered_login)
        Session::deleteRememberedLogin($remembered_login->token_hash);

      setcookie('remember_me', '', time() - 3600);
    }
  }
}