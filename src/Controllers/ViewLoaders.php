<?php
namespace App\Controller;

use App\Core\View;
use App\Controller\Helper\Flash;
use App\Controller\Account\Accounts;
use App\Controller\Account\Passwords;
use App\Controller\Merchandise\Products;
use App\Model\User;

class ViewLoaders {
    public function __construct() {
        $this->view = new View;
        $this->accounts = new Accounts;
        $this->passwords = new Passwords;
        $this->products = new Products;
    }

    /**
     * Load homepage with all parameters needed
     * @return void
     */
    public function homepage() {
        $this->view->render("layouts/home", [
            "user" => $this->accounts->getLoggedUser(),
            "session" => $_SESSION
            //"products" => $this->products->getProducts(),
            // Just to show something different
            //"products2" => $this->products->getNotReallyRandomProducts()
        ]);
    }

    /**
     * Load page "Forgot my password"
     * @return void
     */
    public function forgottenPassword() {
        $this->view->render("layouts/forget_password", [
            "user" => $this->accounts->getLoggedUser(),
            "session" => $_SESSION
        ]);
    }

    /**
     * Page with the form to create a new password in case user forgot it
     * This page will be restricted for logged users or if the token expired
     * @param array $params     Array with user's ID and pass reset token
     * @return void
     */
    public function resetPasswordForm($params): void {
        $user = User::findById(htmlspecialchars($params['id']));

        if (!is_null($this->accounts->getLoggedUser())) {
            Flash::addMessage(NOT_ALLOWED, ERROR);
            redirect('/');
        } elseif ($this->passwords->resetTokenHasExpired($user->password_reset_expires_at)) {
            Flash::addMessage(RECOVER_TOKEN_EXPIRED, ERROR);
            redirect('/');
        } else {
            $this->view->render("layouts/reset_password", $params);
        }
    }

    /**
     * Profile page
     * Restricted to non-logged users
     * @return void
     */
    public function profile() : void {
        if (is_null($this->accounts->getLoggedUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
            redirect('/');
        } else
            $this->view->render("layouts/profile", [
                'user' => $this->accounts->getLoggedUser(),
                'session' => $_SESSION
            ]);
    }

    /**
     * "Delete account" confirmation page
     * Restricted for non-logged users
     *
     * @return void
     */
    public function deleteAccountForm() : void {
        if (is_null($this->accounts->getLoggedUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
            redirect('/');
        } else
            $this->view->render("layouts/profile_delete", ['session' => $_SESSION]);
    }

    // /**
    //  * Certain product's details page
    //  *
    //  * @param array $params     Item's ID passed in the URL
    //  * @return void
    //  */
    // public function productDetails($params) : void {
    //     $this->view->render("layouts/product_details", [
    //         'session' => $_SESSION,
    //         'product' => $this->products->getItem($params['item'])
    //     ]);

    // }
}