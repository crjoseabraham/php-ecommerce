<?php
namespace App\Controller;

use App\Model\User;

class Auth {

    public function __construct() {
        $this->user = new User();
    }

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

        // If there are no errors, create user or start session
        if (empty($validation_result)) {
            if ($isRegistration)
                $this->user->createUser($_POST);

            $this->user->setCurrentUser($_POST["email"]);
            redirect("/start-session/user/" . $this->user->id);
        } else {
            var_dump($validation_result);
            die();
        }
        // TODO: else Flash notification and redirect home
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
    public function validateLogin(array $data) {
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
            $user = $this->user->getUserByCredentials($data["email"], $data["password"]);
            if ($user === false)
                $errors[] = LOGIN_ERROR;
        } else
            $errors[] = INVALID_PASS;

        return $errors;
    }
}
