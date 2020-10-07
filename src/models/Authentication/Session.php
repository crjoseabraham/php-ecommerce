<?php
namespace App\Model\Authentication;

use App\Core\Database;

class Session extends Database {

    public function __construct(int $user) {
        session_regenerate_id(true);
        $_SESSION['id'] = session_id();
        $_SESSION['user'] = $user;
        $_SESSION['started_at'] = date('Y-m-d H:i:s');
    }

    /**
     * Store a new session start in the database
     *
     * @return void
     */
    public function registerStart(): void {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `session` (`session_id`, `user_id`, `started_at`) VALUES(:id, :user, :started_at)");
        $stmt->bindValue(':id', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->bindValue(':started_at', $_SESSION['started_at'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Before session is destroyed, update session end time and status in the Db
     *
     * @return void
     */
    public static function registerEnd(): void {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `session` SET `end` = :endtime, `status` = 0 WHERE `session_id` = :id");
        $stmt->bindValue(':endtime', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     *
     * @return void
     */
    public function rememberLogin(string $hashed_token): void {
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO remembered_logins VALUES (:token, :userID, :sessionID, :expiryD)");
        $stmt->bindValue(':token', $hashed_token, \PDO::PARAM_STR);
        $stmt->bindValue(':userID', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->bindValue(':sessionID', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->bindValue(':expiryD', date('Y-m-d H:i:s', $this->expiry_timestamp), \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Log out user by destroying the session
     *
     * @return void
     */
    public static function endSession(): void {
        // Register the session logout
        self::registerEnd();
        // Unset all of the session variables
        $_SESSION = [];
        // Destroy the session and forget remembered login
        session_destroy();
    }

    /**
     * Get a session row found by its ID
     * @param  string $id Session ID
     * @return mixed      Object if records found, null otherwise
     */
    public static function findById($id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `session` WHERE `session_id` = :id;");
        $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? false;
    }

    /**
     * Get a remembered session by the token
     * @param  string $token Hashed token of the session
     * @return mixed         Object if records found, null otherwise
     */
    public static function findRememberedLogin($token) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `remembered_logins` WHERE token_hash = :token");
        $stmt->bindValue(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    /**
     * Restore a session after it was found in the cookie
     * @param object $old_session Old session data gotten from table `session`
     * @return void
     */
    public static function restore(object $old_session): void {
        $_SESSION = [];
        session_destroy();
        session_start();

        $_SESSION['id'] = $old_session->session_id;
        $_SESSION['user'] = $old_session->user_id;
        $_SESSION['started_at'] = $old_session->started_at;

        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `session` SET `end` = '', `status` = 1  WHERE `session_id` = :id");
        $stmt->bindValue(':id', $old_session->session_id, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Delete a remembered session
     * @param  string $token Hashed token of the session
     * @return void
     */
    public static function deleteRememberedLogin($token): void {
        $db = static::getDB();
        $stmt = $db->prepare("DELETE FROM `remembered_logins` WHERE `token_hash` = :token");
        $stmt->bindValue(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
    }
}