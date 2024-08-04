<?php

namespace App;

use App\Models\User;

class Auth
{
    /**
     * @param $user
     * @return void
     */
    public static function login($user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['username'] = $user->getFullname();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['role'] = $user->getRoleid();

        //isset($_SESSION['role']) &&
        if ( $_SESSION['role'] == 1){

            $_SESSION['return_to'] = '/admin';

        }else{

            $_SESSION['return_to'] = '/dashboard';
        }

    }

    /**
     * @return void
     */
    public static function logout(): void
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
    public static function rememberRequestedPage(): void
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    /**
     * @return mixed|string
     */
    public static function getReturnToPage(): mixed
    {
        return $_SESSION['return_to'] ?? '/';
    }

    /**
     * @return array|false|mixed
     */
    public static function getUser(): mixed
    {

        if (isset($_SESSION['user_id'])){
            return User::findById($_SESSION['user_id']);
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        if (self::getUser()){
            return true;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public static function AuthorizationRequired(): bool|string
    {
        ob_start();
        ?>
        <div class="col-sm-12 jumbotron text-center  my-4" style="min-height: 620px;">
            <h1 class="text-danger"><i class="alert-warning"></i> You have not Authorized to access this resource!</h1>
            <p><a href="<?= HTTP.'/login';?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Sign in</a></p>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * @return bool|string
     */
    public static function notAuthorized():bool|string
    {
        ob_start();
        ?>
        <div class="col-sm-12 jumbotron text-center  my-4" style="min-height: 620px;">
            <h1 class="text-danger"><i class="alert-warning"></i> Access denied !</h1>
            <p><a href="<?= HTTP. Auth::getReturnToPage() ;?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Sign in</a></p>
        </div>

        <?php
        return ob_get_clean();
    }


}