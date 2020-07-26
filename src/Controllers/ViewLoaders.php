<?php
namespace App\Controller;

use App\Core\View;

class ViewLoaders {

    public function __construct() {
        $this->view = new View();
        $this->products = new Products();
    }

    /**
     * Load homepage with all parameters needed
     * @return void
     */
    public function homepage() {
        $this->view->render("layouts/home", [
            "session" => $_SESSION,
            "products" => $this->products->getProducts(),
            // Just to show something different
            "products2" => $this->products->getNotReallyRandomProducts()
        ]);
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
     * Load the view for the modal with an item's data
     * @param array $params Array containing the clicked product's ID
     * @return void
     */
    public function showItemDetails($params) {
        $this->view->render("components/item_details", $this->products->getItem($params["id"]));
    }
}