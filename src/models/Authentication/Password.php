<?php
namespace App\Model\Authentication;

use App\Core\Database;
use App\Core\View;
use App\Controller\Helper\Mail;
use App\Controller\Helper\Token;

class Password extends Database {

    /**
     * Change certain user's password
     *
     * @param integer $user             User ID
     * @param string $new_password      New password previously hashed
     * @return void
     */
    public function change(int $user, string $new_password): void {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `user` SET `password` = :p WHERE `id` = :u");
        $stmt->bindValue(':p', $new_password, \PDO::PARAM_STR);
        $stmt->bindValue(':u', $user, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Start password reset process by generating a "reset token" and its expiry time
     *
     * @param int $user   User's ID
     * @return void
     */
    public function startResetProcess(int $user): void {
        $token = new Token;
        $hashed_token = $token->getHash();
        $expiry_timestamp = date('Y-m-d H:i:s', time() + 60 * 60 * 2);   // 2 hours from now
        $db = static::getDB();

        $stmt = $db->prepare("UPDATE `user` SET password_reset_hash = :token_hash, password_reset_expires_at = :expiry WHERE `id` = :user");

        $stmt->bindValue(':token_hash', $hashed_token, \PDO::PARAM_STR);
        $stmt->bindValue(':expiry', $expiry_timestamp, \PDO::PARAM_STR);
        $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Send password reset link to user's email address
     *
     * @param object $user
     * @return void
     */
    public function emailResetLink(object $user): void {
        $view_class = new View();
        $url = $_ENV['URLROOT'] . '/password/reset/' . $user->password_reset_hash;
        $text = $view_class->getTemplate("email_templates/resetpass_txt", ["url" => $url]);
        $html = $view_class->getTemplate("email_templates/resetpass_html", ["url" => $url]);

        Mail::send($user->email, 'Password reset', $text, $html);
    }

    /**
     * Set the password reset columns empty after it was succesfully recovered;
     *
     * @param integer $user
     * @return void
     */
    public function clearResetColumns(int $user): void {
        $db = static::getDB();
        $stmt = $db->prepare("UPDATE `user` SET `password_reset_hash` = null, `password_reset_expires_at` = null WHERE `id` = :u");
        $stmt->bindValue(':u', $user, \PDO::PARAM_INT);
        $stmt->execute();
    }
}