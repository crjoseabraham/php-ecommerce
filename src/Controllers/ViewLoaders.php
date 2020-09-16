<?php
namespace App\Controller;

use App\Core\View;

class ViewLoaders {

    public function __construct() {
        $this->view = new View;
        $this->products = new Products;
    }

    /**
     * Load homepage with all parameters needed
     * @return void
     */
    public function homepage() {
        $this->view->render("layouts/home", [
            "user" => Auth::getUser(),
            "session" => $_SESSION,
            "products" => $this->products->getProducts(),
            // Just to show something different
            "products2" => $this->products->getNotReallyRandomProducts()
        ]);
    }

    /**
     * Load page "Forgot my password"
     * @return void
     */
    public function forgottenPassword() {
        $this->view->render("layouts/forget_password", [
            "user" => Auth::getUser(),
            "session" => $_SESSION
        ]);
    }

    /**
     * Page with the form to create a new password in case user forgot it
     * It is restricted if the link has expired or wasn't found
     * @param array $params     Array with user's ID and pass reset token
     * @return void
     */
    public function resetPasswordForm($params) : void {
        $user = \App\Model\User::getUserByPasswordResetToken($params['token']);

        if (!$user || !(strtotime($user['password_reset_expires_at']) < time())) {
            // Token expired. Redirect home
            redirect("/");
        } else {
            // Token is still valid. Proceed
            $this->view->render("layouts/reset_password", $params);
        }
    }

    /**
     * Sign In form (modal)
     * @return void
     */
    public function loginFormView() {
        $this->view->render("components/login_form");
    }

    /**
     * Sign Up form (modal)
     * @return void
     */
    public function signUpFormView() {
        $this->view->render("components/register_form");
    }

    /**
     * Profile page
     * @return void
     */
    public function profile() : void {
        if (is_null(Auth::getUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
            redirect('/');
        } else
            $this->view->render("layouts/profile", [
                'user' => Auth::getUser(),
                'session' => $_SESSION
            ]);
    }

    /**
     * "Delete account" confirmation page
     *
     * @return void
     */
    public function deleteAccountForm() : void {
        if (is_null(Auth::getUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
            redirect('/');
        } else
            $this->view->render("layouts/profile_delete", ['session' => $_SESSION]);
    }

    /**
     * Certain product's details page
     *
     * @param array $params     Item's ID passed in the URL
     * @return void
     */
    public function productDetails($params) : void {
        $this->view->render("layouts/product_details", [
            'session' => $_SESSION,
            'product' => $this->products->getItem($params['item'])
        ]);
    }
}