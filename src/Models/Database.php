<?php

namespace App\Models;

use PDO;
use App\Param;

class Database
{
    //private $conn;


    /**
     * @return PDO
     */
    public function dbConnect(): PDO
    {
        return new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);
    }

    /**
     * @param $stmt
     * @param $class_name
     * @param bool $one
     * @return array|false|mixed
     */
    public function query($stmt, $class_name, bool $one = false): mixed
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
    public function prepare($stmt, $attributes, $class_name, bool $one = false ): mixed
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
    public function LastInsertId(): bool|string
    {
        return $this->dbConnect()->lastInsertId();
    }

}