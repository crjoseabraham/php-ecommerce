<?php
namespace App\Model\Authentication;

use App\Core\Database;

class User extends Database {

    public function __construct(string $name, string $email, string $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Set the object $this->* vars with current user data
     *
     * @return void
     */
    public function setCurrentUser(): void {
        $user = self::findByEmail($this->email);
        foreach ($user as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Create a new user
     *
     * @return void
     */
    public function create(): int {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `user` (`email`, `name`, `password`, `created_at`) VALUES (:e, :n, :p, :d)");
        $stmt->bindValue(':e', $this->email, \PDO::PARAM_STR);
        $stmt->bindValue(':n', $this->name, \PDO::PARAM_STR);
        $stmt->bindValue(':p', $this->password, \PDO::PARAM_STR);
        $stmt->bindValue(':d', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $stmt->execute();
        return $db->lastInsertId();
    }

    /**
     * Get user by supplied email
     *
     * @param string $email
     * @return mixed
     */
    public static function findByEmail(string $email) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `email` = :email");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Find a user in the database by a passed ID
     * @param string $id    ID to look for in the DB
     * @return mixed        User object if found, false otherwise
     */
    public static function findById(string $id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `id` = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Check if email already exists in the database
     * @param  string $email Email to check
     * @return boolean       true if found, false if not
     */
    public static function isEmailInDatabase(string $email): bool {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `email` = :email");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return !!($stmt->fetch(\PDO::FETCH_OBJ));
    }

    /**
     * Find a user in the database by their password reset token
     * @param string $token
     * @return mixed
     */
    public static function findByPasswordResetToken(string $token) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `password_reset_hash` = :tok;");
        $stmt->bindValue(':tok', $token, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Update a user's name or email (or both) coming from profile page
     *
     * @param array $data       $_POST data
     * @return void
     */
    public static function updateBasicInfo(array $data): void {
        $db = static::getDB();
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

        $stmt->execute();
    }

    /**
     * Delete a user's account from database
     *
     * @param integer $user     ID of the user
     * @return boolean          Result of execution
     */
    public function delete(int $user) : bool {
    $db = static::getDB();
    $stmt = $db->prepare("DELETE FROM `user` WHERE `id` = :id");
    $stmt->bindValue(':id', $user, \PDO::PARAM_INT);
    return $stmt->execute();
    }
}