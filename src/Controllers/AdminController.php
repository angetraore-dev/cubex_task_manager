<?php

namespace App\Controllers;

use App\Models\Department;
use App\Models\StaticDb;
use App\Models\Task;
use App\Models\User;
use DateTime;
use App\Config;

class AdminController
{
    private Department $department;
    private User $user;
    private Task $task;

    public function __construct()
    {
        $this->department = new Department();
        $this->user = new User();
        $this->task = new Task();

    }

    public function index():void
    {
        $title = 'Admin panel';
        require_once DOCROOT .'/templates/admin/index.php';
    }

    /**
     * @throws \Exception
     */
    public function adminRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            switch ($_POST){

                case isset($_POST["saveDepartment"]):

                    $item = json_decode($_POST["saveDepartment"]);
                    $field = ['libelle' => $item->department_libelle, 'color'=> $item->department_color];
                    $save = $this->department->create($field);
                    echo $save;

                    break;
                case isset($_POST["saveUser"]):

                    $item = json_decode($_POST["saveUser"]);
                    $hashed = password_hash($item->password, PASSWORD_DEFAULT);
                    $field = [
                        'fullname' => $item->fullname,
                        'email' => $item->email,
                        'password' => $hashed,
                        'roleid' => $item->role,
                        'department' => $item->department
                    ];
                    $save = $this->user->create($field);
                    echo $save;

                    break;
                case isset($_POST["delUserForm"]):
                    //Display form list of user
                    $this->user->delGrpedForm();

                    break;
                case isset($_POST["deleteUser"]):
                    $data = json_decode($_POST["deleteUser"]);
                    foreach ($data as $key => $value){
                        $del = $this->user->delete($value);
                    }
                    echo $del;

                    break;
                case isset($_POST["delDepForm"]):
                    $this->department->delGrpedForm();

                    break;
                case isset($_POST["deleteDepartment"]):
                    $data = json_decode($_POST["deleteDepartment"]);
                    $del = 0;
                    foreach ($data as $value){
                        $del = $this->department->delete($value);
                    }
                    echo $del;

                    break;
                case isset($_POST["userByDep"]):

                    $id = $_POST["userByDep"];
                    $data = $this->user->findByDepartmentId($id);
                    if ($data){
                        $output = "";
                        foreach ($data as $datum){

                            $output .="<li class='dropdown-item list-unstyled' data-id='".$datum->getUserId()."'><p>".$datum->getFullname()."</p></li>";
                        }
                        $output .="<li class='dropdown-item list-unstyled alldep' data-id='".$id."'>all department's tasks</li>";
                        echo $output;
                    }else{
                        echo "<li>No records found</li>";
                    }

                    break;
                case isset($_POST["depTask"]):
                    $departmentId = $_POST["depTask"];
                    $departmentTasks = Task::findTaskByJoinDepartment($departmentId);
                    //var_dump($departmentTasks);
                    if ($departmentTasks){?>
                        <div class="table-responsive" id="DepartmentTasksTableDiv">
                            <table class="table text-uppercase text-center caption-top" id="DepartmentTasksTable">
                                <caption><h3><?=$departmentTasks[0]->libelle. "'s department"?></h3></caption>
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tasks</th>
                                    <th scope="col">Checked</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Responsible</th>
                                    <th scope="col">Date & Hour</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($departmentTasks as $task):?>
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=$task->getTitle() .'<br>' .$task->getTodo()?></td>
                                        <td>
                                            <div class="input-group-sm">
                                                <input type="checkbox" value="<?=$task->getIsChecked()?>" name="responsible" id="responsible">
                                                <label for="responsible">Done by responsible</label>
                                            </div>
                                            <div class="input-group-sm">
                                                <input type="checkbox" value="<?=$task->getIsCheckedByAdmin()?>" name="admin" id="admin">
                                                <label for="admin">Done by Admin</label>
                                            </div>
                                        </td>
                                        <td>
                                                <span class="d-block">
                                                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$task->color?>"></rect></svg>
                                                <?= $task->libelle?>
                                                </span>
                                        </td>
                                        <td><?=$task->fullname?></td>
                                        <td><?php $f = new DateTime($task->due_date); echo $f->format('Y-m-d, H:i A') ?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>

                            </table>
                        </div>

                        <?php
                    }else{
                        //display no task exist for thiis department
                        echo "<p class='text-muted text-center'>No records found for this department </p>";
                    }
                    break;
                case isset($_POST["userTask"]):

                    $userid = $_POST["userTask"];
                    $userTasks = Task::findByUserId($userid);
                    if ($userTasks){?>
                        <div class="table-responsive" id="userTaskTableDiv">
                            <table class="table text-uppercase text-center caption-top" id="userTaskTable">
                                <caption class="text-dark fw-bold"><h3><?=$userTasks[0]->fullname."'s tasks"?></h3></caption>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tasks</th>
                                        <th scope="col">Checked</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Date & Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($userTasks as $task):?>
                                        <tr>
                                            <td><?=$i++?></td>
                                            <td><?=$task->getTitle() .'<br>' .$task->getTodo() .'<br>'.$task->getFile()?></td>
                                            <td>
                                                <div class="input-group-sm">
                                                    <input type="checkbox" value="<?=$task->getIsChecked()?>" name="responsible" id="responsible">
                                                    <label for="responsible">Done by responsible</label>
                                                </div>
                                                <div class="input-group-sm">
                                                    <input type="checkbox" value="<?=$task->getIsCheckedByAdmin()?>" name="admin" id="admin">
                                                    <label for="admin">Done by Admin</label>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block">
                                                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$task->color?>"></rect></svg>
                                                <?= $task->libelle?>
                                                </span>
                                            </td>
                                            <td><?php $f = new DateTime($task->due_date); echo $f->format('Y-m-d H:i A') ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>

                            </table>
                        </div>
                    <?php
                    }else{
                        echo "<p class='text-muted text-center'>No user tasks found </p>";
                    }
                    break;

                case isset($_POST["taskBtn"]):
                    $this->task->taskForm();
                    break;
                default: StaticDb::notFound(); break;
            }
        }
    }

    public function addtaskRequest():void
    {
        $field = array();
        $arrFiles = $_FILES['file'];
        $fileData = "";

        if (!empty($arrFiles)){
            $targetDir =  'assignedFiles';
            $fileArr = array();


            foreach ($arrFiles['tmp_name'] as $key => $tmp_name){

                foreach ( $arrFiles['name'] as $keyName => $name){

                    foreach ($arrFiles['full_path'] as $keyfile => $filePath){

                        if ($key == $keyName){

                            $fileName = basename($name);
                            $tmpName = $tmp_name;

                            $dest = DOCROOT ."/".$targetDir."/".$fileName;
                            $upload = move_uploaded_file($tmpName, $dest);

                            if ($upload){

                                $fileArr[$keyName] = "assignedFiles/".$fileName;
                                //$fileArr['full_path'][$keyName] = $filePath;
                                //$fileArr['name'][$keyName] = $fileName;

                            }
                        }
                    }

                }
            }
            $fileData = json_encode($fileArr);
        }

        $field = [
            'title' => $_POST["title"],
            'todo'=> $_POST["todo"],
            'due_date'=> date('Y-m-d H:i:s',strtotime($_POST["due_date"])),
            'created_at'=> date('Y-m-d'),
            'userid'=> $_POST["userid"],
            'file' => $fileData
        ];

        $createTask = $this->task->create($field);
        echo $createTask;

    }

}