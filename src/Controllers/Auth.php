<?php
namespace App\Controller;

use App\Model\User;
use App\Model\Session;

class Auth {

    /**
     * Determine if user is trying to sign in or sign up and perform the corresponding actions
     * Sign Up - Validate data sent from sign up form and create user
     * Sign In - Validate data sent from sign in form and start session
     * @return void
     */
    public function auth() {
        $isRegistration = isset($_POST["name"]) && isset($_POST["passwordConfirmation"]);

        if ($isRegistration) {
            $this->validateSignUpForm($_POST);
            $method = "signup";
        }
        else {
            $this->validateLogin($_POST);
            $method = "login";
        }

        if (empty(Validations::getErrors())) {
            $this->$method($_POST);
        } else {
            Flash::addMessage(Validations::getErrors(), ERROR);
            redirect('/');
        }
    }

    /**
     * Get the current logged-in user, from the session or the remember-me cookie
     *
     * @return mixed The user model or null if not logged in
     */
    public static function getUser() {
        if (isset($_SESSION['user']))
            return User::getUserById($_SESSION['user']);
        else {
            if (static::loginFromCookie())
                return User::getUserById($_SESSION['user']);
        }
    }

    /**
     * Sign Up a new user
     *
     * @param array $data POST data
     * @return void
     */
    private function signup(array $data) : void {
        $user_model = new User;
        $user_model->createUser($data);
        $user = User::getUserByEmail($data['email']);
        if ($user)
            new Session($user['id']);
        else
            Flash::addMessage(REGISTRATION_ERROR, ERROR);
        redirect("/");
    }

    /**
     * Log In a user
     *
     * @param array $data POST data
     * @return void
     */
    private function login(array $post) : void {
        $user = User::getUserByEmail($post['email']);
        $session_model = new Session($user['id']);
        if (isset($post['remember_me'])) {
            $session_model->rememberLogin();
            Cookies::set('remember_me', $session_model->remember_token, $session_model->expiry_timestamp, '/');
        }
        redirect("/");
    }

    /**
     * Log In a user by making use of the data stored in a cookie
     *
     * @return boolean      Result of operation
     */
    public static function loginFromCookie() : bool {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {
            $remembered_login = Session::findRememberedLogin($cookie);
            // If cookie was found and hasn't expired, then restore the session
            if ($remembered_login && !Cookies::hasExpired($remembered_login['expires_at'])) {
                $old_session = Session::findSessionById($remembered_login['session_id']);
                Session::restoreSession($old_session);
                return true;
            }
        }

        return false;
    }

    /**
     * Log Out a user, destroy the session and delete the login cookie
     *
     * @return void
     */
    public function logout() : void {
        Session::destroySession();
        if (Cookies::findCookie("remember_me"))
            $this->forgetLogin();

        redirect("/");
    }

    /**
     * Delete all data related to a remembered login in the used device
     *
     * @return void
     */
    public function forgetLogin() : void {
        $remembered_login = Session::findRememberedLogin(Cookies::findCookie("remember_me"));

        if ($remembered_login) {
            Session::deleteRememberedLogin($remembered_login['token_hash']);
            Cookies::deleteSessionCookie();
        } else
            Flash::addMessage(ERROR_MESSAGE, ERROR);
    }

    /**
     * User submitted an email address to recover their password
     * Verify that email address and proceed to email the link
     *
     * @return void
     */
    public function requestPasswordReset() : void {
        $form_validation_errors = Validations::processForm($_POST);

        if (empty($form_validation_errors)) {
            if (User::isEmailInDatabase($_POST['email'])) {
                $user_model = new User();
                $user = User::getUserByEmail($_POST['email']);
                if ($user_model->startPasswordReset($user)) {
                    $user_model->sendPasswordResetEmail(User::getUserByEmail($_POST['email']));
                    Flash::addMessage(RECOVER_PASSWORD_EMAIL);
                }
                else
                    Flash::addMessage(ERROR_MESSAGE, ERROR);
            } else {
                Flash::addMessage(EMAIL_DOESNT_EXISTS, ERROR);
                redirect("/forgotten-password");
            }
        } else {
            Flash::addMessage($form_validation_errors, ERROR);
            redirect("/forgotten-password");
        }

        redirect("/");
    }

    /**
     * User submitted the form to create a new password and replace the forgotten one
     *
     * @param array $params     From the URL it is passed: token and user's ID
     * @return void
     */
    public function updateForgottenPassword($params) : void {
        $form_validation_errors = Validations::processForm($_POST);

        if (empty($form_validation_errors)) {
            $user = User::getUserByPasswordResetToken($params['token']);

            if ($user && strtotime($user['password_reset_expires_at']) > time()) {
                $user_model = new User();
                $execution_result = $user_model->changePassword($params['id'], $_POST['password']);
                $user_model->clearPasswordResetColumns($user['id']);
                Flash::addMessage(
                    $execution_result ? DATA_UPDATED : ERROR_MESSAGE,
                    $execution_result ? SUCCESS : ERROR
                );
                redirect('/');
            } else {
                Flash::addMessage(RECOVER_TOKEN_EXPIRED, ERROR);
                redirect('/forgotten-password');
            }
        }
        else {
            Flash::addMessage($form_validation_errors, ERROR);
            redirect("/");
        }
    }

    /**
     * Verify that the passed token actually exists and it hasn't expired
     *
     * @param array $params     From the URL it is passed: token
     * @return void
     */
    public function validateResetPasswordToken(array $params) : void {
        $token = $params['token'];
        $user = User::getUserByPasswordResetToken($token);

        if (strtotime($user['password_reset_expires_at']) < time()) {
            // Token expired. Tell user to request a new one
            Flash::addMessage(RECOVER_TOKEN_EXPIRED, ERROR);
            redirect("/forgotten-password");
        } else {
            // Token is still valid. Proceed
            redirect("/reset-password-form-{$user['id']}-{$token}");
        }
    }

    /**
     * Validate data from sign up form
     * @param array $data $_POST values
     * @return void
     */
    private function validateSignUpForm(array $data) : void {
        $form_validation_errors = Validations::processForm($data);

        if (User::isEmailInDatabase($data['email']))
            Validations::setError(EMAIL_TAKEN);
    }

    /**
     * Validate the data sent from the login form
     * Make validations and reject if necessary, before consulting the DB
     * @param array $data   POST data...
     * @return void
     */
    private function validateLogin(array $data) {
        if (isset($data['remember_me']))    unset($data['remember_me']);

        $form_validation_errors = Validations::processForm($data, true);

        if (empty($form_validation_errors)) {
            if (!User::isEmailInDatabase($data['email']))
                Validations::setError(EMAIL_DOESNT_EXISTS);
            else {
                if (!User::credentialsAreCorrect($data["email"], $data["password"]))
                    Validations::setError(LOGIN_ERROR);
            }
        }
    }
}
