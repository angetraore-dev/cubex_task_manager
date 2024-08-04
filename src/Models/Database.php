<?php

namespace App\Models;

use Exception;
use PDO;
use App\Param;
//require_once (DOCROOT.'/config/param.php');

class Database
{
    /**
     * @return PDO|void
     */
    public function dbConnect():PDO|null
    {
        //return new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USER, DB_PASS);
        try {

            return new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);

        }catch (Exception $exception){
            echo $exception->getMessage();
        }
    }

    /**
     * @return PDO|null
     */
    public static function staticDbConnect()
    {
        static $db = null;
        if ($db === null){
            $db = new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    /**
     * @param $stmt
     * @param $class_name
     * @param bool $one
     * @return array|false|mixed
     */
    public function query($stmt, $class_name, bool $one = false)
    {
        $request = $this->dbConnect()->query($stmt);
        $request->setFetchMode(PDO::FETCH_CLASS, $class_name);

        if ($one){
            return $request->fetch();
        }
        return $request->fetchAll();
    }

    /**
     * @param $stmt
     * @param $attributes
     * @param $class_name
     * @param bool $one
     * @return array|false|mixed
     */
    public function prepare($stmt, $attributes, $class_name, bool $one = false )
    {
        $request = $this->dbConnect()->prepare($stmt);
        $request->execute($attributes);
        $request->setFetchMode(PDO::FETCH_CLASS, $class_name);

        if ($one){
            return $request->fetch();
        }
        return $request->fetchAll();
    }

    /**
     * @return false|string
     */
    public function LastInsertId()
    {
        return $this->dbConnect()->lastInsertId();
    }

}