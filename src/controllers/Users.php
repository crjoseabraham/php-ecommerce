<?php
namespace Controller;

use \Model\User;
use \Model\Payment;

/**
 * Users Controller
 * Performs actions in 'Profile' page like update information or delete user's account
 * Also the recover password function
 */
class Users
{
  /**
   * Called when users desire to update their profile information
   * like name, password, email or delete their account
   * @return void
   */
  public function updateInfo()
  {    
    // Validate that user actually wants to change some data
    $data = [];
    $current_user = User::findById($_SESSION['user_id']);
    
    if ($_POST['name'] !== $current_user->name)
      $data['name'] = htmlspecialchars($_POST['name']);

    if ($_POST['email'] !== $current_user->email)
      $data['email'] = $_POST['email'];

    if ($_POST['password'] !== '')
    {
      $data['password'] = $_POST['password'];
      $data['password_confirm'] = $_POST['password_confirm'];
    }

    if (empty($data))
    {
      flash(NO_CHANGES, INFO);
      redirect('/profile');
    }
    else
    {
      if (User::updateInformation($data))
      {
        flash(DATA_UPDATED);
        redirect('/profile');
      }
      else
        renderView('profile.html', [Payment::getUserOrders(), User::getErrors()]);
    }
  }

  /**
   * Delete account
   */
  public function deleteAccount()
  {
    if (User::deleteUserAccount())
      Auth::logout();
    else
      die(ERROR_MESSAGE);
  }

  /**
   * Recover password
   */
  public function recoverPassword()
  {
    User::sendPasswordResetEmail(htmlspecialchars($_POST['email']));

    renderView('/email-sent.html');
  }
}