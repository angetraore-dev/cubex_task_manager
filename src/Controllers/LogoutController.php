<?php

namespace App\Controllers;

use App\Auth;

class LogoutController
{
    public function destroyAction() {
        Auth::logout();
        //header('Location:'.HTTP .'/login/showLogoutMessage');
        //exit();
    }


    public function logoutMessage(): bool|string
    {
        ob_start();
        //echo $_SESSION['user_id'] ?? 'cool';
        ?>
        <div class="col-sm-12 jumbotron text-center py-4  my-4" style="min-height: 620px;">
            <h1 class="text-success bg-white my-2 rounded"><i class="alert-warning"></i> You are successfully logout !</h1>
            <p><a href="<?= HTTP.'/login';?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> login</a></p>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * @return void
     */
    public function showLogoutMessageAction() {
        $title = 'Logout';
        $content = $this->logoutMessage();
        require_once DOCROOT .'/templates/layout.php';
    }

    /**
     * @return void
     */
    public function index()
    {
        if (Auth::isLoggedIn()){
            $this->destroyAction();
            $this->showLogoutMessageAction();
        }
        header('Location:'.HTTP.'/login');
        exit();
        //require DOCROOT .'/templates/404.php';
    }

}