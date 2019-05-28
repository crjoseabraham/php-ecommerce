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
   * Called when users desire to update their profile information
   * like name, password, email or delete their account
   * @return void
   */
  public function updateInfo()
  {
    // $args will be an array that'll store two things:
    // a) 'data' => [Array with the information to change: name, email, pass]
    // b) 'fields' => [Array with partial strings for the final SQL query]
    $args = self::validateUpdateInfoData($_POST);

    if (User::updateInformation($args['data'], $args['fields']))
      flash(DATA_UPDATED);
    else
      flash(ERROR_MESSAGE, ERROR);

    redirect('/profile');
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
   * Validate data for the 'updateInfo' method. 
   * 
   * This function ended looking a (lot) bit messy but it's no more than a validation method 
   * for inputs, so that the controller and model for 'updateInfo' look a lot cleaner
   * 
   * This is what this method does:
   * 1. VALIDATE THAT THE USER ACTUALLY WANTS TO MAKE SOME CHANGES
   * -> this will store in $data[] all changes the user wants to make
   * -> (because maybe the use wants to change only the name but not the other fields)
   * If at the end of the conditionals, $data is empty, it means there are no changes to make...
   * ... so redirect to 'profile' page and show the "No changes" notification
   * 2. CHECK WHAT FIELDS USER WANTS TO CHANGE AND STORE THE RESPECT QUERY STRING FOR THAT FIELD
   * -> this will store in $fields[] one or many strings that will be concatenated to get the
   * -> final query string. $fields['name = :name', 'email = :email'] and the all of these
   * -> will be 'imploded' into the query string in the model later.
   * -> Resulting in "UPDATE ... SET `name` = :name', '`email` = :email' WHERE ..."
   * 3. RETURN DATA AND FIELDS
   */
  public function validateUpdateInfoData($postValues)
  {
    $data = [];
    $fields = [];
    $errors = [];

    // 1. VALIDATE THAT THE USER ACTUALLY WANTS TO MAKE SOME CHANGES
    $current_user = User::findById($_SESSION['user_id']);
    
    if ($postValues['name'] !== $current_user->name)
      $data['name'] = htmlspecialchars($postValues['name']);

    if ($postValues['email'] !== $current_user->email)
      $data['email'] = strtolower(htmlspecialchars($postValues['email']));

    if ($postValues['password'] !== '')
    {
      $data['password'] = htmlspecialchars($postValues['password']);
      $data['password_confirm'] = htmlspecialchars($postValues['password_confirm']);
    }

    // If $data is empty, it means nothing's different from the current user info
    if (empty($data))
    {
      flash(NO_CHANGES, INFO);
      redirect('/profile');
    }
    else
    {
      // User wants to make some changes to their information so...
      // 2. CHECK WHAT FIELDS USER WANTS TO CHANGE AND STORE THE RESPECTIVE
      // QUERY PORTION FOR THAT FIELD
      if (isset($data['name']))
        $fields[] = '`name` = :name';

      if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        $fields[] = '`email` = :email';

      if (isset($data['password']))
      {
        if ($data['password'] === $data['password_confirm'])
        {
          if (strlen($data['password']) < 6)
            $errors[] = PASSWORD_TOO_SHORT;

          if (preg_match('/.*[a-z]+.*/i', $data['password']) == 0)
            $errors[] = PASSWORD_NEEDS_LETTER;

          if (preg_match('/.*\d+.*/i', $data['password']) == 0)
            $errors[] = PASSWORD_NEEDS_NUMBER;
        }
        else
          $errors[] = PASSWORDS_DONT_MATCH;

        if (empty($errors))
        {
          $fields[] = '`password` = :pass';
          $data['hashed_password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        else
        {
          flash($errors, ERROR);
          redirect('/profile');
        }
      }
    }

    // 3. RETURN DATA AND FIELDS
    return ['data' => $data, 'fields' => $fields];
  }
}