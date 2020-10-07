<?php
namespace App\Controller\Helper;

/**
 * Token class
 * Generate unique IDs to use
 */
class Token {
    /**
     * The token value
     * @var string
     */
    protected $token;
    protected $secret_key;

    public function __construct($token_value = null) {
        $this->token = $token_value ? $token_value : bin2hex(random_bytes(16));
        $this->secret_key = $_ENV['SECRET_KEY'];
    }

    /**
     * Return the original token without the hash
     * @return string
     */
    public function getValue() {
        return $this->token;
    }

    /**
     * Return hashed token
     * @return string
     */
    public function getHash() {
        return hash_hmac('sha256', $this->token, $this->secret_key);
    }
}