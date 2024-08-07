<?php

namespace App\Models;

use App\Models\Database;
use App\Param;
use Exception;
use PDO;
//use App\Models\Database;

class StaticDb extends Database
{
    //private static Database $db;

    ///**
    //     * @return Database
    //     */
    //    public static function getDB():?Database
    //    {
    //        if (self::$db === null){
    //            self::$db = new Database();
    //        }
    //        return self::$db;
    //    }

    //public static function dbConnect()
    //    {
    //        static $dbb = null;
    //        if ($dbb === null){
    //            try {
    //                $dbb = new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);
    //                $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //            }catch (Exception $exception){
    //                echo $exception->getMessage();
    //                die();
    //            }
    //        }
    //        return $dbb;
    //    }



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
    public static function RedirectToDashboardifUserLogged(): void
    {  ?>
        <div class="col-sm-12 jumbotron text-center py-4  my-4" style="min-height: 620px;">
            <h1 class="text-success bg-white my-2 rounded"><i class="alert-warning"></i> You are already logged !</h1>
            <p><a href="<?= HTTP.'/dashbord';?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Go to dashboard</a></p>
        </div>
        <?php
    }

}