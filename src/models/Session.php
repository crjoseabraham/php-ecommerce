<?php
namespace App\Model;

use App\Core\Database;
use App\Controller\Token;

class Session extends Database {

    public function __construct(int $user) {
        session_regenerate_id(true);
        $_SESSION['id'] = session_id();
        $_SESSION['user'] = $user;
        $_SESSION['started_at'] = date('Y-m-d H:i:s');
        $this->registerNewSession();
    }

    /**
     * Register new session in the `session` table
     * @return  void
     */
    public function registerNewSession() : void {
        $db = static::getDB();
        $stmt = $db->prepare("INSERT INTO `session` (`session_id`, `user_id`, `started_at`) VALUES(:id, :user, :started_at)");
        $stmt->bindValue(':id', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->bindValue(':user', $_SESSION['user'], \PDO::PARAM_INT);
        $stmt->bindValue(':started_at', $_SESSION['started_at'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Restore a session after it was found in the cookie
     * @param object $old_session Old session data gotten from table `session`
     * @return void
     */
    public static function restoreSession($old_session) : void {
        $_SESSION = [];
        session_destroy();
        session_start();

        $_SESSION['id'] = $old_session['session_id'];
        $_SESSION['user'] = $old_session['user_id'];
        $_SESSION['started_at'] = $old_session['started_at'];
    }

    /**
     * Get a session row found by its ID
     * @param  string $id Session ID
     * @return mixed      Object if records found, false otherwise
     */
    public static function findSessionById($id) {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM `session` WHERE `session_id` = :id;");
        $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
    }

    /**
     * Update session end time and status
     * @return void
     */
    public static function registerSessionLogOut() : void {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `session` SET `end` = :endtime, `status` = 0 WHERE `session_id` = :id;");
        $stmt->bindValue(':endtime', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['id'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Log out user by destroying the session
     *
     * @return void
     */
    public static function destroySession() : void {
        // Register the session logout
        self::registerSessionLogOut();
        // Unset all of the session variables
        $_SESSION = [];
        // Destroy the session and forget remembered login
        session_destroy();
    }

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     * @return void
     */
    public function rememberLogin() : void {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();
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
     * Get a remembered session by the token
     * @param  string $token Original token of the session
     * @return mixed         Object if records found, false otherwise
     */
    public static function findRememberedLogin($token) {
        $token = new Token($token);
        $token_hash = $token->getHash();

        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM remembered_logins WHERE token_hash = :token");
        $stmt->bindValue(':token', $token_hash, \PDO::PARAM_STR);
        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : false;
    }

    /**
     * Delete a remembered session
     * @param  string $token Hashed token of the session
     * @return boolean       True if execution was successful, false otherwise
     */
    public static function deleteRememberedLogin($token) : bool {
        $db = static::getDB();
        $stmt = $db->prepare("DELETE FROM remembered_logins WHERE token_hash = :token");
        $stmt->bindValue(':token', $token, \PDO::PARAM_STR);
        return $stmt->execute();
    }
}