<?php

namespace App\Models;
//require_once (DOCROOT.'/config/param.php');

class StaticDb extends Database
{
    private static Database|null $db = null;

    /**
     * @return Database|null
     */
    public static function getDB():?Database
    {
        if (self::$db === null){
            self::$db = new Database();
        }
        return self::$db;
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function getClass($class): mixed
    {
        return self::getDB()->query("SELECT * FROM $class", get_called_class());
    }

    /**
     * @return false|string
     */
    public static function LastInsert()
    {
        return self::getDB()->LastInsertId();
    }

    /**
     * @return void
     */
    public static function notFound(): void
    {
        ?>
        <div class="col-sm-12 jumbotron text-center" style="min-height: 620px;">
            <h1>Page Not Found</h1>
            <p><a href="<?= HTTP.'/login';?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Go Back</a></p>
        </div>
        <?php
    }

    /**
     * @return void
     */
    public static function AuthorizationRequired(): void
    {
        ?>
        <div class="col-sm-12 jumbotron text-center  my-4" style="min-height: 620px;">
            <h1 class="text-danger"><i class="alert-warning"></i> You have not Authorized to access this resource!</h1>
            <p><a href="<?= HTTP.'/login';?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Go Back</a></p>
        </div>

        <?php
        //header("location: ?page=login");
    }

    /**
     * @return void
     */
    public static function RedirectToDashboardifUserLogged(): void
    {  ?>
        <div class="col-sm-12 jumbotron text-center py-4  my-4" style="min-height: 620px;">
            <h1 class="text-success bg-white my-2 rounded"><i class="alert-warning"></i> You are already logged !</h1>
            <p><a href="<?= HTTP.'/dashbord';?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Go to dashboard</a></p>
        </div>
        <?php
    }

}