<?php
namespace Controller;

use \Model\User;

/**
 * Users Controller
 * Performs actions in 'Profile' page like update information or delete user's account
 */
class Users
{
  /**
   * Called when users desire to update their profile information like name and email
   * @return void
   */
  public function updateInfo()
  {
    $name = Validations::validateName($_POST['name']);
    $email = Validations::validateEmail($_POST['email'], 'update');
    $possible_errors = Validations::getValidationErrors();

    // Verify that user actually wants to change something
    $current_user = User::findById($_SESSION['user_id']);

    if ($current_user->name === $name && $current_user->email === $email)
      flash(NO_CHANGES, INFO);

    if ($possible_errors)
      flash($possible_errors, ERROR);
    else
    {
      User::updateBasicInfo($name, $email);
      flash(DATA_UPDATED);
    }

    redirect('/');
  }

  /**
   * Called when users desire to change their password
   * @return void
   */
  public function updatePassword()
  {
    [$password, $password_confirm] = Validations::validatePassword($_POST['password'], $_POST['password_confirm']);
    $possible_errors = Validations::getValidationErrors();

    if ($possible_errors)
    {
      flash($possible_errors, ERROR);
      redirect('/');
    }
    else {
      User::changePassword($password);
      Auth::logout();
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
}