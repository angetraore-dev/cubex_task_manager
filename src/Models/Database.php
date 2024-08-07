<?php

namespace App\Models;

use PDO;
use App\Param;
use PDOException;

class Database
{
    //private $db;
    //private PDO $conn;

    public function __construct()
    {
        //$this->db = new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);
    }

    ///**
    //     * @return PDO
    //     */
    //    public function dbConnect(): PDO
    //    {
    //        return new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);
    //    }

    /**
     * @return PDO|void
     */
    protected function getPDO():PDO
    {
        try {
            $conn = new PDO('mysql:host='.Param::DB_HOST.';dbname='.Param::DB_NAME.';charset=utf8',Param::DB_USER, Param::DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
        return $conn;
    }

    /**
     * @return Database
     */
    public static function getDb(): Database
    {
        return new Database();
    }

    /**
     * @param array $field
     * @param $class_name
     * @return bool
     */
    public function insert(array $field, $class_name): bool
    {
        $implodeColumns = implode(', ', array_keys($field));
        $implodePlaceholders = implode(', :', array_keys($field));
        $request = "INSERT INTO $class_name($implodeColumns) VALUES (:". $implodePlaceholders .")";
        $stmt = $this->getPDO()->prepare($request);
        foreach ( $field as $key => $value ){
            $stmt->bindValue(':'.$key, $value);
        }

        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    /**
     * @param int $identifier
     * @param array $field
     * @param $class_name
     * @return bool
     */
    public function update(int $identifier, array $field, $class_name):bool
    {
        $whereClause = $class_name.'_id';
        $st = "";
        $counter = 1;
        $total_fields = count($field);
        foreach ($field as $key => $value){
            if ($counter == $total_fields){
                $set = "$key = :" .$key;
                $st = $st . $set;

            }else{
                $set = "$key = :" .$key . ", ";
                $st = $st . $set;
                $counter++;
            }
        }
        $stmt ="";
        $stmt .="UPDATE $class_name SET " .$st;
        $stmt .=" WHERE .$whereClause. = " .$identifier;
        $req = $this->getPDO()->prepare($stmt);

        foreach ($field as $key => $value){
            $req->bindValue(':' .$key, $value);
        }
        if ($req->execute()){
            return true;
        }
        return false;
    }

    /**
     * @param int $identifier
     * @param $class_name
     * @return bool
     */
    public function delete(int $identifier, $class_name):bool
    {
        $whereClause = $class_name.'_id';
        $stmt = "DELETE FROM $class_name WHERE $whereClause = ?";
        $request = $this->getPDO()->prepare($stmt);
        $request->bindParam(1, $identifier);

        if ($request->execute()){
            return true;
        }
        return false;
    }
    /**
     * @param $stmt
     * @param $class_name
     * @param bool $one
     * @return array|false|mixed
     */
    public function query($stmt, $class_name, bool $one = false): mixed
    {
        $request = $this->getPDO()->query($stmt);
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
        $request = $this->getPDO()->prepare($stmt);
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
        return $this->getPDO()->lastInsertId();
    }

}