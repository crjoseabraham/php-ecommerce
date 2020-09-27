<?php
namespace App\Controller\Helper;

class Validations {
    /**
     * Store all the errors found
     * @var array
     */
    static $errors = [];

    /**
     * Sizes to loop through for the verification
     * @var array
     */
    static $sizes = [
        "clothes" => ["S", "M", "L", "XL"],
        "shoes" => ["4.5", "5.5", "6", "7", "8", "8.5", "9.5", "10"]
    ];

    /**
     * Regular expressions for making validations
     * @var array
     */
    static $regex = [
        "name" => "/^[a-zA-ZÀ-ÿ ]{2,60}$/",
        "email" => "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/",
        "password" => "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/"
    ];

    /**
     * Loop through all the values in $_POST and validate them with the correct method
     *
     * @param array $data       $_POST data to check
     * @return void
     */
    public static function processForm(array $data) : void {
        self::$errors = array();

        foreach ($data as $key => $value) {
            $value = trim($value);
            $value = htmlspecialchars($value);

            if ($key === 'passwordConfirmation')
                self::$key($data['password'], $data['passwordConfirmation']);
            else
                self::$key($value);
        }
    }

    /**
     * Get the $errors variable
     *
     * @return array
     */
    public static function getErrors() : array {
        return self::$errors;
    }

    /**
     * Store a passed string in $errors
     *
     * @return void
     */
    public static function setError(string $message) : void {
        self::$errors[] = $message;
    }

    /**
     * Validate a user's name
     *
     * @param string $name
     * @return void
     */
    public static function name(string $name) : void {
        if (!preg_match(self::$regex["name"], $name))
            self::$errors[] = INVALID_NAME;
    }

    /**
     * Validate an email address
     *
     * @param string $email
     * @return void
     */
    public static function email(string $email) : void {
        $filtered_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (
            filter_var($filtered_email, FILTER_VALIDATE_EMAIL) === false ||
            !preg_match(self::$regex["email"], $filtered_email)
        )
            self::$errors[] = INVALID_EMAIL;
    }

    /**
     * Verify a password contains at least 4 characters, 1 uppercase letter, 1 lowercase letter, 1 number
     *
     * @param string $password
     * @return void
     */
    public static function password(string $password) : void {
        if (!preg_match(self::$regex["password"], $password))
            self::$errors[] = LOGIN_PASSW_ERROR;
    }

    /**
     * Verify that password matches the confirmation field
     *
     * @param string $password
     * @param string $confirmation
     * @return void
     */
    public static function passwordConfirmation(string $password, string $confirmation) : void {
        if ($password !== $confirmation)
            self::$errors[] = PASS_MATCH_ERR;
    }

    /**
     * Verify if the size passed is either a string value cotained in $sizes["clothes"]
     * or a float value from the ones in $sizes["shoes"]
     *
     * @param string $size
     * @return void
     */
    public static function size(string $size) : void {
        $iterator = 0;

        foreach (self::$sizes["clothes"] as $clothing_size) {
            if ($size === $clothing_size) $iterator++;
        }

        if ($iterator === 0) {
            foreach (self::$sizes["shoes"] as $shoe_size) {
                if ($size === $shoe_size) $iterator++;
            }
        }

        if (!$iterator)
            self::$errors[] = SIZE_ERROR;
    }

    /**
     * Verify that the user selected a size number between 1 and 20
     *
     * @param integer $qty
     * @return void
     */
    public static function quantity(int $qty) : void {
        if (!(is_int($qty) && ($qty >= 1 && $qty <= 20)))
            self::$errors[] = QUANTITY_ERROR;
    }
}