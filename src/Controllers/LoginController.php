<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Database;
use App\Models\StaticDb;
use App\Models\User;

class LoginController
{
    //private User $user;
    //
    //    public function __construct()
    //    {
    //        $this->user = new User();
    //    }
    /**
     * @return void
     */
    public function index()
    {
        $title = 'login';
        $content = $this->loginForm();
        require_once DOCROOT .'/templates/layout.php';
    }

    /**
     * @return false|string
     */
    function loginForm()
    {
        ob_start();
    ?>

        <div class="col-md-4 mx-auto me-auto my-4 p-2">
            <h3 class="text-center text-uppercase fw-bold my-2">Sign In</h3>
            <form role="form" class="needs-validation text-uppercase g-3 mb-3 p-2 text-uppercase" name="loginform" id="loginform" novalidate>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control bg-body-dark gold" id="floatingEmail" name="floatingEmail" placeholder="name@example.com"
                           pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
                    <label for="floatingEmail">Email address</label>
                    <div class="invalid-feedback">
                        Please enter a valid email
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <!--pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"
                          -->
                    <input minlength="6" maxlength="9" type="password" class="form-control rounded rounded-0" id="floatingPassword" name="floatingPassword" placeholder="Password"
                            required>
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">
                        Cannot be empty, please fill !
                    </div>
                </div>
                <!--col-md-6 mx-auto text-center align-items-center mb-3-->
                <button class="btn btn-lg login text-center border border-2 border-white rounded rounded-0 text-capitalize" style="width: 100% !important; color: #FFFFFF !important"  name="login" id="login" type="submit">
                    <i class="fa fa-refresh fa-spin d-none"></i> Login
                </button>

            </form>
        </div>
    <?php
        return ob_get_clean();
    }

    /**
     * @return void
     */
    protected function before()
    {
    }
    /**
     * @return void
     */
    protected function after()
    {
    }

    /**
     * @param $url
     * @return void
     */
    public function redirect($url): void
    {
        header('Location:'.HTTP .$url, true, 303);
        exit();
    }

    /**
     * @return void
     */
    public function requireLogin()
    {
        if ( !Auth::getUser()){
            $this->redirect('/login');
        }
    }

    /**
     * @return void
     */
    public function loginRequest():void
    {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST) ){
            switch ($_POST){
                case isset($_POST["login"]):
                    $data = json_decode($_POST["login"]);
                    $user = User::authenticate($data->floatingEmail, $data->floatingPassword);
//var_dump($user);
                    if ( $user ){

                        Auth::login($user);
                        //$this->redirect(Auth::getReturnToPage());
                        echo Auth::getReturnToPage();
                    }
                    echo false;
                    break;
                default: StaticDb::notFound(); break;
            }

        }else{
            StaticDb::notFound();
        }

    }


}
