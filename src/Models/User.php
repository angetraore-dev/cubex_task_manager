<?php

namespace App\Models;

use Exception;
use PDO;
//use App\Models\Database;

class User
{
    protected $user_id;
    protected $fullname;
    protected $password;
    protected $email;
    protected $roleid;
    protected $department;
    private Database $database;
    function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoleid()
    {
        return $this->roleid;
    }

    /**
     * @param mixed $roleid
     * @return User
     */
    public function setRoleid($roleid)
    {
        $this->roleid = $roleid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     * @return User
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return mixed
     */
    public static function read()
    {
        return StaticDb::getDB()->query("SELECT * FROM user", get_called_class());
    }

    function delGrpedForm()
    {
        $userList = self::read();
        if ($userList):

        ?>
        <form class="row g-3 needs-validation delgped" id="delgped" novalidate>
            <?php foreach ($userList as $item): ?>
                <input required type="checkbox" name="<?='list_'.$item->getUserId()?>" value="<?=$item->getUserId()?>"><?=$item->getFullname()?>
            <?php endforeach;?>
            <div class="invalid-feedback">You must select at least one item</div>
            <button type="button" class="btn btn-secondary cancelDelGpedUser" data-bs-dismiss="modal">cancel</button>
            <button type="button" id="delGpedUser" name="delGpedUser" class="btn btn-primary">delete</button>
        </form>
    <?php else: echo "<p class='text-muted text-center'>No data found</p>"; endif;
    }


    /**
     * @param string $identifier
     * @return mixed
     */
    public static function userAlreadyExist(string $identifier)
    {
        return self::findByEmail($identifier);
    }

    /**
     * @param $identifier
     * @return array|false|mixed
     */
    public static function findByEmail($identifier)
    {
        $stmt = "SELECT * FROM user WHERE email = '$identifier' LIMIT 1";
        return StaticDb::getDB()->query($stmt, get_called_class(), true);
    }

    /**
     * @param $identifier
     * @return array|false|mixed
     */
    public static function findById($identifier)
    {
        $sql = "SELECT * FROM user WHERE user_id = ?";
        return StaticDb::getDB()->prepare($sql, [$identifier], get_called_class(), true);
    }

    /**
     * @param $email
     * @param $password
     * @return array|false|mixed
     */
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);
        if ($user){
            if ( password_verify($password, $user->getPassword())){
                return $user;
            }
        }
        return false;
    }

    public function create(array $field):bool
    {
        $implodeColumns = implode(', ', array_keys($field));
        $implodePlaceholders = implode(', :', array_keys($field));
        $request = "INSERT INTO user($implodeColumns) VALUES (:". $implodePlaceholders .")";

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
     * @param int $identifier
     * @param array $field
     * @return bool
     */
    public function update(int $identifier, array $field):bool
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
        $stmt .="UPDATE user SET " .$st;
        $stmt .=" WHERE user_id = " .$identifier;
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
     * @param $identifier
     * @return bool
     */
    public function delete($identifier):bool
    {
        $stmt = "DELETE FROM user WHERE user_id = :user_id";
        $request = $this->database->dbConnect()->prepare($stmt);
        $request->bindValue(':user_id', $identifier, PDO::PARAM_INT);
        if ($request->execute()){
            return true;
        }
        return false;
    }



}

///**
//     * @return PDO|void
//     */
//    function UserDbConnect()
//    {
//        try {
//            return new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USER, DB_PASS);
//
//        }catch (Exception $exception){
//            echo $exception->getMessage();
//        }
//    }