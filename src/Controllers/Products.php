<?php
namespace App\Controller;

use App\Model\Product;
use App\Model\Cart;

class Products {

    public function __construct() {
        $this->product_model = new Product;
        $this->cart_model = new Cart;
    }

    /**

    * Retrieve all products from the database
     *
     * @return void
     */
    public function getProducts() {
        $products = $this->product_model->getAll();

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
        $product = $this->product_model->getItemById($id);
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
        return $this->product_model->getTestItems();
    }

    /**
     * Called after submitting form in product details page
     * Perform validations for that form and call the "add" method if everything's right
     *
     * @param array $params     $_POST data
     * @return void
     */
    public function validateAddingForm($params) {
        if (is_null(Auth::getUser())) {
            Flash::addMessage(LOGIN_REQUIRED, ERROR);
        } else {
            if (!!$this->getItem($params['item'])) {
                $form_validation_errors = Validations::processForm($_POST);
                if (empty($form_validation_errors))
                    $this->addItemToCart($params['item'], $_POST['size'], $_POST['quantity']);
                else
                    Flash::addMessage($form_validation_errors, ERROR);
            } else
                Flash::addMessage(ERROR_MESSAGE, ERROR);
        }
        redirect("/product_details.{$params['item']}");
    }

    /**
     * Add an item to the user's cart. At this point, the data is fully validated
     *
     * @param integer $item_id      Item's ID
     * @param mixed $size           Could be string if it's clothing size or float if it's shoe size
     * @param integer $quantity     How many units of the item will be added
     * @return void
     */
    public function addItemToCart(int $item_id, $size, int $quantity) : void {
        $cart = $this->cart_model->getUsersCartId();
        $subtotal = $this->calculateSubtotal($quantity, $this->getItem($item_id));
        // Check if item is already in the user's cart
        if (!!$this->cart_model->findItemInCart($item_id))
            // UPDATE quantity and size because it already exists
            $this->cart_model->updateItem($cart, $item_id, $size, $quantity, $subtotal);
        else
            // INSERT item in the cart
            $this->cart_model->addItem($cart, $item_id, $size, $quantity, $subtotal);

        Flash::addMessage(ITEM_ADDED);
    }

    /**
     * Get product's subtotal by calculating its price with the discount
     *
     * @param array $item
     * @return float
     */
    public function calculateSubtotal($quantity, $item) : float {
        return $quantity * ($item['price'] - ($item['price'] * ($item['discount'] / 100)));
    }
}