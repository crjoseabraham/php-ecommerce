<?php
namespace App\Controller\Account;

use App\Controller\Helper\Cookies;
use App\Controller\Helper\Flash;
use App\Controller\Helper\Token;
use App\Controller\Helper\Validations;
use App\Model\Authentication\User;
use App\Model\Authentication\Session;

class Auth {

    /**
     * Log In a user
     *
     * @return void
     */
    public function login(): void {
        $this->validateLogin($_POST);
        $form_errors = Validations::getErrors();

        if (empty($form_errors)) {
            $user = User::findByEmail($_POST['email']);
            $session = new Session($user->id);
            $session->registerStart();
            if (isset($_POST['remember_me']))
                $this->rememberLogin($session);
        } else
            Flash::addMessage($form_errors, ERROR);

        redirect('/');
    }

    /**
     * Validate the data sent from the login form
     * Make validations and reject if necessary, before consulting the DB
     * @param array $data   POST data...
     * @return void
     */
    private function validateLogin(array $data) {
        if (isset($data['remember_me']))    unset($data['remember_me']);

        $form_errors = Validations::processForm($data, true);

        if (empty($form_errors)) {
            if (
                !User::isEmailInDatabase($data['email']) ||
                !$this->credentialsAreCorrect($data['email'], $data['password'])
            )
                Validations::setError(LOGIN_ERROR);
        }
    }

    /**
     * Look for a match between passed email, password and the database
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    private function credentialsAreCorrect(string $email, string $password): bool {
        $user = User::findByEmail($email);
        return Passwords::verify($password, $user->password);
    }

    /**
     * Search for an email in the user table
     *
     * @param string $email
     * @return boolean
     */
    public static function isEmailInDatabase(string $email): bool {
        return User::isEmailInDatabase($email);
    }

    /**
     * Store "remember_me" token in database and create cookie
     *
     * @param Session $session
     * @return void
     */
    private function rememberLogin(Session $session): void {
        $token = new Token();
        $hashed_token = $token->getHash();
        $session->rememberLogin($hashed_token);
        Cookies::set('remember_me', $token->getValue(), $session->expiry_timestamp, '/');
    }

    /**
     * Log Out a user, destroy the session and delete the login cookie
     *
     * @return void
     */
    public function logout() : void {
        Session::endSession();
        if (Cookies::findCookie("remember_me"))
            $this->forgetLogin();

        redirect("/");
    }

    /**
     * Log In a user by making use of the data stored in a cookie
     *
     * @return boolean      Result of operation
     */
    public static function loginFromCookie(): bool {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {
            $token = new Token($cookie);
            $token_hash = $token->getHash();
            $remembered_login = Session::findRememberedLogin($token_hash);
            // If cookie was found and hasn't expired, then restore the session
            if (!!$remembered_login && !Cookies::hasExpired($remembered_login->expires_at)) {
                $old_session = Session::findById($remembered_login->session_id);
                Session::restore($old_session);
                return true;
            }
        }

        return false;
    }

    /**
     * Delete all data related to a remembered login in the used device
     *
     * @return void
     */
    public function forgetLogin(): void {
        $token = new Token(Cookies::findCookie("remember_me"));
        $token_hash = $token->getHash();
        $remembered_login = Session::findRememberedLogin($token_hash);

        if (!!$remembered_login) {
            Session::deleteRememberedLogin($remembered_login->token_hash);
            Cookies::deleteSessionCookie();
        } else
            Flash::addMessage(ERROR_MESSAGE, ERROR);
    }
}
