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
    $email = Validations::validateEmail($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $errors = Validations::getValidationErrors();

    if (!empty($errors))
      flash($errors, ERROR);
    else
    {
      // 2. SEARCH USER IN DATABASE
      $user = User::findByEmail($email);

      if (!$user)
        // User does not exist, redirect to home page and show error
        flash(LOGIN_ERROR, ERROR);
      else
      {
        // User was found, check if the password matches
        if (!password_verify($password, $user->password))
          flash(LOGIN_ERROR, ERROR);
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
        }
      }
    }

    redirect('/');
  }

  /**
   * Log out a user
   */
  public function logout() : void
  {
    if (Session::getUser())
      Session::destroySession();
    redirect('/');
  }

  /**
   * Register controller for POST
   * Create new user and start their session
   */
  public function register() : void
  {
    // 1. SANITIZE POST DATA
    $name = Validations::validateName($_POST['name']);
    $email = Validations::validateEmail($_POST['email'], 'registration');
    [$password, $password_confirm] = Validations::validatePassword($_POST['password'], $_POST['password_confirm']);

    // 2. IF THERE ARE NO ERRORS, PROCEED WITH REGISTRATION
    $errors = Validations::getValidationErrors();

    if (!empty($errors))
      flash($errors, ERROR);
    else
    {
      $data = ["name" => $name, "email" => $email, "password" => $password];
      $user = new User($data);

      if ($user)
        $session = new Session($user->id);
      else
        flash(REGISTRATION_ERROR, ERROR);
    }
    
    redirect('/');
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

  /**
   * Recover password method
   */
  public function recoverPassword()
  {
    $email = strtolower(htmlspecialchars($_POST['email']));

    if (User::passwordResetProcess($email))
        redirect('/email-sent');
    else
      die(ERROR_MESSAGE);
  }

  /**
   * User clicked link in email to recover their password
   * Verify token
   */
  public function verifyResetPasswordToken($token)
  {
    if (!Session::getUser()) {
      $user = User::findByPasswordReset(htmlspecialchars($token));
      renderView('reset-password.html', ["token" => $token]);
    } 
    else 
      die('You can not access this page');
  }

  public function resetPasswordForm($token)
  {
    if (!Session::getUser()) {
      $user = User::findByPasswordReset(htmlspecialchars($token));
      if ($user && User::changePassword($user, $_POST))
        redirect('/home');
      else
        die(ERROR_MESSAGE);
    } 
    else 
      die('You can not access this page');
  }
}