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

    /**
     * @return void
     */
    public function addUserForm():void
    {
        ?>
        <form class="row col-md-8 mx-auto bg-body-tertiary text-dark rounded rounded-2 opacity-80 g-3 my-4 needs-validation" id="userForm" novalidate>
            <h3 class="my-3 fw-small fs-6 bg-dark text-white rounded rounded-2 text-center text-uppercase p-1 border border-1">add user Form</h3>

            <div class="col-md-4 mb-3">
                <label for="fullname">Fullname</label>
                <input type="text" name="fullname" id="fullname" class="form-control bg-body-tertiary text-dark" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control bg-body-tertiary text-dark" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
                <div class="invalid-feedback">
                    Please fill out
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="password">Password</label>
                <input minlength="6" maxlength="9" type="password" name="password" id="password" class="form-control bg-body-tertiary text-dark" required>
                <div class="invalid-feedback">Please enter a valid password</div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="role">User role</label>
                <select class="form-select" id="role" name="role" required>
                    <option class="form-control" value="">choose role</option>
                    <?php $role = Role::readAll(); if ($role): foreach ($role as $ro): ?>
                        <option class="text-center" value="<?=$ro->getRoleId()?>"><?= $ro->getRoleName()?></option>
                    <?php endforeach; else:?>
                        <p class="text-muted"> Please create department before </p>
                    <?php endif;?>
                </select>
                <div class="invalid-feedback">Please enter a role user</div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="department">User department</label>
                <select class="form-select" id="department" name="department" required>
                    <option class="form-control" value="">choose department</option>
                    <?php $department = Department::readAll(); if($department) : foreach ($department as $dep): ?>
                        <option class="text-center" value="<?=$dep->getDepartmentId()?>"><?=$dep->getLibelle()?></option>

                    <?php endforeach;  else: ?>
                        <p class="text-muted"> Please create department before </p>
                    <?php endif;?>
                </select>
                <div class="invalid-feedback">Please select the user department</div>
            </div>

            <div class="text-end mb-3">
                <button type="button" class="btn btn-sm btn-secondary cancelForm">Cancel</button>
                <button type="button" class="btn btn-sm btn-dark sendFormBtn" data-id="userForm_user_insert">create</button>
            </div>
        </form>

        <?php
    }


}