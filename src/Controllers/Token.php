<?php
namespace App\Controller;

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

    public function __construct($token_value = null) {
        $this->token = $token_value ? $token_value : bin2hex(random_bytes(16));
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
        return hash_hmac('sha256', $this->token, SECRET_KEY);
    }
}