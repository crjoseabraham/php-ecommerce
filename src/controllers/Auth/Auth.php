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
    // 1. SANITIZE POST DATA
    $email = strtolower(htmlspecialchars($_POST['email']));
    $password = htmlspecialchars($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
      flash(EMAIL_INVALID, ERROR);
      redirect('/login');
    }

    // 2. SEARCH USER IN DATABASE
    $user = User::findByEmail($email);

    if (!$user)
    {
      // User does not exist, redirect to login page and show error
      flash(LOGIN_ERROR, ERROR);
      redirect('/login');
    }
    else
    {
      // User was found, check if the password matches
      if (!password_verify($password, $user->password))
      {
        flash(LOGIN_ERROR, ERROR);
        redirect('/login');
      }
      else
      {
        // Start session
        $session = new Session($user->id);

        // Verify if 'remember me' is checked
        if(isset($_POST['remember_login']))
        {
          $session->rememberLogin();
          Cookies::newCookie('remember_me', $session->original_token, $session->expiry_timestamp, '/');
        }

        redirect('/store');
      }
    }
  }

  /**
   * Log out a user
   */
  public function logout() : void
  {
    Session::destroySession();
    redirect('/home');
  }

  /**
   * Register controller for POST
   * Create new user and start their session
   */
  public function register() : void
  {
    // 1. SANITIZE POST DATA
    foreach ($_POST as $field) 
    {
      $field = htmlspecialchars($field);
    }

    $_POST['email'] = strtolower($_POST['email']);

    // Create variable to store errors in it
    $errors = self::validateRegistrationData($_POST);

    // 2. IF THERE ARE NO ERRORS, PROCEED WITH REGISTRATION
    if (empty($errors))
    {
      $user = new User($_POST);

      if ($user)
      {
        // Now start session for the new user
        $session = new Session($user->id);
        redirect('/store');
      }
      else
      {
        flash(REGISTRATION_ERROR, ERROR);
        redirect('/register');
      }
    }
    else
    {
      // If some fields contain invalid values, display form again with errors
      flash($errors, ERROR);
      redirect('/register');
    }
  }

  /**
   * Validate registration data passed
   * @param  array $data      Information passed through registration form
   * @return array            Array with errors or empty if everything's ok
   */
  public function validateRegistrationData($data)
  {
    $errors = [];

    // NAME
    if ($data['name'] === '')
      $errors[] = NAME_MISSING;

    if ($data['name'] !== '' && preg_match('/[^\p{L} +]/', $data['name']))
      $errors[] = NAME_INVALID;

    // EMAIL ADDRESS
    if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false)
      $errors[] = EMAIL_INVALID;

    if (User::findByEmail($data['email']))
      $errors[] = EMAIL_EXISTS;

    // PASSWORD
    if ($data['password'] !== $data['password_confirm'])
      $errors[] = PASSWORDS_DONT_MATCH;
    else
    {
      if (strlen($data['password']) < 6)
        $errors[] = PASSWORD_TOO_SHORT;

      if (!preg_match('/.*[a-z]+.*/i', $data['password']))
        $errors[] = PASSWORD_NEEDS_LETTER;

      if (!preg_match('/.*\d+.*/i', $data['password']))
        $errors[] = PASSWORD_NEEDS_NUMBER;
    }

    return $errors;
  }

  /**
   * Login the user from a remembered login cookie
   * @return  boolean True if session was restored, false otherwise
   */
  public function loginFromRememberedCookie() : bool
  {
    $sessionCookie = Cookies::findCookie('remember_me');

    if ($sessionCookie)
    {
      $remembered_login = Session::findByToken($sessionCookie);

      // If a 'remembered login' was found and it hasn't expired
      if ($remembered_login && !Cookies::hasExpired($remembered_login->expires_at))
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
    $sessionCookie = Cookies::findCookie('remember_me');

    if ($sessionCookie)
    {
      $remembered_login = Session::findByToken($sessionCookie);

      if ($remembered_login)
        Session::deleteRememberedLogin($remembered_login->token_hash);

      Cookies::newCookie('remember_me', '', time() - 3600);
    }
  }
}