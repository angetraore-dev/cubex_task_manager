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

    public static function countDistinctUserTaskByJoinDepartment($departmentId):mixed
    {
        $sql = "SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department WHERE u.department = ? GROUP BY u.fullname";
        return StaticDb::getDB()->prepare($sql, [$departmentId], get_called_class(), false);
    }


    /*
     * add Task Form
     * @return void
     */
    function addTaskForm():void
    {?>
        <form class="row col-md-8 mx-auto bg-body-tertiary text-dark rounded rounded-2 opacity-80 g-3 my-4 needs-validation taskForm" id="taskForm" enctype="multipart/form-data" novalidate>
            <h3 class="my-3 fw-small fs-6 bg-dark text-white rounded rounded-2 text-center text-uppercase p-1 border border-1">add task Form</h3>

            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control bg-body-tertiary text-dark" required>
                <div class="invalid-feedback">Please fill it</div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="todo" class="form-label">Task To do</label>
                <textarea rows="3" name="todo" id="todo" class="form-control" style="border: gold 1px solid;" required></textarea>
                <div class="invalid-feedback">Write what to do</div>
            </div>
            <div class="col-md-5 mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="datetime-local" name="due_date" id="due_date" class="form-control bg-body-tertiary date text-dark" required>
                <div class="invalid-feedback"> Select a valid date</div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="depart" class="form-label">Department</label>
                <select class="form-select" style="border: gold 1px solid;" name="depart" id="depart" required>
                    <option class="form-control" value="">Choose a department </option>
                    <?php $depList = Department::readAll(); if($depList) : foreach ($depList as $item): ?>
                        <option class="form-control p-1" value="<?=$item->getDepartmentId()?>">
                            <?=$item->getLibelle() . '<span class="badge p-1" style="background-color:'.$item->getColor().' !important;"></span>';?>
                        </option>
                    <?php endforeach; else: echo "<p class='text-center text-muted'>No department Records found !</p>";?>
                    <?php endif;?>

                </select>
                <div class="invalid-feedback">Please select a department to view the responsible list</div>
            </div>

            <div class="col-md-3 mb-3 d-none" id="responsibleChoice">

            </div>
            <div class="col-md-12 mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" name="file[]" id="file" class="form-control bg-body-tertiary text-dark" multiple="multiple">
            </div>
            <div class="text-end mb-3">
                <button type="button" class="btn btn-sm btn-secondary cancelForm">Cancel</button>
                <button type="button" class="btn btn-sm btn-dark sendFormBtn" data-id="taskForm_task_insert">create</button>
            </div>
        </form>

        <script type="text/javascript">

            $('#depart').on('change', function(){
                let departmentId = $(this).val();
                $.post({
                    url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                    data:{selectOpt:departmentId},
                    success:function (response){
                        $('#responsibleChoice').removeClass('d-none').html(response).fadeIn()
                    }
                })
            })
        </script>
        <?php
    }

    /*
     * Active tasks in ADD Task Page
     * @return void
     */
    function viewAllTasksInAddTaskPage():void
    {
        $allTasks = self::allTasks();
        if ($allTasks):
            ?>
            <div id="viewAllTasksTableDiv">
                <h4 class="text-center text-uppercase my-4 fw-small text-sm">All Tasks Table</h4>
                <table class="table table-condensed table-dark text-light text-capitalize viewAllTasksTable" id="viewAllTasksTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    foreach ($allTasks as $allList):
                    if ($allList->getIsChecked() && $allList->getIsCheckedByAdmin()):
                    ?><!--viewAllTasksInAddTaskPage -->
                    <tr data-id="viewAllTasksInAddTaskPage" class="disabled">
                        <td class="test-start text-sm">
                            <?php
                            echo $i++ .'<br>';
                            if ($allList->getFile()){
                                $item = json_decode($allList->getFile(), true);
                                foreach ($item as $file){?>
                                    <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                    <?php
                                }
                            }
                            ?>
                            <button class="border border-0 delItem" type="button" data-id="<?=$allList->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                </svg>
                            </button>
                        </td>
                        <td><?=$allList->getTaskId()?></td>
                        <td class="text-start text-sm">
                            <h6 class="">Task</h6>
                            <div class="row">
                                <ul class="list-unstyled col-md-8">
                                    <li class="nav-item">
                                        <?php $f = ($allList->getCreatedAt()) ? new DateTime($allList->getCreatedAt()) : date('Y-m-d H:i:s');
                                        echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                      '.$allList->getTitle().'<br>'. $allList->getTodo().'
                                      <br> assigned To: "'.$allList->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                        ?>
                                    </li>
                                </ul>
                                <ul class="list-unstyled col-md-4">
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
                            </div>
                        </td>
                        <td class="text-center text-sm">
                            <h6>Department</h6><br>
                            <?='<span class="p-1" style="background-color: '.$allList->color.'!important;">' .$allList->libelle.'</span><br><i class="fa fa-caret-down align-self-center"></i>'?>
                        </td>
                        <td class="text-center text-sm">
                            <h6>Due Date</h6><br>
                            <?php
                            $f = new DateTime($allList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="white"></rect></svg>'
                                .$f->format('d-m-Y H:i A');
                            ?>
                        </td>
                    </tr>

                    <?php else:?>
                        <tr data-id="viewAllTasksInAddTaskPage">
                            <td class="test-start text-sm">
                                <?php
                                echo $i++ .'<br>';
                                if ($allList->getFile()){
                                    $item = json_decode($allList->getFile(), true);
                                    foreach ($item as $file){?>
                                        <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                        <?php
                                    }
                                }
                                ?>
                                <button class="border border-0 delItem" type="button" data-id="<?=$allList->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg>
                                </button>
                            </td>
                            <td><?=$allList->getTaskId()?></td>
                            <td class="text-start text-sm">
                                <h6>Task</h6><br>
                                <div class="row">
                                    <ul class="list-unstyled col-md-8">
                                        <li class="nav-item">
                                            <?php $f = ($allList->getCreatedAt()) ? new DateTime($allList->getCreatedAt()) : date('Y-m-d H:i:s');
                                            echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                      '.$allList->getTitle().'<br>'. $allList->getTodo().'
                                      <br> assigned To: "'.$allList->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                            ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled col-md-4">
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
                                </div>
                            </td>
                            <td class="text-center text-sm">
                                <h6>Department</h6><br>
                                <?='<span class="p-1" style="background-color: '.$allList->color.'!important;">' .$allList->libelle.'</span><br><i class="fa fa-caret-down align-self-center"></i>'?>
                            </td>
                            <td class="text-center text-sm">
                                <h6>Due Date</h6><br>
                                <?php
                                $f = new DateTime($allList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="white"></rect></svg>'
                                    .$f->format('d-m-Y H:i A');
                                ?>
                            </td>
                        </tr>

                    <?php endif; endforeach; ?>
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

        <?php else: echo '<h6 class="text-center text-sm">No records Found</h6>'; endif;
    }

    /*
     * Get active task in Task Page
     * @return void
     */
    function futureTaskInTaskPage():void
    {
        $tasksActive = self::lateOnDelivery();
        $total = count($tasksActive);
        if ($tasksActive) :
        for ($i = 0; $i < $total; $i++):   ?>
         <div class="col-lg-4 p-1" style="border-right: gold 1px solid">
             <!-- Item -->
             <div class="col d-flex mb-1">

                 <span class="p-2 me-1" style="border: white 1px solid !important; background-color: <?php echo ($tasksActive[$i]->getIsChecked()) ? 'white !important': '' ?>"></span>

                 <div data-id="<?= $tasksActive[$i]->getTaskId()?>" class="form-inline col-lg col-md col p-1" style="border: <?=$tasksActive[$i]->color?> 1px solid">

                     <!-- Box add by click -->
                     <?php Department::buttonAddDepartment($tasksActive[$i]);?>
                     <!-- End box add department by click -->
                     <!-- Task Name and date -->
                     <input type="radio" name="inputRadio" id="inputRadio" class="form-inline" disabled>
                     <label for="inputRadio"><?= $tasksActive[$i]->getTitle()?></label>
                     <p class="text-end" style="color: darkgray !important; font-size: smaller !important; font-style: italic !important;">due date: <?=$tasksActive[$i]->getDueDate()?> 00:00 PM</p>
                 </div>
             </div>
         </div>
     <?php endfor; else: echo '<div class="row my-4"><p class="text-center">No future tasks found</p></div>'; endif;
    }


    /**
     * @return void
     * @throws \Exception
     * Late Task
     */
    function viewLateTasksInAddTaskPage():void
    {
        $lateTasks = self::lateOnDelivery();
        if ($lateTasks):
        ?>
            <div class="viewLateTasksTableDiv">
                <h3 class="text-center text-uppercase my-4 fw-small text-sm">Late Tasks Table</h3>
                    <table class="table table-condensed table-dark text-light text-capitalize viewLateTasksTable" id="viewLateTasksTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($lateTasks as $lateList):?>
                            <tr data-id="viewLateTasksInAddTaskPage">
                                <td class="text-start text-sm">
                                    <?= $i++ .'<br>';
                                    if ($lateList->getFile()){
                                        $item = json_decode($lateList->getFile(), true);
                                        foreach ($item as $file){?>
                                            <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <button class="border border-0 delItem" type="button" data-id="<?=$lateList->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                        </svg>
                                    </button>
                                </td>
                                <td><?=$lateList->getTaskId()?></td>
                                <td class="text-start text-sm">
                                    <h6>Task</h6>
                                    <div class="row">
                                        <ul class="list-unstyled col-md-8">
                                            <li class="nav-item">
                                                <?php $f = ($lateList->getCreatedAt()) ? new DateTime($lateList->getCreatedAt()) : date('Y-m-d H:i:s');
                                                echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                          '.$lateList->getTitle().'<br>'. $lateList->getTodo().'
                                          <br> assigned To: "'.$lateList->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                                ?>
                                            </li>
                                        </ul>
                                        <ul class="list-unstyled col-md-4">
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
                                    </div>
                                </td>
                                <td class="text-center text-sm">
                                    <h6>Department</h6>
                                    <?php Department::buttonAddDepartment($lateList);?>
                                    <?='<span class="p-1" style="background-color: '.$lateList->color.'!important;">' .$lateList->libelle.'</span><br><i class="fa fa-caret-down align-self-center"></i>'?>
                                </td>
                                <td class="text-center text-sm">
                                    <h6>Date & Hour</h6>
                                    <?php
                                        $f = new DateTime($lateList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="red"></rect></svg>'.$f->format('d-m-Y H:i A');
                                    ?>
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
        <?php else: echo "<h6>No records found </h6>"; endif;
    }

    /**
     * @return void
     * @throws \Exception
     * Today Tasks in Add Task Page
     */
    function viewTodayTasksInAddTaskPage():void
    {
        $todayTasks = self::todayTasks();
        $date = new DateTimeImmutable("now");
        $f = $date->format('d F Y');
        if ($todayTasks):
        ?>
        <div id="viewTodayTasksTableDiv">
            <h4 class="text-center text-uppercase my-4 fw-small text-sm">Today Tasks Table ( <?= $f?> )</h4>
            <table class="table table-condensed table-dark text-light text-capitalize viewTodayTasksTable" id="viewTodayTasksTable">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach ($todayTasks as $activeList): ?>
                <tr data-id="viewTodayTasksInAddTaskPage">
                    <td>
                        <?php
                        echo $i++ .'<br>';
                        if ($activeList->getFile()){
                            $item = json_decode($activeList->getFile(), true);
                            foreach ($item as $file){?>
                                <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                <?php
                            }
                        }
                        ?>
                        <button class="border border-0 delItem" type="button" data-id="<?=$activeList->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                            </svg>
                        </button>
                    </td>
                    <td><?=$activeList->getTaskId()?></td>
                    <td class="text-start text-sm">
                        <h6>Task</h6>
                        <div class="row">
                            <ul class="list-unstyled col-md-8">
                                <li class="nav-item">
                                    <?php $f = ($activeList->getCreatedAt()) ? new DateTime($activeList->getCreatedAt()) : date('Y-m-d H:i:s');
                                    echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                          '.$activeList->getTitle().'<br>'. $activeList->getTodo().'
                                          <br> assigned To: "'.$activeList->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                    ?>
                                </li>
                            </ul>
                            <ul class="list-unstyled col-md-4">
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
                        </div>
                    </td>
                    <td class="text-center text-sm">
                        <h6>Department</h6>
                        <?php Department::buttonAddDepartment($activeList);?>
                        <?='<span class="p-1" style="background-color: '.$activeList->color.'!important;">' .$activeList->libelle.'</span><br><i class="fa fa-caret-down align-self-center"></i>'?>
                    </td>
                    <td class="text-center text-sm">
                        <h6>Date & Hour</h6><br>
                        <?php $f = new DateTime($activeList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="orange"></rect></svg>'.$f->format('d-m-Y H:i A'); ?>
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

        <?php else: echo "<h6>No records found</h6>"; endif;
    }

    /**
     * @return void
     * @throws \Exception
     * Future Tasks in Add Task Page
     */
    function viewFutureTasksInAddTaskPage():void
    {
        $futureTasks = self::futureTasks();
        if ($futureTasks):
        ?>
            <div class="viewFutureTasksTableDiv">
            <h4 class="text-center text-uppercase my-4 fw-small text-sm">Future Tasks Table</h4>
            <table class="table table-condensed table-dark text-light text-capitalize viewFutureTasksTable" id="viewFutureTasksTable">
                <thead>
                    <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($futureTasks as $futureList): ?>
                        <tr data-id="viewFutureTasksInAddTaskPage">
                            <td class="text-start text-sm">
                                <?php
                                    echo $i++ .'<br>';
                                    if ($futureList->getFile()){
                                        $item = json_decode($futureList->getFile(), true);
                                        foreach ($item as $file){?>
                                            <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                            <?php
                                        }
                                    }
                                ?>
                                <button class="border border-0 delItem" type="button" data-id="<?=$futureList->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg>
                                </button>
                            </td>
                            <td><?=$futureList->getTaskId()?></td>
                            <td class="text-start text-sm">
                                <h6>Task</h6><br>
                                <div class="row">
                                    <ul class="list-unstyled col-md-8">
                                        <li class="nav-item">
                                            <?php $f = ($futureList->getCreatedAt()) ? new DateTime($futureList->getCreatedAt()) : date('Y-m-d H:i:s');
                                            echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                          '.$futureList->getTitle().'<br>'. $futureList->getTodo().'
                                          <br> assigned To: "'.$futureList->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                            ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled col-md-4">
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
                                </div>

                            </td>
                            <td class="text-center text-sm">
                                <h6>Department</h6>
                                <?php Department::buttonAddDepartment($futureList);?>
                                <?='<span class="p-1" style="background-color: '.$futureList->color.'!important;">' .$futureList->libelle.'</span><br><i class="fa fa-caret-down align-self-center"></i>'?>
                            </td>

                            <td class="text-center text-sm">
                                <h6>Date & Hour</h6><br>
                                <?php
                                    $f = new DateTime($futureList->getDueDate());
                                    echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="green"></rect></svg>'.$f->format('d-m-Y H:i A');
                                ?>
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
        <?php else: echo "<h6 class='text-center text-sm'>No records Found</h6>"; endif;
    }

    /**
     * @return void
     * @throws \Exception
     */
    function viewInWaitingTasksInAddTaskPage():void
    {
        $inWaitingTasks = self::inWaiting();
        if ($inWaitingTasks):
            ?>
            <div id="viewInWaitingTasksTableDiv">
                <h4 class="text-center text-uppercase my-4 fw-small text-sm">Tasks Waiting to approval Table</h4>
                <table class="table table-condensed table-dark text-light text-capitalize viewInWaitingTasksTable" id="viewInWaitingTasksTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($inWaitingTasks as $inWaitingList): ?>
                        <tr data-id="viewInWaitingTasksInAddTaskPage">

                            <td class="text-sm text-start">
                                <?php
                                echo $i++ .'<br>';
                                if ($inWaitingList->getFile()){
                                    $item = json_decode($inWaitingList->getFile(), true);
                                    foreach ($item as $file){?>
                                        <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                        <?php
                                    }
                                }
                                ?>
                                <button class="border border-0 delItem" type="button" data-id="<?=$inWaitingList->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg>
                                </button>
                            </td>
                            <td><?=$inWaitingList->getTaskId()?></td>
                            <td class="text-sm text-start">
                                <h6 class="">Task</h6>
                                <div class="row">
                                    <ul class="list-unstyled col-md-8">
                                        <li class="nav-item">
                                            <?php $f = ($inWaitingList->getCreatedAt()) ? new DateTime($inWaitingList->getCreatedAt()) : date('Y-m-d H:i:s');
                                            echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                      '.$inWaitingList->getTitle().'<br>'. $inWaitingList->getTodo().'
                                      <br> assigned To: "'.$inWaitingList->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                            ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled col-md-4">
                                        <li>
                                <span class="d-inline">
                                            <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$inWaitingList->getIsChecked()?>" <?php echo ($inWaitingList->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$inWaitingList->getTaskId().'_isChecked'?>">
                                            <label class="text-sm" for="usercheckbox">Responsible</label>
                                        </span>
                                        </li>
                                        <li class="d-inline">
                                            <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$inWaitingList->getIsCheckedByAdmin()?>" <?php echo ($inWaitingList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$inWaitingList->getTaskId().'_IsCheckedByAdmin'?>">
                                            <label for="admincheckbox" class="text-sm">Admin</label>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center text-sm">
                                <h6 class=''>Department</h6>
                                <?php Department::buttonAddDepartment($inWaitingList);?>
                                <?='<span class="p-1" style="background-color: '.$inWaitingList->color.'!important;">' .$inWaitingList->libelle.'</span><br><i class="fa fa-caret-down align-self-center"></i>'?>
                            </td>
                            <td class="text-center text-sm">
                                <h6>Date & Hour</h6><br>
                                <?php
                                $f = new DateTime($inWaitingList->getDueDate());
                                echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="white"></rect></svg>'
                                    .$f->format('d-m-Y H:i A');
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){

                    $("#viewInWaitingTasksTable").DataTable({
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

        <?php else: echo "<h6 class='text-center text-sm'>No records Found</h6>"; endif;
    }


    /**
     * Departments List in Department Dropdown Filter
     * @param $departmentId
     * @return void
     * @throws \Exception
     */
    function departmentTasksListInDropdownFilter($departmentId):void
    {
        $uList = self::countDistinctUserTaskByJoinDepartment($departmentId);
        $departmentTasks = self::findTaskByJoinDepartment($departmentId);
        if ($departmentTasks) :
    ?>
        <div id="DepartmentTasksTableDiv">
            <table class="table table-condensed table-dark text-light text-capitalize caption-top DepartmentTasksTable" id="DepartmentTasksTable">
                <caption class="my-3 text-center p-2" style="border: 1px solid <?=$departmentTasks[0]->color?>; background-color: <?=$departmentTasks[0]->color?>">
                    <h3 class="d-inline text-sm fw-small text-white">
                        <?=$departmentTasks[0]->libelle . ' Department Tasks ' ?>
                    </h3>
                </caption>
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($uList as $taskdepartment): ?>
                        <tr id="<?=$taskdepartment->getUserId()?>" data-id="departmentTasksListInDropdownFilter_<?=$taskdepartment->department_id?>">
                            <td><?= $i++?></td>
                            <td class="text-center text-sm">
                                <h6>Responsible</h6>
                                <?= $taskdepartment->fullname?>
                            </td>
                            <td>
                                <table id="smallTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $y =1; foreach($departmentTasks as $taskItem) :
                                            if ( $taskItem->getUserId() == $taskdepartment->getUserId() ) :
                                        ?>
                                            <tr id="<?=$taskItem->getTaskId()?>" data-id="departmentTasksListInDropdownFilter_<?=$taskItem->department_id?>">
                                                <td>
                                                    <?php
                                                        echo $y++ .'<br>';
                                                        if ($taskItem->getFile()){
                                                            $item = json_decode($taskItem->getFile(), true);
                                                            foreach ($item as $file){?>
                                                                <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                    <button class="border border-0 delItem" type="button" data-id="<?=$taskItem->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                                <td class="text-start text-sm">
                                                    <h6>Task</h6>
                                                    <div class="row">
                                                        <ul class="list-unstyled col-md-8">
                                                            <li class="nav-item">
                                                                <?php $f = ($taskItem->getCreatedAt()) ? new DateTime($taskItem->getCreatedAt()) : date('Y-m-d H:i:s');
                                                                echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                                                  '.$taskItem->getTitle().'<br>'. $taskItem->getTodo().'
                                                                  <br> assigned To: "'.$taskItem->fullname.'"<br>Created At: ' .$f->format('Y-m-d') .'</p>';
                                                                ?>
                                                            </li>
                                                        </ul>
                                                        <ul class="list-unstyled col-md-4">
                                                            <li>
                                                                <span class="d-inline">
                                                                    <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$taskItem->getIsChecked()?>" <?php echo ($taskItem->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$taskItem->getTaskId().'_isChecked'?>">
                                                                    <label class="text-sm" for="usercheckbox">Responsible</label>
                                                                </span>
                                                            </li>
                                                            <li class="d-inline">
                                                                <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$taskItem->getIsCheckedByAdmin()?>" <?php echo ($taskItem->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$taskItem->getTaskId().'_IsCheckedByAdmin'?>">
                                                                <label for="admincheckbox" class="text-sm">Admin</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; endforeach;?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <script type="text/javascript">

            $('#DepartmentTasksTable').DataTable({
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
                    {"data":2}
                ]
            })

            $(document).ready(() => {
                'use-strict'

                const smallTables = document.querySelectorAll("#smallTable")
                Array.from(smallTables).forEach(smallTable => {
                    let  opts = {
                        "RowId": 0,
                        "searching": true,
                        "paging":true,
                        "pageLength": 2,
                        "orderable":true,
                        "order": [[0, 'asc']],
                        "autoWidth": false,
                        "selected": true,
                        "columns":[
                            {"data":0},
                            {"data":1}
                        ]
                    }
                    new DataTable(smallTable, opts);
                })
            })

        </script>

    <?php
        else: echo "<p class='text-center'>No tasks records found for this Department</p>";
        endif;
    }

    /**
     * @param $userId
     * @return void
     * @throws \Exception
     */
    function userTasksTableOnClickUserListInDropdownFilter($userId):void
    {
        $userTasks = Task::findByUserId($userId);
        if ($userTasks):
        ?>
            <div id="userTaskTableDiv">
                <table class="table table-dark text-light text-capitalize caption-top" id="userTaskTable">
                    <caption class="my-3 text-center p-2" style="background-color: <?=$userTasks[0]->color?>">
                        <h3 class="d-inline text-sm fw-small text-white">
                            <?=$userTasks[0]->fullname .' Tasks from ' .$userTasks[0]->libelle?>
                        </h3>
                    </caption>
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($userTasks as $task): ?>
                        <tr data-id="userTasksTableOnClickUserListInDropdownFilter_<?=$userTasks[0]->getUserId()?>">

                            <td>
                                <?php
                                echo $i++ .'<br>';
                                if ($task->getFile()){
                                    $item = json_decode($task->getFile(), true);
                                    foreach ($item as $file){?>
                                        <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                        <?php
                                    }
                                }
                                ?>
                                <button class="border border-0 delItem" type="button" data-id="<?=$task->getTaskId()?>" style="text-decoration: none !important; background-color: inherit !important;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg>
                                </button>
                            </td>

                            <td>
                                <?=$task->getTaskId()?>
                            </td>
                            <td class="text-start text-sm">
                                <h6>Task</h6>
                                <div class="row">
                                    <ul class="list-unstyled col-md-8">
                                        <li class="nav-item">
                                            <?php $f = ($task->getCreatedAt()) ? new DateTime($task->getCreatedAt()) : date('Y-m-d H:i:s');
                                            echo '<p class="fw-small fs-6 text-capitalize mb-1">
                                                                  '.$task->getTitle().'<br>'. $task->getTodo().'
                                                                  <br> Created At: ' .$f->format('Y-m-d') .'</p>';
                                            ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled col-md-4">
                                        <li>
                                                                <span class="d-inline">
                                                                    <input type="checkbox" name="usercheckbox" id="usercheckbox" class="checkbox" value="<?=$task->getIsChecked()?>" <?php echo ($task->getIsChecked()) ? 'checked="checked"' : ''?> data-id="<?=$task->getTaskId().'_isChecked'?>">
                                                                    <label class="text-sm" for="usercheckbox">Responsible</label>
                                                                </span>
                                        </li>
                                        <li class="d-inline">
                                            <input type="checkbox" name="admincheckbox" id="admincheckbox" class="checkbox" value="<?=$task->getIsCheckedByAdmin()?>" <?php echo ($task->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> data-id="<?=$task->getTaskId().'_IsCheckedByAdmin'?>">
                                            <label for="admincheckbox" class="text-sm">Admin</label>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center text-sm">
                                <h6>Date & Hour</h6><br>
                                <?php
                                $f = new DateTime($task->getDueDate());
                                echo $f->format('d-m-Y H:i A');
                               ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>

                </table>
            </div>

            <script type="text/javascript">
                $('#userTaskTable').DataTable({
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
                        {"data":3}
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
            else: echo "<p class='text-sm text-center'>No user tasks found </p>";
            endif;
    }



}