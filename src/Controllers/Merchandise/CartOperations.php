<?php
namespace App\Controller\Merchandise;

use App\Controller\Helper\Flash;
use App\Controller\Helper\Validations;
use App\Controller\Account\Accounts;
use App\Model\Merchandise\Cart;

class CartOperations {

    public function __construct() {
        $this->cart = new Cart();
        $this->accounts = new Accounts();
        $this->products = new Products();
    }

    /**
     * Get the logged user's cart
     * @return array Array of objects (cart items)
     */
    public function get(): array {
        return $this->cart->get();
    }

    /**
     * Add an item to the cart or update its values if it's there already
     * @param array $params     Item's ID
     * @return void
     */
    public function add(array $params): void {
        $this->validateAdding($params['item'], $_POST);

        $subtotal = $this->calculateSubtotal(
            $_POST['quantity'],
            $this->products->get($params['item'], false)
        );

        if (empty(Validations::getErrors())) {
            !!$this->cart->find($params['item'])
                ? $this->cart->update($params['item'], $_POST, $subtotal)
                : $this->cart->add($params['item'], $_POST, $subtotal);

            Flash::addMessage(ITEM_ADDED);
        }
        else
            Flash::addMessage(Validations::getErrors(), ERROR);

        redirect('/product_details.' . $params['item']);
    }

    /**
     * Change the quantity for a product from the cart page
     *
     * @return void
     */
    public function changeQuantity(): void {
        $subtotal = $this->calculateSubtotal(
            intval($_POST['quantity']),
            $this->products->get($_POST['item'], false)
        );

        $this->cart->update(intval($_POST['item']), $_POST, $subtotal);
        echo json_encode(["subtotal" => $subtotal, "cart_total" => $this->calculateTotal()]);
    }

    /**
     * Remove item from cart
     */
    public function remove() {
        $this->cart->remove(intval($_POST['item']));
        echo json_encode(["cart_total" => $this->calculateTotal()]);
    }

    /**
     * Perform validations before adding an item to the cart
     * @param  int    $item_id The item ID
     * @param  array  $post    $_POST data
     * @return void
     */
    private function validateAdding(int $item_id, array $post): void {
        if (is_null($this->accounts->getLoggedUser()))
            Validations::setError(LOGIN_REQUIRED);
        else {
            if (!!$this->products->get($item_id, false))
                $form_validation_errors = Validations::processForm($post);
            else
                Validations::setError(ERROR_MESSAGE);
        }
    }

    /**
     * Calculate an item's subtotal applying the discount to the price and
     * then multiply that by the $quantity value
     * @param  int $quantity    Desired quantity to add
     * @param  object $item     The item object
     * @return float            Item's subtotal rounded to 2 decimals
     */
    private function calculateSubtotal(int $quantity, object $item): float {
        return round($quantity * ($item->price - ($item->price * ($item->discount / 100))), 2);
    }

    /**
     * Get current user's cart total amount
     *
     * @return float            Cart total rounded to 2 decimals
     */
    public function calculateTotal(): float {
        $cart = $this->get();
        $amount = 0;
        foreach($cart as $item) {
            $amount += $item->subtotal;
        }

        return round($amount, 2);
    }

    /**
     * Empty the user's cart
     *
     * @param integer $user_id
     * @return void
     */
    public function emptyCart(int $user_id) {
        $this->cart->empty($user_id);
    }
}