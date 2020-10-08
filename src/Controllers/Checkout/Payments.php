<?php
namespace App\Controller\Checkout;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class Payments {

    /**
     * Paypal Configuration variable
     *
     * @var array
     */
    protected $paypal_config;

    /**
     * Initialize API Context variable
     *
     * @var object
     */
    protected $apiContext;

    public function __construct() {
        $this->paypal_config = [
            'client_id' => $_ENV['PAYPAL_CLIENT_ID'],
            'secret' => $_ENV['PAYPAL_SECRET'],
            'settings' => [
                'mode' => $_ENV['PAYPAL_MODE'],
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => false
            ]
        ];

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->paypal_config['client_id'],
                $this->paypal_config['secret']
            )
        );
    }

    /**
     * Process payment with PayPal. Coming from the form
     *
     * @return void
     */
    public function confirm() {
        var_dump($_POST);
        die();
    }
}