<?php
namespace App\Controller;

use App\Model\Product;

class Products {

    public function __construct() {
        $this->model = new Product;
    }

    /**

    * Retrieve all products from the database
     *
     * @return void
     */
    public function getProducts() {
        $products = $this->model->getAll();

        foreach ($products as &$product) {
            $product["sizes"] = explode(', ', $product["sizes"]);
        }

        return $products;
    }

    /**
     * Retrieve the data of an specific product by its ID
     *
     * @param int $id
     * @return mixed    Array if item found, false otherwise
     */
    public function getItem($id) {
        $product = $this->model->getItemById($id);
        if (!!$product)
            $product["sizes"] = explode(', ', $product["sizes"]);

        return $product;
    }

    /**
     * Test items for the secondary carousel
     *
     * @return void
     */
    public function getNotReallyRandomProducts() {
        return $this->model->getTestItems();
    }

    public function addToCart($params) {
        if (is_null(Auth::getUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
        } else {
            if (!!$this->getItem($params['item'])) {
                $form_validation_errors = Validations::processForm($_POST);
                if (empty($form_validation_errors)) {
                    die("You did it we, everything is right");
                }
                else
                    Flash::addMessage($form_validation_errors, ERROR);
            } else
                Flash::addMessage(ERROR_MESSAGE, ERROR);
        }
        redirect("/product_details.{$params['item']}");
    }
}