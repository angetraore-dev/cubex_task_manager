<?php

namespace App;

class Config
{
    //Very Important to Update App To production server
    /**
     * @return void
     */
    public static function conf(): void
    {
        define("SITE_NAME", 'Cubex Task Manager');
        if ($_SERVER["HTTP_HOST"] == 'localhost'){
            define("ENV", 'development');
            $servername = $_SERVER["SERVER_NAME"] ."/php"; //return localhost/php
            $document_root = $_SERVER["DOCUMENT_ROOT"] ."/php"; //return /usr/local/var/www/php/taskmanagerapp

        }else{
            define("ENV", 'production');
        }

        switch (ENV){
            case "development":
                error_reporting(-1);
                define("HTTP", "HTTP://".$servername ."/taskmanagerapp");
                define("DOCROOT", $document_root. "/taskmanagerapp");

                break;
            case "production":
                error_reporting(0);
                define("HTTP", "HTTP://atdevs.ci");
                define("DOCROOT", "HTTP://atdevs.ci");

                break;
            default: require "templates/404.php";
        }
    }
}