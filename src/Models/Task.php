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
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE CAST(due_date as date) = CAST(CURRENT_DATE AS DATE ) && task.isChecked is false && task.isArchived is false";
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
     * Active tasks in add Task Page
     * @return void
     */
    function viewAllTasksInAddTaskPage():void
    {
        $allTasks = self::allTasks();
        ?>

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
                    foreach ($allTasks as $activeList):
                    ?>
                        <tr data-id="viewAllTasksTable">
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
                                    <input type="checkbox" value="<?=$activeList->getIsChecked()?>" <?php echo ($activeList->getIsChecked()) ? 'checked="checked"' : ''?> name="usercheckbox" id="usercheckbox" data-id="<?=$activeList->getTaskId()?>">
                                    <label class="text-sm" for="usercheckbox">Responsible</label>
                                </span>
                                    </li>
                                    <li class="d-inline">
                                        <input type="checkbox" name="admincheckbox" id="admincheckbox"  class="admincheckbox" value="<?=$activeList->getIsCheckedByAdmin()?>" <?php echo ($activeList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$activeList->getTaskId()?>">
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
                                    $f = new DateTime($activeList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="white"></rect></svg>'.$f->format('d-m-Y H:i A');
                                }?>
                            </td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
                                "target":0,
                                "searchable":true
                            },
                            {
                                "target":1,
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
        // Prints something like: Wednesday 19th of October 2022 08:40:48 AM
        //echo $date->format('l jS \o\f F Y h:i A'), "\n";
        $f = $date->format('d F Y');
        echo "<h3 class='text-center fw-small'>$f</h3>";
        ?>
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
                ?>
                <tr data-id="viewTodayTasksTable">
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
                                    <input type="checkbox" value="<?=$activeList->getIsChecked()?>" <?php echo ($activeList->getIsChecked()) ? 'checked="checked"' : ''?> name="usercheckbox" id="usercheckbox" data-id="<?=$activeList->getTaskId()?>">
                                    <label class="text-sm" for="usercheckbox">Responsible</label>
                                </span>
                            </li>
                            <li class="d-inline">
                                <input type="checkbox" name="admincheckbox" id="admincheckbox"  class="admincheckbox" value="<?=$activeList->getIsCheckedByAdmin()?>" <?php echo ($activeList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$activeList->getTaskId()?>">
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
                            "target":0,
                            "searchable":true
                        },
                        {
                            "target":1,
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

    }

    /**
     * Future Tasks in Add Task Page
     * @return void
     */
    function viewFutureTasksInAddTaskPage():void
    {

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


}