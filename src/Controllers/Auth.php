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
        foreach ($_POST as $key => $value) {
            $key = trim($value);
            $key = htmlspecialchars($value);
        }

        $isRegistration = isset($_POST["name"]) && isset($_POST["passwordConfirmation"]);

        if ($isRegistration)
            $validation_result = $this->validateSignUpForm($_POST);
        else
            $validation_result = $this->validateLogin($_POST);

        // If there are no errors, sign up or sign in
        if (empty($validation_result)) {
            if ($isRegistration)
                $this->signup($_POST);
            else
                $this->login($_POST);
        } else {
            // TODO: else Flash notification and redirect home
            var_dump($validation_result);
            die();
        }
    }

    /**
     * Get the current logged-in user, from the session or the remember-me cookie
     *
     * @return mixed The user model or null if not logged in
     */
    public static function getUser()
    {
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
        if ($user) {
            new Session($user['id']);
            redirect("/");
        } else
            die("SOMETHING WENT WRONG WITH THE REGISTRATION");
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
            die("SOMETHING WENT WRONG.");
    }

    /**
     * Validate data from sign up form
     * @param array $data $_POST values
     * @return array Array with errors
     */
    private function validateSignUpForm(array $data) : array {
        $errors = [];
        $regex = [
            "name" => "/^[a-zA-ZÀ-ÿ ]{2,60}$/",
            "email" => "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/",
            "password" => "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/"
        ];

        // Validate Name
        if (!preg_match($regex["name"], $data["name"]))
            $errors[] = INVALID_NAME;

        // Validate Email - is it a valid email? is it available?
        $data["name"] = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
        if (
            filter_var($data["name"], FILTER_VALIDATE_EMAIL) === false ||
            !preg_match($regex["email"], $data["name"])
        )
            $errors[] = INVALID_EMAIL;

        if (User::isEmailAvailable($data["name"]) === false) {
            $errors[] = EMAIL_TAKEN;
        } else {
            // Validate Password
            if (!preg_match($regex["password"], $data["password"]))
                $errors[] = INVALID_PASS;
            if ($data["password"] !== $data["passwordConfirmation"])
                $errors[] = PASS_MATCH_ERR;
        }

        return $errors;
    }

    /**
     * Validate the data sent from the login form
     * Make validations and reject if necessary, before consulting the DB
     * @param string $email
     * @param string $password
     * @return void
     */
    private function validateLogin(array $data) {
        $errors = [];
        $regex = [
            "email" => "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/",
            "password" => "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/"
        ];

        // Validate Email - is it a valid email?
        $data["email"] = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
        if (
            filter_var($data["email"], FILTER_VALIDATE_EMAIL) === false ||
            !preg_match($regex["email"], $data["email"])
        )
            $errors[] = INVALID_EMAIL;
        elseif (preg_match($regex["password"], $data["password"])) {
            // Do email and password match with the database records?
            $user_model = new User();
            $user = $user_model->getUserByCredentials($data["email"], $data["password"]);
            if ($user === false)
                $errors[] = LOGIN_ERROR;
        } else
            $errors[] = INVALID_PASS;

        return $errors;
    }
}
