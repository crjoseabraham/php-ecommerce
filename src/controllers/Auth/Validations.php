<?php 
namespace Controller;

class Validations
{
	/**
	 * Array to store errors in validations
	 * @var array
	 */
	public static $errors = [];


	/**
	 * $errors getter
	 */
	public function getValidationErrors() : array
	{
		return self::$errors;
	}

	/**
	 * Validate name
	 * @param  string $name Name to check
	 * @return string 			Verified name
	 */
	public function validateName(string $name)
	{
		$name = htmlspecialchars($name);

		if ($name === '')
      self::$errors[] = NAME_MISSING;

    if ($name !== '' && preg_match('/[^\p{L} +]/', $name))
      self::$errors[] = NAME_INVALID;

    return $name;
	}

	/**
	 * Validate email
	 * @param  string $email Email to verify
	 * @param  				$type  Specifies if it's a registration (needs to consult database)
	 *                       or just a login (doesn't need to consult database)
	 * @return string        Validated email
	 */
	public function validateEmail(string $email, $type = null)
	{
		$email = strtolower(htmlspecialchars($email));
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    	self::$errors[] = EMAIL_INVALID;

    if ($type === 'registration')
    {
    	if (\Model\User::findByEmail($email))
      	self::$errors[] = EMAIL_EXISTS;
    }

    return $email;
	}

	/**
	 * Validate password matches confirmation, has 6+ characters, and at least one letter
	 * @param  string $password 					Password to check
	 * @param  string $password_confirm 	Password confirmation from input
	 * @return boolean
	 */
	public function validatePassword(string $password, string $password_confirm)
	{
		$password = htmlspecialchars($password);
		$password_confirm = htmlspecialchars($password_confirm);

		if ($password !== $password_confirm)
      self::$errors[] = PASSWORDS_DONT_MATCH;
    else
    {
      if (strlen($password) < 6)
        self::$errors[] = PASSWORD_TOO_SHORT;

      if (!preg_match('/.*[a-z]+.*/i', $password))
        self::$errors[] = PASSWORD_NEEDS_LETTER;

      if (!preg_match('/.*\d+.*/i', $password))
        self::$errors[] = PASSWORD_NEEDS_NUMBER;
    }

    return [$password, $password_confirm];
	}
}