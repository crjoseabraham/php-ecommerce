<?php
namespace App\Controller;

use App\Model\User;

class Accounts {

    /**
     * Update account basic information: name and email, coming from profile page
     * Check which fields are supposed to be changed and send them to the model
     *
     * @return void
     */
    public function updateBasic() {
        $validation_errors = Validations::processForm($_POST);

        if (empty($validation_errors)) {
            $user_model = new User;
            $current_user = User::getUserById($_SESSION['user']);
            foreach ($_POST as $key => $value) {
                if ($_POST[$key] === $current_user[$key])   unset($_POST[$key]);
            }

            if (empty($_POST))
                Flash::addMessage(NO_CHANGES, INFO);
            elseif ($user_model->updateBasicInfo($_POST))
                Flash::addMessage(DATA_UPDATED);
            else
                Flash::addMessage(ERROR_MESSAGE, ERROR);
        } else
            Flash::addMessage($validation_errors, ERROR);

        redirect('/profile');
    }

    /**
     * Change password from profile page
     *
     * @return void
     */
    public function updatePassword() {
        $validation_errors = Validations::processForm($_POST);

        if (empty($validation_errors)) {
            $user_model = new User;
            $current_user = User::getUserById($_SESSION['user']);
            // If the provided password matches the stored hash in the db, then it's the same password, so...
            if (password_verify($_POST['password'], $current_user["password"]))
                Flash::addMessage(NO_CHANGES, INFO);
            else {
                $execution_result = $user_model->changePassword($_SESSION['user'], $_POST['password']);

                Flash::addMessage(
                    $execution_result ? DATA_UPDATED : ERROR_MESSAGE,
                    $execution_result ? SUCCESS : ERROR
                );
            }
        }
        else
            Flash::addMessage($validation_errors, ERROR);

        redirect('/profile');
    }
}