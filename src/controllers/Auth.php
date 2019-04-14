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
   * @return void
   */
  public function login() : void
  {
    $user = Session::login(...array_values($_POST));

    if ($user)
    {
      $session = new Session($user->id);
      redirect('/store');
    }
    else
      renderView('login.html', User::getErrors());
  }

  /**
   * Log out a user
   * @return void
   */
  public function logout() : void
  {
    Session::logout();
    redirect('');
  }

  /**
   * Register controller for POST
   * Create new user and start their session
   * @return void
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
}