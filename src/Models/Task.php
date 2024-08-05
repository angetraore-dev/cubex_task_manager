<?php

namespace App\Models;

use PDO;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Task
{
    protected $taskId;
    protected $title;
    protected $todo;
    protected $dueDate;
    protected $createdAt;
    protected $isChecked;
    protected $isArchived;
    protected $isCheckedByAdmin;
    protected $userid;
    protected $file;

    private Database $database;

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTodo()
    {
        return $this->todo;
    }

    /**
     * @param mixed $todo
     * @return Task
     */
    public function setTodo($todo)
    {
        $this->todo = $todo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param mixed $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Task
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsChecked()
    {
        return $this->isChecked;
    }

    /**
     * @param mixed $isChecked
     * @return Task
     */
    public function setIsChecked($isChecked)
    {
        $this->isChecked = $isChecked;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsArchived()
    {
        return $this->isArchived;
    }

    /**
     * @param mixed $isArchived
     * @return Task
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsCheckedByAdmin()
    {
        return $this->isCheckedByAdmin;
    }

    /**
     * @param mixed $isCheckedByAdmin
     * @return Task
     */
    public function setIsCheckedByAdmin($isCheckedByAdmin)
    {
        $this->isCheckedByAdmin = $isCheckedByAdmin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     * @return Task
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return Task
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @return array|false|mixed
     */
    public static function read(): mixed
    {
        return StaticDb::getDB()->query("SELECT * FROM task", get_called_class());
    }

    /**
     * @param $userid
     * @return mixed
     */
    public static function findByUserId($userid): mixed
    {
        $sql = "SELECT task_id, d.color, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.user_id, u.fullname, u.roleid, u.department, d.department_id, d.libelle, d.color FROM task JOIN user u on u.user_id = task.userid JOIN role r on r.role_id = u.roleid JOIN department d on d.department_id = u.department WHERE userid = ? ";
        return StaticDb::getDB()->prepare($sql, [$userid], get_called_class());
    }

    /**
     * @param $departmentId
     * @return mixed
     */
    public static function findTaskByJoinDepartment($departmentId): mixed
    {
        $sql =
            "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, task.userid, isCheckedByAdmin, file, d.libelle, r.role_name, u.fullname 
            FROM task JOIN user u on u.user_id = task.userid JOIN role r on r.role_id = u.roleid JOIN department d on d.department_id = u.department WHERE u.department = ?";
        return StaticDb::getDB()->prepare($sql, [$departmentId], __CLASS__, false);
    }

    /**
     * @param array $field
     * @return bool
     */
    public function create(array $field): bool
    {
        $implodeColumns = implode(', ', array_keys($field));
        $implodePlaceholders = implode(', :', array_keys($field));
        $request = "INSERT INTO task($implodeColumns) VALUES (:". $implodePlaceholders .")";

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
    public function edit(int $identifier, array $field): bool
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
        $stmt .="UPDATE task SET " .$st;
        $stmt .=" WHERE task_id = " .$identifier;
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
        $stmt = "DELETE FROM task WHERE task_id = :task_id";
        $request = $this->database->dbConnect()->prepare($stmt);
        $request->bindValue(':task_id', $identifier, PDO::PARAM_INT);
        if ($request->execute()){
            return true;
        }
        return false;
    }

    function taskForm():void
    {?>
        <form class="row g-3 my-4 needs-validation taskForm" id="taskForm" enctype="multipart/form-data" novalidate>
            <fieldset class="border border-2 fw-bold text-center text-uppercase">
                <legend  class="float-none w-auto my-3">add task Form</legend>
            </fieldset>
            <div class="col-md-4 mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                    <div class="invalid-feedback">Please fill it</div>
                </div>
            <div class="col-md-4 mb-3">
                    <label for="todo" class="form-label">Task To do</label>
                    <textarea rows="3" name="todo" id="todo" class="form-control" required></textarea>
                    <div class="invalid-feedback">Write what to do</div>
                </div>
            <div class="col-md-4 mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="datetime-local" name="due_date" id="due_date" class="form-control" required>
                    <div class="invalid-feedback"> Select a valid date</div>
                </div>

            <div class="col-md-6 mb-3">
                    <label for="userid" class="form-label">Assign</label>
                    <select class="form-select" name="userid" id="userid" required>
                        <option value="" class="form-control">Choose the responsible</option>

                    <?php $usersList = User::read(); if($usersList) : foreach ($usersList as $user): ?>
                    <option class="form-control" value="<?=$user->getUserId()?>"><?=$user->getFullname()?></option>
                    <?php endforeach; else: echo "<p class='text-center text-muted'>No user Records found !</p>";?>
                    <?php endif;?>

                    </select>
                    <div class="invalid-feedback">Please assign task to a user</div>
                </div>
            <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">File</label>
                    <input type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" name="file[]" id="file" class="form-control" multiple="multiple">
                </div>
            <div class="text-end mb-3">
                    <button type="button" class="btn btn-sm btn-secondary closeTaskFormBtn">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary sendTaskFormBtn">create</button>
                </div>
        </form>
    <?php
    }


}