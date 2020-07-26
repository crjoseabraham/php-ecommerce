<?php
namespace App\Controller;

use App\Model\User;

class Auth {

    /**
     * Sign Up - Validate data sent from sign up form and create user
     * @return void
     */
    public function signUp() {
        extract($_POST);
        $name = trim($name);
        $email = trim($email);
        $password = htmlspecialchars($password);
        $passwordConfirmation = htmlspecialchars($passwordConfirmation);

        $validation_result = $this->validateSignUpForm($name, $email, $password, $passwordConfirmation);
        // If there are no errors, create user
        if (empty($validation_result)) {
            // Create user and start session
            $new_user = new User($name, $email, $password);
            redirect("/start-session/user/$new_user->id");
        }
        // TODO: else Flash notification and redirect home
    }

    /**
     * Validate data from sign up form
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @return void
     */
    private function validateSignUpForm($name, $email, $password, $passwordConfirmation) {
        $errors = [];
        $regex = [
            "name" => "/^[a-zA-ZÀ-ÿ ]{2,60}$/",
            "email" => "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/",
            "password" => "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/"
        ];

        // Validate Name
        if (!preg_match($regex["name"], $name))
            $errors[] = INVALID_NAME;

        // Validate Email - is it a valid email? is it available?
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || !preg_match($regex["email"], $email))
            $errors[] = INVALID_EMAIL;

        if (User::isEmailAvailable($email) === false) {
            $errors[] = EMAIL_TAKEN;
        } else {
            // Validate Password
            if (!preg_match($regex["password"], $password))
                $errors[] = INVALID_PASS;
            if ($password !== $passwordConfirmation)
                $errors[] = PASS_MATCH_ERR;
        }

        return $errors;
    }
}
