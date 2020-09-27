<?php
namespace App\Controller\Account;

use App\Controller\Account\Passwords;
use App\Controller\Helper\Cookies;
use App\Controller\Helper\Flash;
use App\Controller\Helper\Validations;
use App\Model\Merchandise\Cart;
use App\Model\Authentication\User;
use App\Model\Authentication\Session;

class Accounts {

    public function __construct() {
        $this->auth_controller = new Auth();
    }

    /**
     * Process "Sign Up" form to create a user and start a session
     *
     * @return void
     */
    public function create() {
        Validations::processForm($_POST);
        $form_errors = Validations::getErrors();

        if (empty($form_errors)) {
            $user = new User(
                $_POST['name'],
                $_POST['email'],
                Passwords::hash($_POST['password'])
            );
            if (!$user::isEmailInDatabase($_POST['email'])) {
                $new_user_id = $user->create();
                $cart = new Cart();
                $cart->create($new_user_id);
                $user->setCurrentUser();
                $session = new Session($user->id);
                $session->registerStart();
                Flash::addMessage(NEW_USER);
            } else
                Flash::addMessage(EMAIL_TAKEN, ERROR);
        }
        else
            Flash::addMessage($form_errors, ERROR);

        redirect('/');
    }

    /**
     * Get the currently logged user
     *
     * @return mixed
     */
    public function getLoggedUser() {
        if (isset($_SESSION['user']))
            return User::findById($_SESSION['user']);
        elseif ($this->auth_controller->loginFromCookie())
            return User::findById($_SESSION['user']);
        return null;
    }

    /**
     * Update account basic information: name and email, coming from profile page
     * Check which fields are supposed to be changed and send them to the model
     *
     * @return void
     */
    public function updateBasic() {
        $validation_errors = Validations::processForm($_POST);

        if (empty($validation_errors)) {
            $current_user = $this->getLoggedUser();
            foreach ($_POST as $key => $value) {
                if ($_POST[$key] === $current_user->$key)   unset($_POST[$key]);
            }

            if (empty($_POST))
                Flash::addMessage(NO_CHANGES, INFO);
            else {
                User::updateBasicInfo($_POST);
                Flash::addMessage(DATA_UPDATED);
            }
        } else
            Flash::addMessage($validation_errors, ERROR);

        redirect('/profile');
    }

    /**
     * Delete user's account
     *
     * @return void
     */
    public function delete() {
        $user = User::findById($_SESSION['user']);

        Session::endSession();
        if (Cookies::findCookie("remember_me"))
            $this->auth_controller->forgetLogin();

        $user_model = new User($user->name, $user->email, $user->password);
        $user_model->delete($user->id);
        redirect('/');
    }
}