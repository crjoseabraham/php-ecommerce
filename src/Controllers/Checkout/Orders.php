<?php
namespace App\Controller\Checkout;

use App\Controller\Helper\Flash;
use App\Controller\Merchandise\CartOperations;
use App\Model\Checkout\Order;

class Orders {

    const PAYMENT_COMPLETED = 1;
    const PAYMENT_PENDING = 0;

    /**
     * Create an order, at this point payment isn't confirmed so its status will be set as PENDING
     * @param string $order_id
     * @param integer $shipping
     * @param float $amount
     * @return void
     */
    public function create(string $order_id, int $shipping, float $amount): void {
        $shipping_costs = (intval($shipping) === 7) ? round(($amount * 0.07), 2) : 0;
        $order_total = $amount + $shipping_costs;
        $order_model = new Order;
        $order_model->new([
            "id" => $order_id,
            "user" => $_SESSION['user'],
            "created_at" => date('Y-m-d H:i:s'),
            "shipping" => $shipping_costs,
            "amount" => $order_total,
            "payment_status" => self::PAYMENT_PENDING
        ]);
    }

    /**
     * Find an order by its ID
     * @param string $order_id
     * @return void
     */
    public function find(string $order_id) {
        return Order::find($order_id);
    }

    /**
     * Update an order status to COMPLETED after the payment is confirmed
     * @param string $order_id
     * @param string $transaction_id
     * @return void
     */
    public function update(string $order_id, string $transaction_id): void {
        $order_model = new Order;
        $order_model->update($order_id, $transaction_id, self::PAYMENT_COMPLETED);
    }

    /**
     * Coming from the form to pay. Perform checkout process
     * @return void
     */
    public function checkout(): void {
        // 1. validate shipping
        if (intval($_POST['shipping']) !== 0 && intval($_POST['shipping']) !== 7)
            die("INVALID SHIPPING METHOD");
        // 2. set transactions details like ID and calculate the amount
        $cart_operations = new CartOperations;
        $order_id = $_SESSION['user'] . date('YmdHis').rand(10000,90000);
        $order_amount = $cart_operations->calculateTotal();
        $order_amount += (intval($_POST['shipping']) === 7) ? round(($order_amount * 0.07), 2) : 0;
        // 3. create payment object and pass array to purchase()
        $payments = new Payments;
        $response = $payments->purchase([
            'amount' => $order_amount,
            'transactionId' => $order_id,
            'currency' => 'USD',
            'cancelUrl' => "{$_ENV['URLROOT']}/payment_cancelled_{$order_id}",
            'returnUrl' => "{$_ENV['URLROOT']}/payment_success_{$order_id}"
        ]);
        // 4. if everything ok create a preorder object
        if ($response->isRedirect()) {
            // 5. store preorder in database with PENDING status
            $this->create($order_id, intval($_POST['shipping']), $cart_operations->calculateTotal());
            $response->redirect();
        } else {
            echo $response->getMessage();
            die();
        }
    }

    /**
     * Action for when the payment is completed successfully
     * @param array $params
     * @return void
     */
    public function completed(array $params) {
        $order = $this->find($params['id']);
        $payments = new Payments;
        $response = $payments->complete([
            'amount' => $order->amount,
            'transactionId' => $order->id,
            'currency' => 'USD',
            'cancelUrl' => "{$_ENV['URLROOT']}/payment_cancelled_{$order->id}",
            'returnUrl' => "{$_ENV['URLROOT']}/payment_success_{$order->id}"
        ]);

        if ($response->isSuccessful()) {
            // 1. update order data
            $this->update($order->id, $response->getTransactionReference());
            // 2. go to handle cart
            $order_model = new Order;
            $order_model->submitOrderDetails($order->user, $order->id);
            $cart_operations = new CartOperations;
            $cart_operations->emptyCart($order->user);
            // 3. email
            // 4. redirect
            Flash::addMessage(PURCHASE_COMPLETED);
            Flash::addMessage(PURCHASE_PROFILEMSG, INFO);
            redirect('/cart-checkout');
        } else {
            echo $response->getMessage();
            die();
        }
    }

    /**
     * Action for when the payment is cancelled
     * @param array $params
     * @return void
     */
    public function cancelled(array $params) {
        Flash::addMessage(PURCHASE_CANCELLED, INFO);
        redirect('/cart-checkout');
    }
}