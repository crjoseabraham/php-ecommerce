<?php
namespace App\Controller;

use App\Model\Session;

class Sessions {

    /**
     * Start session for a user
     * @param array $user
     * @return void
     */
    public function startNew($user) {
        new Session($user["id"]);
        redirect('/');
    }

    /**
     * Log out the user by destroying the session and deleting cookies
     * @return void
     */
    public function logOut() {
        $session_model = new Session();
        $session_model->destroySession();
        redirect('/');
        // Delete the session cookie
        //Cookies::deleteSessionCookie();
        // Finally destroy the session and forget the remembered login
        //Auth::forgetLogin();
    }
}
