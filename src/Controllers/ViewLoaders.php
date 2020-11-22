<?php
namespace App\Controller;

use App\Core\View;
use App\Controller\Helper\Flash;
use App\Controller\Account\Accounts;
use App\Controller\Account\Passwords;
use App\Controller\Checkout\Orders;
use App\Controller\Merchandise\Products;
use App\Controller\Merchandise\CartOperations;
use App\Model\Authentication\User;

class ViewLoaders {
    public function __construct() {
        $this->view = new View;
        $this->accounts = new Accounts;
        $this->passwords = new Passwords;
        $this->products = new Products;
        $this->cart = new CartOperations();
        $this->default_params = [
            "user" => $this->accounts->getLoggedUser(),
            "session" => $_SESSION
        ];
    }

    /**
     * Load homepage with all parameters needed
     * @return void
     */
    public function homepage() {
        $this->view->render("layouts/home", array_merge($this->default_params, [
            "cart" => isset($_SESSION['user']) ? $this->cart->get() : null,
            "products" => $this->products->get(),
            "products2" => $this->products->getAllWith('`product_id` > 1017')
        ]));
    }

    /**
     * Load page "Forgot my password"
     * @return void
     */
    public function forgottenPassword() {
        $this->view->render("layouts/forget_password", $this->default_params);
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
            $this->view->render("layouts/profile", array_merge($this->default_params, [
                "orders" => Orders::get()
            ]));
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

    /**
     * Certain product's details page
     *
     * @param array $params     Item's ID passed in the URL
     * @return void
     */
    public function productDetails($params) : void {
        $this->view->render("layouts/product_details", [
            'session' => $_SESSION,
            'item' => $this->products->get($params['item'], false),
            "cart" => isset($_SESSION['user']) ? $this->cart->get() : null
        ]);

    }

    /**
     * Load user's cart
     * @return void
     */
    public function cartPage(): void {
        if (is_null($this->accounts->getLoggedUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
            redirect('/');
        } else {
            $this->view->render("layouts/cart_checkout_page", array_merge($this->default_params, [
                "cart" => $this->cart->get()
            ]));
        }
    }

    /**
     * Explore page
     * @param array $params
     * @return void
     */
    public function explore(array $params) {
        // Get all categories
        $categories = $this->products->getCategories();
        $category_index = array_search(ucfirst($params['category']), array_column($categories, 'name'));
        // Find the corresponding ID in the database for the category
        $selected_category_id = $category_index === false ? 0 : intval($categories[$category_index]['id']);
        // Select products based on category
        $products = $selected_category_id === 0
                        ? $this->products->get()
                        : $this->products->getAllWith("`category` = {$selected_category_id}");
        // Render view
        $this->view->render("layouts/explore", array_merge($this->default_params, [
            "items" => $products,
            "categories" => $categories,
            "selected_category" => $selected_category_id
        ]));
    }
}