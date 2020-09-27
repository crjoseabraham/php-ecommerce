<?php
namespace App\Controller\Account;

use App\Controller\Helper\Flash;
use App\Controller\Helper\Validations;
use App\Model\Authentication\User;
use App\Model\Authentication\Password;

class Passwords {

    /**
     * Encrypt password
     *
     * @param string $password
     * @return string
     */
    public static function hash(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Check if the given hash matches the given password
     *
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public static function verify(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    /**
     * Check if an expiry date has passed
     *
     * @param string $expiry_datetime   Datetime
     * @return boolean                  True if expired, false if valid.
     */
    public function resetTokenHasExpired(string $expiry_datetime): bool {
        return strtotime($expiry_datetime) < time();
    }

    /**
     * Perform the password change process
     *
     * @param array $params         User ID
     * @param null  $post           POST DATA if it comes from another method
     * @return void
     */
    public function change(array $params, array $post = null): void {
        $user_id = htmlspecialchars($params['id']);
        $user = User::findById($user_id);
        $this->validateChangePassword((isset($_POST)) ? $_POST : $post, $user_id);
        $new_password = (isset($_POST)) ? $_POST['password'] : $post['password'];

        if (!is_null($user)) {
            $password_model = new Password();
            $password_model->change($user_id, $this->hash($new_password));
            Flash::addMessage(DATA_UPDATED);
        } else
            Flash::addMessage(USER_404, ERROR);
        redirect('/');
    }

    /**
     * User submitted the form to create a new password from "Forgotten password"
     *
     * @param array $params         User ID and token
     * @return void
     */
    public function updateForgotten(array $params): void {
        $token = htmlspecialchars($params['token']);
        $user_id = htmlspecialchars($params['id']);
        $this->validateChangePassword($_POST, $user_id);
        $this->change(['id' => $user_id], $_POST);
    }

    /**
     * Request reset password token
     *
     * @return void
     */
    public function requestReset(): void {
        $this->validateResetForm($_POST);
        $user = User::findByEmail($_POST['email']);
        $password_model = new Password;
        $password_model->startResetProcess($user->id);
        $password_model->emailResetLink(User::findByEmail($_POST['email']));
        Flash::addMessage(RECOVER_PASSWORD_EMAIL);
        redirect("/");
    }

    /**
     * Validate the "Reset password" form (Basically is just email)
     *
     * @param array $post   $_POST data (email)
     * @return void
     */
    private function validateResetForm(array $post): void {
        Validations::processForm($post);

        if (!Auth::isEmailInDatabase($post['email']))
            Validations::setError(EMAIL_DOESNT_EXISTS);

        if (!empty(Validations::getErrors())) {
            Flash::addMessage(Validations::getErrors(), ERROR);
            redirect('/forgotten-password');
        }
    }

    /**
     * Coming from the email link. Make sure the token is still valid
     *
     * @param array $params
     * @return void
     */
    public function validateResetLink(array $params) {
        $token = htmlspecialchars($params['token']);
        $user = User::findByPasswordResetToken($token);

        if ($this->resetTokenHasExpired($user->password_reset_expires_at)) {
            // Token expired. Tell user to request a new one
            Flash::addMessage(RECOVER_TOKEN_EXPIRED, ERROR);
            redirect("/forgotten-password");
        } else
            // Token is still valid. Proceed
            redirect("/reset-password-form-{$user->id}--{$params['token']}");
    }

    /**
     * Validate form to change the password
     *
     * @param array $post       $_POST
     * @param int   $user_id    User ID
     * @return void
     */
    private function validateChangePassword(array $post, int $user_id): void {
        Validations::processForm($post);
        $user = User::findById($user_id);

        if (is_null($user))
            Validations::setError(USER_404);

        if (!empty(Validations::getErrors())) {
            Flash::addMessage(Validations::getErrors(), ERROR);
            redirect('/');
        }
    }
}