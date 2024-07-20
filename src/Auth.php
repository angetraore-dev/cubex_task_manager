<?php

namespace App;

class Auth
{
    /**
     * @param $user
     * @return void
     */
    public static function login($user)
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['username'] = $user->getFullname();
        $_SESSION['email'] = $user->getEmail();
    }

    /**
     * @return void
     */
    public static function logout()
    {
        $_SESSION = [];
        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session
        session_destroy();
    }

    /**
     * @return void
     */
    public static function rememberRequestedPage() {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    /**
     * @return mixed|string
     */
    public static function getReturnToPage() {
        return $_SESSION['return_to'] ?? '/';
    }

}