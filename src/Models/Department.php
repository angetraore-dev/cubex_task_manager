<?php

namespace App\Models;

use PDO;

class Department
{
    protected $department_id;
    protected $libelle;

    private Database $database;
    function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @return mixed
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }


    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     * @return Department
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return array|false|mixed
     */
    public static function readAll(): mixed
    {
        return StaticDb::getDB()->query("SELECT * FROM department", get_called_class());
    }

    /**
     * @param int $departementId
     * @return array|false|mixed
     */
    public static function getAllUserInOneDepartment(int $departementId): mixed
    {
        $req = "SELECT * JOIN user u on d.department_id = u.department WHERE d.department_id = ?";
        return StaticDb::getDB()->prepare($req, [$departementId], get_called_class());
    }

    /**
     * @param array $field
     * @return bool
     */
    public function create(array $field):bool
    {
        $implodeColumns = implode(', ', array_keys($field));
        $implodePlaceholders = implode(', :', array_keys($field));
        $request = "INSERT INTO department($implodeColumns) VALUES (:". $implodePlaceholders .")";
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
     * @param int $departmentId
     * @param array $field
     * @return bool
     */
    public function edit(int $departmentId, array $field):bool
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
        $stmt .="UPDATE department SET " .$st;
        $stmt .=" WHERE department_id = " .$departmentId;
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
     * @param int $departmentId
     * @return bool
     */
    public function delete(int $departmentId):bool
    {
        $stmt = "DELETE FROM department WHERE department_id = :department_id";
        $request = $this->database->dbConnect()->prepare($stmt);
        $request->bindValue(':department_id', $departmentId, PDO::PARAM_INT);
        if ($request->execute()){
            return true;
        }
        return false;
    }

}