<?php

namespace App\Models;

//use \AllowDynamicProperties;
//
//#[AllowDynamicProperties]
use DateTime;
use DateTimeImmutable;

class Task
{
    protected $task_id;
    protected $title;
    protected $todo;
    protected $due_date;
    protected $created_at;
    protected $isChecked;
    protected $isArchived;
    protected $isCheckedByAdmin;
    protected $userid;
    protected $file;

    //private Database $database;
    //public function __construct(){$this->database = new Database();}

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->task_id;
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
        return $this->due_date;
    }

    /**
     * @param mixed $due_date
     * @return Task
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     * @return Task
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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

    /**
     * All Tasks
     * @return array|false|mixed
     */
    public static function read(): mixed
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department";
        return StaticDb::getDB()->query($sql, get_called_class());
    }

    public static function allTasks():mixed
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE task.isArchived is false";
        return StaticDb::getDb()->query($sql, get_called_class());
    }

    /**
     * Future Tasks
     * Due_date >= CURRENT DATE
     * And CURRENT DATE +3 < Due date
     * @return mixed
     */
    public static function futureTasks():mixed
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE CAST(due_date as date) > CAST(CURRENT_DATE AS DATE ) && task.isChecked is false && task.isArchived is false";
        return StaticDb::getDb()->query($sql, get_called_class());
    }

    /**
     * @return mixed
     */
    public static function todayTasks():mixed
    {//task.isChecked is false && task.isArchived is false
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE CAST(due_date as date) = CAST(CURRENT_DATE AS DATE ) && isCheckedByAdmin = false";
        return StaticDb::getDb()->query($sql, get_called_class());
    }

    /**
     * InWaiting Tasks to Confirm By admin or return
     * @return mixed
     */
    public static function inWaiting():mixed
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE task.isChecked is true && task.isCheckedByAdmin is false";
        return StaticDb::getDb()->query($sql, get_called_class());
    }

    /**
     * Late On delivery
     * @return mixed
     */
    public static function lateOnDelivery():mixed
    {//DATE_ADD(CAST(CURRENT_DATE AS DATE ), INTERVAL 3 DAY ) >= due_date
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE CAST(due_date as date) < CAST(CURRENT_TIMESTAMP as DATE ) && task.isChecked is false && task.isArchived is false";
        return StaticDb::getDb()->query($sql, get_called_class());
    }

    /**
     * task.isArchived is true
     * Archived Tasks
     * @return mixed
     */
    public static function archived():mixed
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE isChecked is true && isCheckedByAdmin is true";
        return StaticDb::getDb()->query($sql, get_called_class());
    }

    /**
     * Tasks By user
     * @param $userid
     * @return mixed
     */
    public static function findByUserId($userid): mixed
    {
        $sql = "SELECT task.task_id, d.color, title, todo, due_date, created_at, isChecked, isArchived, isCheckedByAdmin, userid, file, u.fullname, d.libelle FROM task JOIN user u on u.user_id = task.userid JOIN department d on d.department_id = u.department WHERE userid = ? ";
        return StaticDb::getDB()->prepare($sql, [$userid], get_called_class());
    }

    /**
     * @param $departmentId
     * @return mixed
     */
    public static function findTaskByJoinDepartment($departmentId): mixed
    {
        //task_id, title, todo, due_date, created_at, isChecked, isArchived, task.userid, isCheckedByAdmin, file,, d.libelle, r.role_name, u.fullname, d.color
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE u.department = ?";
        return StaticDb::getDB()->prepare($sql, [$departmentId], get_called_class(), false);
    }


    /**
     * add Task Form
     * @return void
     */
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

    /**
     * Get active task in Task Page
     * @return void
     */
    function futureTaskInTaskPage():void
    {
        $tasksActive = self::futureTasks();
        $total = count($tasksActive);

        for ($i = 0; $i < $total; $i++):   ?>
         <div class="col-lg-4 p-1" style="border-right: gold 1px solid">

             <!-- Item -->
             <div class="col d-flex mb-1">
                 <span class="p-2 me-1" style="border: white 1px solid !important;"></span>

                 <div data-id="<?= $tasksActive[$i]->getTaskId()?>" class="form-inline col-lg col-md col p-1 border  border-success">

                     <!-- Box add by click -->
                     <div class="d-flex flex-wrap">
                         <button type="button" class="btn border-0 align-self-start" style="color: white !important;">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                 <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"></path>
                             </svg>
                         </button>

                         <div class="align-self-center justify-content-between">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFFFFF" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FF0000" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg style="background-color: #DA7843" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#DA7843" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#4FAD5B" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg style="background-color: #4FADEA" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#4FADEA" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg style="background-color: #FFFF55" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFFF55" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg style="background-color: #1431F5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1431F5" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg style="background-color: #68349A" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#68349A" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg style="background-color: #8E2966" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#8E2966" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AEAEAE" class="bi bi-square me-1" viewBox="0 0 16 16">
                                 <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                             </svg>
                         </div>

                     </div>
                     <!-- Task Name and date -->
                     <input type="radio" name="inputRadio" id="inputRadio" class="form-inline">
                     <label for="inputRadio"><?= $tasksActive[$i]->getTitle()?></label>
                     <p class="text-end" style="color: darkgray !important; font-size: smaller !important; font-style: italic !important;">due date: <?=$tasksActive[$i]->getDueDate()?> 00:00 PM</p>
                 </div>
             </div>
         </div>
     <?php endfor;
    }

    /**
     * Active tasks in ADD Task Page
     * @return void
     */
    function viewAllTasksInAddTaskPage():void
    {
        $allTasks = self::allTasks();
        ?>
            <div id="viewAllTasksTableDiv">
                <h4 class="text-center text-uppercase my-4 fw-small text-sm">All Tasks Table</h4>
                <table class="table table-condensed table-dark text-light text-capitalize viewAllTasksTable" id="viewAllTasksTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>task</th>
                        <th>department</th>
                        <th>due date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    foreach ($allTasks as $allList):
                        ?><!--viewAllTasksInAddTaskPage -->
                        <tr data-id="viewAllTasksInAddTaskPage" <?php echo ($allList->getIsChecked() && $allList->getIsCheckedByAdmin()) ? 'disabled="disabled"' : ''?>>
                            <td><?= $i++ .'<br>';
                                if ($allList->getFile()){
                                    $item = json_decode($allList->getFile(), true);
                                    foreach ($item as $file){?>
                                        <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                        <?php
                                    }
                                }
                                echo '<br>';
                                ?>
                                <button class="btn btn-sm btn-default border border-0 delItem" type="button" data-id="<?=$allList->getTaskId()?>" style="text-decoration: none !important; background-color: white !important;"><i class="fa fa-trash"></i> </button>
                            </td>
                            <td><?=$allList->getTaskId()?></td>
                            <td class="d-flex justify-content-between fs-6 fw-lighter">
                                <ul class="list-unstyled">
                                    <li class="nav-item">
                                        <?php $f = ($allList->getCreatedAt()) ? new DateTime($allList->getCreatedAt()) : date('Y-m-d H:i:s');
                                        echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                                title: '.$allList->getTitle() .
                                            '<br>To do: '. $allList->getTodo()
                                            .'<br>assigned To: "'.$allList->fullname.
                                            '<br>Created At: ' .$f->format('Y-m-d') .'"</p>';
                                        ?>
                                    </li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li>
                                        <span class="d-inline">
                                            <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$allList->getIsChecked()?>" <?php echo ($allList->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$allList->getTaskId().'_isChecked'?>">
                                            <label class="text-sm" for="usercheckbox">Responsible</label>
                                        </span>
                                    </li>
                                    <li class="d-inline">
                                        <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$allList->getIsCheckedByAdmin()?>" <?php echo ($allList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$allList->getTaskId().'_IsCheckedByAdmin'?>">
                                        <label for="admincheckbox" class="text-sm">Admin</label>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul class='list-unstyled text-center'>
                                    <li><?=$allList->libelle?></li>
                                    <li>
                                        <svg class="bd-placeholder-img me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$allList->color?>"></rect></svg>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <?php if ($allList->getDueDate()){
                                    $f = new DateTime($allList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="white"></rect></svg>'.$f->format('d-m-Y H:i A');
                                }?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <script type="text/javascript">
            $(document).ready(function(){

                $("#viewAllTasksTable").DataTable({
                        "RowId": 0,
                        "searching": true,
                        "paging":true,
                        "pageLength": 10,
                        "orderable":true,
                        "order": [[1, 'asc']],
                        "autoWidth": false,
                        "selected": true,
                        "columns":[
                            {"data":0},
                            {"data":1},
                            {"data":2},
                            {"data":3},
                            {"data":4}
                        ],
                        "columnDefs":[
                            {
                                "target":1,
                                "searchable":false,
                                "visible":false
                            }
                        ]
                    })

            })
        </script>

    <?php
    }

    /**
     * Today Tasks in Add Task Page
     * @return void
     */
    function viewTodayTasksInAddTaskPage():void
    { $todayTasks = self::todayTasks();
        $date = new DateTimeImmutable("now");
        $f = $date->format('d F Y');
        ?>
            <div id="viewTodayTasksTableDiv">
                <h4 class="text-center text-uppercase my-4 fw-small text-sm">Today Tasks Table ( <?= $f?> )</h4>
                <table class="table table-condensed table-dark text-light text-capitalize viewTodayTasksTable" id="viewTodayTasksTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>task</th>
                        <th>department</th>
                        <th>due date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    foreach ($todayTasks as $activeList):
                        ?><!-- viewTodayTasksTable-->
                        <tr data-id="viewTodayTasksInAddTaskPage">
                            <td><?= $i++ .'<br>';
                                if ($activeList->getFile()){
                                    $item = json_decode($activeList->getFile(), true);
                                    foreach ($item as $file){?>
                                        <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                        <?php
                                    }
                                }
                                echo '<br>';
                                ?>
                                <button class="btn btn-sm btn-default border border-0 delItem" type="button" data-id="<?=$activeList->getTaskId()?>" style="text-decoration: none !important; background-color: white !important;"><i class="fa fa-trash"></i> </button>
                            </td>
                            <td><?=$activeList->getTaskId()?></td>
                            <td class="d-flex justify-content-between fs-6 fw-lighter">
                                <ul class="list-unstyled">
                                    <li class="nav-item">
                                        <?php $f = ($activeList->getCreatedAt()) ? new DateTime($activeList->getCreatedAt()) : date('Y-m-d H:i:s');
                                        echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                title: '.$activeList->getTitle() .
                                            '<br>To do: '. $activeList->getTodo()
                                            .'<br>assigned To: "'.$activeList->fullname.
                                            '<br>Created At: ' .$f->format('Y-m-d') .'"</p>';
                                        ?>
                                    </li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li>
                                        <span class="d-inline">
                                            <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$activeList->getIsChecked()?>" <?php echo ($activeList->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$activeList->getTaskId().'_isChecked'?>">
                                            <label class="text-sm" for="usercheckbox">Responsible</label>
                                        </span>
                                    </li>
                                    <li class="d-inline">
                                        <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$activeList->getIsCheckedByAdmin()?>" <?php echo ($activeList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$activeList->getTaskId().'_IsCheckedByAdmin'?>">
                                        <label for="admincheckbox" class="text-sm">Admin</label>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul class='list-unstyled text-center'>
                                    <li><?=$activeList->libelle?></li>
                                    <li>
                                        <svg class="bd-placeholder-img me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$activeList->color?>"></rect></svg>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <?php if ($activeList->getDueDate()){
                                    $f = new DateTime($activeList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="orange"></rect></svg>'.$f->format('d-m-Y H:i A');
                                }?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#viewTodayTasksTable').DataTable({
                        "RowId": 0,
                        "searching": true,
                        "paging":true,
                        "pageLength": 10,
                        "orderable":true,
                        "order": [[1, 'asc']],
                        "autoWidth": false,
                        "selected": true,
                        "columns":[
                            {"data":0},
                            {"data":1},
                            {"data":2},
                            {"data":3},
                            {"data":4}
                        ],
                        "columnDefs":[
                            {
                                "target":1,
                                "searchable":false,
                                "visible":false
                            }
                        ]
                    })
                })
            </script>

        <?php
    }

    /**
     * Late Task in Add Task Page
     * @return void
     */
    function viewLateTasksInAddTaskPage():void
    {
        $lateTasks = self::lateOnDelivery();
        ?>
            <div class="viewLateTasksTableDiv">
                <h3 class="text-center text-uppercase my-4 fw-small text-sm">Late Tasks Table</h3>
                    <table class="table table-condensed table-dark text-light text-capitalize viewLateTasksTable" id="viewLateTasksTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>id</th>
                            <th>task</th>
                            <th>department</th>
                            <th>due date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        foreach ($lateTasks as $lateList):
                            ?><!--viewLateTasksTable-->
                            <tr data-id="viewLateTasksInAddTaskPage">
                                <td><?= $i++ .'<br>';
                                    if ($lateList->getFile()){
                                        $item = json_decode($lateList->getFile(), true);
                                        foreach ($item as $file){?>
                                            <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                            <?php
                                        }
                                    }
                                    echo '<br>';
                                    ?>
                                    <button class="btn btn-sm btn-default border border-0 delItem" type="button" data-id="<?=$lateList->getTaskId()?>" style="text-decoration: none !important; background-color: white !important;"><i class="fa fa-trash"></i> </button>
                                </td>
                                <td><?=$lateList->getTaskId()?></td>
                                <td class="d-flex justify-content-between fs-6 fw-lighter">
                                    <ul class="list-unstyled">
                                        <li class="nav-item">
                                            <?php $f = ($lateList->getCreatedAt()) ? new DateTime($lateList->getCreatedAt()) : date('Y-m-d H:i:s');
                                            echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                title: '.$lateList->getTitle() .
                                                '<br>To do: '. $lateList->getTodo()
                                                .'<br>assigned To: "'.$lateList->fullname.
                                                '<br>Created At: ' .$f->format('Y-m-d') .'"</p>';
                                            ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li>
                                <span class="d-inline">
                                    <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$lateList->getIsChecked()?>" <?php echo ($lateList->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$lateList->getTaskId().'_isChecked'?>">
                                    <label class="text-sm" for="usercheckbox">Responsible</label>
                                </span>
                                        </li>
                                        <li class="d-inline">
                                            <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$lateList->getIsCheckedByAdmin()?>" <?php echo ($lateList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$lateList->getTaskId().'_IsCheckedByAdmin'?>">
                                            <label for="admincheckbox" class="text-sm">Admin</label>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class='list-unstyled text-center'>
                                        <li><?=$lateList->libelle?></li>
                                        <li>
                                            <svg class="bd-placeholder-img me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$lateList->color?>"></rect></svg>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <?php if ($lateList->getDueDate()){
                                        $f = new DateTime($lateList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="red"></rect></svg>'.$f->format('d-m-Y H:i A');
                                    }?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

            </div>
            <script type="text/javascript">
            $('#viewLateTasksTable').DataTable({
                "RowId": 0,
                "searching": true,
                "paging":true,
                "pageLength": 10,
                "orderable":true,
                "order": [[1, 'asc']],
                "autoWidth": false,
                "selected": true,
                "columns":[
                    {"data":0},
                    {"data":1},
                    {"data":2},
                    {"data":3},
                    {"data":4}
                ],
                "columnDefs":[
                    {
                        "target":1,
                        "searchable":false,
                        "visible":false
                    }
                ]
            })
        </script>
        <?php
    }

    /**
     * Future Tasks in Add Task Page
     * @return void
     */
    function viewFutureTasksInAddTaskPage():void
    {
        $futureTasks = self::futureTasks();
        ?>
            <div class="viewFutureTasksTableDiv">
            <h4 class="text-center text-uppercase my-4 fw-small text-sm">Future Tasks Table</h4>
            <table class="table table-condensed table-dark text-light text-capitalize viewFutureTasksTable" id="viewFutureTasksTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>id</th>
                    <th>task</th>
                    <th>department</th>
                    <th>due date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($futureTasks as $futureList):
                    ?><!--viewFutureTasksTable -->
                    <tr data-id="viewFutureTasksInAddTaskPage">
                        <td><?= $i++ .'<br>';
                            if ($futureList->getFile()){
                                $item = json_decode($futureList->getFile(), true);
                                foreach ($item as $file){?>
                                    <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                    <?php
                                }
                            }
                            echo '<br>';
                            ?>
                            <button class="btn btn-sm btn-default border border-0 delItem" type="button" data-id="<?=$futureList->getTaskId()?>" style="text-decoration: none !important; background-color: white !important;"><i class="fa fa-trash"></i> </button>
                        </td>
                        <td><?=$futureList->getTaskId()?></td>
                        <td class="d-flex justify-content-between fs-6 fw-lighter">
                            <ul class="list-unstyled">
                                <li class="nav-item">
                                    <?php $f = ($futureList->getCreatedAt()) ? new DateTime($futureList->getCreatedAt()) : date('Y-m-d H:i:s');
                                    echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                title: '.$futureList->getTitle() .
                                        '<br>To do: '. $futureList->getTodo()
                                        .'<br>assigned To: "'.$futureList->fullname.
                                        '<br>Created At: ' .$f->format('Y-m-d') .'"</p>';
                                    ?>
                                </li>
                            </ul>
                            <ul class="list-unstyled">
                                <li>
                                <span class="d-inline">
                                    <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$futureList->getIsChecked()?>" <?php echo ($futureList->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$futureList->getTaskId().'_isChecked'?>">
                                    <label class="text-sm" for="usercheckbox">Responsible</label>
                                </span>
                                </li>
                                <li class="d-inline">
                                    <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$futureList->getIsCheckedByAdmin()?>" <?php echo ($futureList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$futureList->getTaskId().'_IsCheckedByAdmin'?>">
                                    <label for="admincheckbox" class="text-sm">Admin</label>
                                </li>
                            </ul>
                        </td>
                        <td>
                            <ul class='list-unstyled text-center'>
                                <li><?=$futureList->libelle?></li>
                                <li>
                                    <svg class="bd-placeholder-img me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$futureList->color?>"></rect></svg>
                                </li>
                            </ul>
                        </td>
                        <td>
                            <?php if ($futureList->getDueDate()){
                                $f = new DateTime($futureList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="green"></rect></svg>'.$f->format('d-m-Y H:i A');
                            }?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
            <script type="text/javascript">
            $('#viewFutureTasksTable').DataTable({
                "RowId": 0,
                "searching": true,
                "paging":true,
                "pageLength": 10,
                "orderable":true,
                "order": [[1, 'asc']],
                "autoWidth": false,
                "selected": true,
                "columns":[
                    {"data":0},
                    {"data":1},
                    {"data":2},
                    {"data":3},
                    {"data":4}
                ],
                "columnDefs":[
                    {
                        "target":1,
                        "searchable":false,
                        "visible":false
                    }
                ]
            })
        </script>
        <?php
    }



}