<?php

namespace App\Controllers;

use App\Models\Department;
use App\Models\StaticDb;
use App\Models\Task;
use App\Models\User;
use App\Models\Database;

class AdminController
{
    private Department $department;
    private User $user;
    private Task $task;
    private Database $database;

    public function __construct()
    {
        $this->department = new Department();
        $this->user = new User();
        $this->task = new Task();
        $this->database = new Database();

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

                case isset($_POST["formIns"]):
                    $save = "";
                    $data = json_decode($_POST["formIns"]);
                    if ($data->class == 'department' && $data->method == 'insert'){
                        $check = Department::checkIfExist($data->department_libelle);
                        if ($check){
                            $save = "A department with the same name already exist";

                        }else{
                            $field = ['libelle' => $data->department_libelle, 'color'=> $data->department_color];
                            $save = $this->database->{$data->method}($field, $data->class);
                        }
                        echo $save;

                    }elseif ($data->class == 'user' && $data->method == 'insert'){

                        $check = User::findByEmail($data->email);
                        if ($check){

                            $save = "An User with the same Email already Exist";

                        }else{

                            $hashed = password_hash($data->password, PASSWORD_DEFAULT);

                            $field = [
                                'fullname' => $data->fullname,
                                'email' => $data->email,
                                'password' => $hashed,
                                'roleid' => $data->role,
                                'department' => $data->department
                            ];
                            $save = $this->database->{$data->method}($field, $data->class);

                        }
                        echo $save;
                    }
                    break;

                case isset($_POST["delUserForm"]):
                    //Display form list of user
                    $this->user->delGrpedForm();

                    break;
                case isset($_POST["deleteUser"]):
                    //Must be Review

                    $data = json_decode($_POST["deleteUser"]);
                    foreach ($data as $key => $value){
                        $del = $this->database->delete($value, 'user');
                    }
                    echo $del;

                    break;
                case isset($_POST["delDepForm"]):
                    //Must be review

                    $this->department->delGrpedForm();

                    break;

                case isset($_POST["deleteDepartment"]):
                    //Delete Department must be review

                    $data = json_decode($_POST["deleteDepartment"]);
                    $del = 0;
                    foreach ($data as $value){
                        $del = $this->database->delete($value, 'department');
                    }
                    echo $del;

                    break;

                case isset($_POST["userByDep"]):
                    //Display Department User's List in User Dropdown Filter

                    $id = $_POST["userByDep"];
                    $this->user->displayUserListByDepartment($id);

                    break;

                case isset($_POST["displayDepartmentTaskOnDropdownClick"]):
                    //Display Departments List on Department Dropdown Filter Clicked

                    $depId = $_POST["displayDepartmentTaskOnDropdownClick"];
                    $this->task->departmentTasksListInDropdownFilter($depId);

                    break;
                case isset($_POST["userTask"]):
                    //Display User tasks OnClick on User's List in User Dropdown Filter

                    $userid = $_POST["userTask"];
                    $this->task->userTasksTableOnClickUserListInDropdownFilter($userid);

                    break;
                case isset($_POST["disForm"]):
                    //dynamic display Form

                    $data = $_POST["disForm"];
                    $explode_data = explode("_", $data);

                    if (isset($explode_data[1])){

                        $model = $explode_data[0];

                        $func = $explode_data[1];

                        $this->{$model}->{$func}();

                    }else{
                        echo "not found";
                    }

                    break;

                case isset($_POST["selectOpt"]):
                    //List of user by department in assign task to a user

                    $departmentId = $_POST["selectOpt"];
                    $this->user->userListBydepartmentInAddTaskForm($departmentId);
                    break;

                case isset($_POST["delTask"]):
                    //Delete Task in any table

                    $identifier = $_POST["delTask"];
                    $del = $this->database->delete($identifier, 'task');
                    echo $del;

                    break;
                case isset($_POST["checkedd"]):
                    //user and admin checkbox

                    $data = json_decode($_POST["checkedd"]);
                    $bit = ($data->check) ? 1 : "0";
                    $val = explode("_", $data->taskId);
                    $taskId = $val[0];
                    $field = $val[1];
                    $arr = ["$field" => $bit];
                    $update = $this->database->update($taskId, $arr, 'task');
                    echo $update;

                    break;
                case isset($_POST["departmentList"]):
                    //Concerne department list in Task Page

                    $list = Department::departmentJoinHeader();
                    $this->department->displayDepartmentslist($list);

                    break;

                case isset($_POST["departmentListForFilter"]):
                    //display list of department in DEPARTMENT Dropdown Filter

                    $this->department->departmentInDropdownFilter();
                    break;

                case isset($_POST["activeTasksList"]):

                    $this->task->futureTaskInTaskPage();

                    break;
                case isset($_POST["viewTasksBtn"]):
                //This case is for display tasks onclick on View all tasks - today task - late task and future task Btn

                    $func = $_POST["viewTasksBtn"];
                    $ex = explode("_", $func);

                    if (isset($ex[1])){
                        $method = $ex[0];
                        $args = $ex[1];

                        if ( method_exists(Task::class, $method) ){

                            if (isset($args)) {
                                $this->task->{$method}($args);
                            }

                        }else{
                            StaticDb::notFound();
                        }

                    }else{

                        if ( method_exists(Task::class, $func) ){

                            $this->task->{$func}();

                        }else{

                            StaticDb::notFound();
                        }

                    }

                    break;

                //default: StaticDb::notFound(); break;
            }
            //end if $_POST
        }
    }

    /**
     * @return void
     */
    public function addtaskRequest():void
    {
        $arrFiles = $_FILES['file'];
        $fileData = "";

        if (!empty($arrFiles)){
            $targetDir =  "assignedFiles";
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
        $createTask = $this->database->insert($field, 'task');

        echo $createTask;
    }

}