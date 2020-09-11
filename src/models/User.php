<?php
namespace App\Model;

use App\Core\Database;
use App\Core\View;
use App\Controller\Token;
use App\Controller\Mail;

class User extends Database {

    /**
     * Register a new user
     * @param  array  $data   Name, email and password to register
     * @return void
     */
    public function createUser(array $data) : void {
        $db = static::getDB();
        $hashed_password = password_hash($data["password"], PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO user (`email`, `name`, `password`) VALUES (:e, :n, :p);");
        $stmt->bindValue(':e', $data["email"], \PDO::PARAM_STR);
        $stmt->bindValue(':n', $data["name"], \PDO::PARAM_STR);
        $stmt->bindValue(':p', $hashed_password, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Check if email already exists in the database
     * @param  string $email Email to check
     * @return boolean       true if found, if not returns false
     */
    public static function isEmailInDatabase(string $email) : bool {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `email` = :email;");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return !empty($result) ? true : false;
    }

    /**
     * Find a user in the database by a passed ID
     * @param string $id    ID to look for in the DB
     * @return mixed        User array if found, false otherwise
     */
    public static function getUserById(string $id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `id` = :id;");
        $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
    }

    /**
     * Find a user in the database by a submitted email
     * @param string $email
     * @return mixed
     */
    public static function getUserByEmail(string $email) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `email` = :email;");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
    }

    /**
     * Find a user in the database by their password reset token
     * @param string $token
     * @return mixed
     */
    public static function getUserByPasswordResetToken(string $token) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `password_reset_hash` = :tok;");
        $stmt->bindValue(':tok', $token, \PDO::PARAM_STR);
        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
    }

    /**
     * Search for match between passed email and password
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public static function credentialsAreCorrect(string $email, string $password) : bool {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `email` = :email;");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(\PDO::FETCH_ASSOC);
        return password_verify($password, $results["password"]);
    }

    /**
     * Update a user's name or email (or both) coming from profile page
     *
     * @param array $data       $_POST data
     * @return boolean          Result of execution
     */
    public function updateBasicInfo(array $data) : bool {
        $db = static::getDB();
        $array_size = count($data);
        $iterator = 1;
        $sql = "UPDATE `user` SET ";

        foreach ($data as $key => $value) {
            $sql .= $iterator < count($data) ? "`{$key}` = :{$key}, " : "`{$key}` = :{$key} ";
            $iterator++;
        }

        $stmt = $db->prepare($sql . "WHERE `id` = {$_SESSION['user']}");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value, \PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    /**
     * Start password reset process by generating a "reset token" and its expiry time
     *
     * @param array $user   Found user data
     * @return boolean      Result of execution
     */
    public function startPasswordReset(array $user) : bool {
        $token = new Token;
        $hashed_token = $token->getHash();
        $expiry_timestamp = date('Y-m-d H:i:s', time() + 60 * 60 * 2);   // 2 hours from now
        $db = static::getDB();

        $stmt = $db->prepare("UPDATE `user` SET password_reset_hash = :token_hash, password_reset_expires_at = :expiry WHERE `id` = :user");

        $stmt->bindValue(':token_hash', $hashed_token, \PDO::PARAM_STR);
        $stmt->bindValue(':expiry', $expiry_timestamp, \PDO::PARAM_STR);
        $stmt->bindValue(':user', $user['id'], \PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Send password reset link to user's email address
     * At this point, it is confirmed that the user exists in the database
     *
     * @param array $user
     * @return void
     */
    public function sendPasswordResetEmail(array $user) : void {
        $view_class = new View();
        $url = URLROOT . '/password/reset/' . $user['password_reset_hash'];
        $text = $view_class->getTemplate("email_templates/resetpass_txt", ["url" => $url]);
        $html = $view_class->getTemplate("email_templates/resetpass_html", ["url" => $url]);

        Mail::send($user['email'], 'Password reset', $text, $html);
    }

    /**
     * From "Reset password". Replace user's password with the new one.
     *
     * @param int $user                 User's ID
     * @param string $new_password      New password
     * @return boolean                  Result of execution
     */
    public function changePassword(int $user, string $new_password) : bool {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `user` SET `password` = :new_pass WHERE `id` = :user");
        $stmt->bindValue(':new_pass', $hashed_password, \PDO::PARAM_STR);
        $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Clear password reset columns in 'user' table: password_reset_hash & expiry time
     *
     * @param integer $user         User's ID
     * @return void
     */
    public function clearPasswordResetColumns(int $user) : void {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `user` SET `password_reset_hash` = null, password_reset_expires_at = null WHERE `id` = :user");
        $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Delete a user's account from database
     *
     * @param integer $user     ID of the user
     * @return boolean          Result of execution
     */
    public function deleteUser(int $user) : bool {
    $db = static::getDB();
    $stmt = $db->prepare("DELETE FROM `user` WHERE `id` = :id");
    $stmt->bindValue(':id', $user, \PDO::PARAM_INT);
    return $stmt->execute();
    }
}