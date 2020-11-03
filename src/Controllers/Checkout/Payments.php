<?php
namespace App\Controller\Checkout;

use Omnipay\Omnipay;

class Payments {

    public function new() {}

    /**
     * Set up PayPal Checkout gateway
     * @return void
     */
    public function gateway() {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername($_ENV['PAYPAL_USERNAME']);
        $gateway->setPassword($_ENV['PAYPAL_PASSWORD']);
        $gateway->setSignature($_ENV['PAYPAL_SIGNATURE']);
        $gateway->setTestMode(true); // Set false for production
        return $gateway;
    }

    /**
     * Execute purchase process
     * @param array $parameters
     * @return void
     */
    public function purchase(array $parameters) {
        $response = $this->gateway()
            ->purchase($parameters)
            ->send();

        return $response;
    }

    /**
     * After payment process is completed
     * @param array $parameters
     * @return void
     */
    public function complete(array $parameters) {
        $response = $this->gateway()
            ->completePurchase($parameters)
            ->send();

        return $response;
    }
}