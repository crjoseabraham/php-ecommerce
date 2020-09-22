<?php
namespace App\Controller\Helper;

class Cookies {
    /**
     * Set cookie
     * @param  string $name       Cookie name
     * @param  string $value      Cookie value (token)
     * @param  string $expires_at Expiry date in time() format
     * @param  string $path       Cookie path
     * @return void
     */
    public static function set($name, $value, $expires_at, $path = '') {
        setcookie($name, $value, $expires_at, $path);
    }

    /**
     * Check if certain cookie is set
     * @param  string $name Cookie name
     * @return mixed        Cookie data if it exists, false if not
     */
    public static function findCookie($name) {
        return $_COOKIE[$name] ?? false;
    }

    /**
     * Check if a cookie expiry date has passed
     * @param  string $cookie_expiry_date Date
     * @return boolean                    True if has expired, false otherwise
     */
    public static function hasExpired($cookie_expiry_date) : bool {
        return strtotime($cookie_expiry_date) < time();
    }

    /**
     * Delete session cookie for log out
     */
    public static function deleteSessionCookie() {
        if (ini_get('session.use_cookies'))
        {
            $params = session_get_cookie_params();

            setcookie(
                "remember_me",
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
    }
}