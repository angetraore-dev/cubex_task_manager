<?php

namespace App\Models;

//use App\Models\Database;
//use \AllowDynamicProperties;

//#[AllowDynamicProperties]
class User
{
    protected $user_id;
    protected $fullname;
    protected $password;
    protected $email;
    protected $roleid;
    protected $department;

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
    public function getFullname(): mixed
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     * @return User
     */
    public function setFullname($fullname): static
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword(): mixed
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoleid(): mixed
    {
        return $this->roleid;
    }

    /**
     * @param mixed $roleid
     * @return User
     */
    public function setRoleid($roleid): static
    {
        $this->roleid = $roleid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment(): mixed
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     * @return User
     */
    public function setDepartment($department): static
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return mixed
     */
    public static function read(): mixed
    {
        return StaticDb::getDB()->query("SELECT * FROM user", get_called_class());
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
    public static function findById($identifier): mixed
    {
        $sql = "SELECT * FROM user WHERE user_id = ?";
        return StaticDb::getDB()->prepare($sql, [$identifier], get_called_class(), true);
    }

    /**
     * @param $departmentid
     * @return array|false|mixed
     */
    public static function findByDepartmentId($departmentid): mixed
    {
        $sql = "SELECT *, d.libelle, d.color FROM user INNER JOIN department d on d.department_id = user.department WHERE department = ?";
        return StaticDb::getDB()->prepare($sql,[$departmentid], get_called_class());
    }

    /**
     * @param $email
     * @param $password
     * @return array|false|mixed
     */
    public static function authenticate($email, $password): mixed
    {
        $user = static::findByEmail($email);
        if ($user){
            if ( password_verify($password, $user->getPassword())){
                return $user;
            }
        }
        return false;
    }

    /**
     * @return void
     */
    function delGrpedForm():void
    {
        $userList = self::read();
        if ($userList):
            ?>
            <form class="row g-3 needs-validation delgped" id="delgped" novalidate>
                <?php foreach ($userList as $item): if($_SESSION["user_id"] != $item->getUserId()):?>
                    <div class="input-group <?=$item->getUserId()?>">
                        <input class="form-check-input" required type="checkbox" id="<?='list_'.$item->getUserId()?>" name="<?='list_'.$item->getUserId()?>" value="<?=$item->getUserId()?>">
                        <label class="form-check-label mx-1" for="<?='list_'.$item->getUserId()?>"><?=$item->getFullname()?></label>
                    </div>

                <?php endif; endforeach;?>
                <div class="invalid-feedback">You must select at least one item</div>
                <button type="button" class="btn btn-secondary cancelDelGpedUser" data-bs-dismiss="modal">cancel</button>
                <button type="button" id="delGpedUser" name="delGpedUser" class="btn btn-primary">delete</button>
            </form>
        <?php else: echo "<p class='text-muted text-center'>No data found</p>"; endif;
    }

    /**
     * Display user By Department in User Dropdown Filter
     * @param $departmentId
     * @return void
     */
    public function displayUserListByDepartment($departmentId):void
    {
        $usersList = self::findByDepartmentId($departmentId);
        if ($usersList):
            foreach ($usersList as $userList):
        ?>
            <li class="dropdown-item btn" data-id="<?=$userList->getUserId()?>">
                <p>
                    <?=$userList->getFullname()?>
                </p>
            </li>

        <?php
            endforeach;
            else: echo '<li>No records found</li>';
            endif;
    }

    /**
     * @param $departmentId
     * @return void
     */
    public function userListBydepartmentInAddTaskForm($departmentId):void
    {
        $usersLists = self::findByDepartmentId($departmentId);
        if ($usersLists):
            ?>
            <label for="userid" class="form-label">choose a responsible</label>
            <select class="form-select" style="border: gold 1px solid;" name="userid" id="userid" required>
                <option value="" class="form-control">Choose the responsible</option>
                <?php foreach ($usersLists as $userList): ?>
                    <option class="form-control" value="<?=$userList->getUserId()?>">
                        <?=$userList->getFullname()?>
                    </option>
                <?php endforeach;?>
            </select>
            <div class="invalid-feedback">Please choose the responsible in the list</div>

        <?php else: echo '<li>No records found</li>';
        endif;
    }



}