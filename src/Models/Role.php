<?php

namespace App\Models;

use PDO;

class Role
{
    protected $role_id;
    protected $role_name;
    private Database $database;
    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * @param mixed $role_name
     * @return Role
     */
    public function setRoleName($role_name)
    {
        $this->role_name = $role_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public static function readAll(): mixed
    {
        return StaticDb::getDB()->query("SELECT * FROM role", get_called_class());
    }

    /**
     * @param array $field
     * @return bool
     */
    public function create(array $field):bool
    {
        $implodeColumns = implode(', ', array_keys($field));
        $implodePlaceholders = implode(', :', array_keys($field));
        $request = "INSERT INTO role($implodeColumns) VALUES (:". $implodePlaceholders .")";

        $stmt = $this->database->dbConnect()->prepare($request);

        foreach ( $field as $key => $value ){
            $stmt->bindValue(':'.$key, $value);
        }

        if ($stmt->execute()){
            return true;
        }
        return false;
    }

    /**
     * @param int $roleId
     * @param array $field
     * @return bool
     */
    public function edit(int $roleId, array $field):bool
    {
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
        $stmt .="UPDATE role SET " .$st;
        $stmt .=" WHERE role_id = " .$roleId;
        $req = $this->database->dbConnect()->prepare($stmt);

        foreach ($field as $key => $value){
            $req->bindValue(':' .$key, $value);
        }
        if ($req->execute()){
            return true;
        }
        return false;
    }

    /**
     * @param int $roleId
     * @return bool
     */
    public function delete(int $roleId):bool
    {
        $stmt = "DELETE FROM role WHERE role_id = :role_id";
        $request = $this->database->dbConnect()->prepare($stmt);
        $request->bindValue(':role_id', $roleId, PDO::PARAM_INT);
        if ($request->execute()){
            return true;
        }
        return false;
    }


}