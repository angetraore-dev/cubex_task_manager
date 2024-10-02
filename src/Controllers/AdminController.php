<?php

namespace App\Controllers;

use App\Models\Archive;
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

                case isset($_POST["userListByDepartmentTodelete"]):

                    $id = $_POST["userListByDepartmentTodelete"];
                    $this->user->userListByDepartmentTodelete($id);
                    break;

                //Insert/Delete Of Create department or create User
                case isset($_POST["formIns"]):

                    $save = "";

                    $data = json_decode($_POST["formIns"]);

                    if ( $data->class == 'department' ){

                        if ( $data->method == 'insert' ){

                            $check = Department::checkIfExist($data->department_libelle);

                            if ($check){

                                $save = "A department with the same name already exist";

                            }else{

                                $field = ['libelle' => $data->department_libelle, 'color'=> $data->department_color];

                                $save = $this->database->{$data->method}($field, $data->class);
                            }

                            echo $save;


                        }elseif( $data->method == 'delete' ){
                            //data= ['class', 'method']
                            $arr = [];

                            foreach ($data as $datum){

                                if ($datum != 'department' && $datum != 'delete'){

                                    $arr[] = $datum;
                                }
                            }

                            foreach ($arr as $item){

                                $save = $this->database->{$data->method}($item, $data->class);
                            }

                            echo $save;

                        }else{

                            StaticDb::notFound();
                        }

                    }elseif ( $data->class == 'user' ){

                        if ( $data->method == 'insert' ){

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

                        }elseif ( $data->method == 'delete' ){

                            $arr = [];

                            foreach ($data as $datum){

                                if ($datum != 'user' && $datum != 'delete' && $datum != 'department'){

                                    $arr[] = $datum;
                                }
                            }

                            foreach ($arr as $item){

                                $save = $this->database->{$data->method}($item, $data->class);
                            }

                            if ($save){
                                echo "Sucessfully Deleted";
                            }else{
                                echo "Something went wrong";
                            }

                        }else{

                            StaticDb::notFound();
                        }

                        echo $save;
                    }
                    break;

                case isset($_POST["userByDep"]): //ok
                    //Display Department User's List in User Dropdown Filter

                    $id = $_POST["userByDep"];
                    $this->user->displayUserListByDepartment($id);

                    break;

                case isset($_POST["displayDepartmentTaskOnDropdownClick"]): //ok
                    //Display Departments List on Department Dropdown Filter Clicked

                    $depId = $_POST["displayDepartmentTaskOnDropdownClick"];
                    $this->task->departmentTasksListInDropdownFilter($depId);

                    break;
                case isset($_POST["userTask"]): //ok
                    //Display User tasks OnClick on User's List in User Dropdown Filter

                    $userid = $_POST["userTask"];
                    $this->task->userTasksTableOnClickUserListInDropdownFilter($userid);

                    break;
                case isset($_POST["disForm"]):
                    //dynamic display Form - use to display delete department and user

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
    public function doneArchive():void
    {


        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)){

            switch ($_POST){

                case isset($_POST["doneArchiveCrud"]):

                    $data = json_decode($_POST["doneArchiveCrud"]);

                    if ( ! empty($data->existing_archive) ){
                        //In case Archive Already Exist
                        $field = [
                            'taskid' => $data->taskId,
                            'observation' => $data->obs,
                            'archiveid' => $data->existing_archive
                        ];
                        //Bind Archivetask
                        $class_name = "Archivetask";
                        $bindArchiveTask = StaticDb::getDb()->insert($field, $class_name);

                        //Update the Concerned Task to isArchived got True
                        if ( $bindArchiveTask ){

                            $class_name = "Task";
                            $updateTask = StaticDb::getDb()->update($data->taskId, ["isArchived" => true], $class_name);

                            echo $updateTask;
                        }


                    }else{
                        //Here Create Archive and return Id to Bind ArchiveTask but before check if Libelle already exist

                        $receiveData = $data->archive_libelle;
                        $checkIfExist = Archive::returnIdByLibelle($receiveData);

                        if (count($checkIfExist)){

                            echo "already exist";

                        }else{
                            //Create archive

                            $class_name = "Archive";
                            $createArchive = StaticDb::getDb()->insert(["libelle" => $receiveData], $class_name);

                            //Get last Insert Id
                            if ($createArchive){

                                $getLastInsert = Archive::returnIdByLibelle($receiveData);
                                $lastInsertId = $getLastInsert[0]->getArchiveId();

                                //Bind ArchiveTask
                                $field = [
                                    'taskid' => $data->taskId,
                                    'observation' => $data->obs,
                                    'archiveid' => $lastInsertId
                                ];
                                $class_name = "Archivetask";
                                $bindArchiveTask = StaticDb::getDb()->insert($field, $class_name);

                                //update Concerned Task
                                if ($bindArchiveTask){
                                    $class_name = "Task";
                                    $updateTask = StaticDb::getDb()->update($data->taskId, ['isArchived' => true], $class_name);

                                    echo $updateTask;
                                }

                            }

                        }

                    }


                    break;
                case isset($_POST["defBothChecked"]):

                    $this->task->archiveDefaultDisplay();

                    break;
                case isset($_POST["varsObj"]):

                    $data = json_decode($_POST["varsObj"]) ;

                    if ($data->entity == 'Department'){
                        //Get all Departments List

                        if (method_exists(Department::class, $data->filter)){

                            if (isset($data->id)){

                                $this->department->{$data->filter}($data->id);

                            }else{

                                $this->department->{$data->filter}();
                            }

                        }else{

                            StaticDb::notFound();
                        }

                    }elseif($data->entity == 'User'){

                        if (method_exists(User::class, $data->filter)){

                            if (isset($data->id)){

                                $this->user->{$data->filter}($data->id);

                            }else{

                                $this->user->{$data->filter}();
                            }

                        }else{

                            StaticDb::notFound();
                        }

                    }elseif($data->entity == 'Task'){

                        if (method_exists(Task::class, $data->filter)){

                            if (isset($data->id)){

                                $this->task->{$data->filter}($data->id);

                            }else{

                                $this->task->{$data->filter}();
                            }

                        }else{

                            StaticDb::notFound();
                        }

                    }else{

                        StaticDb::notFound();
                    }

                    break;
                case isset($_POST["departmentListForFilterArchive"]):

                   $this->department->departmentListInDoneArchive();

                   break;
                case isset($_POST["userDoneArchiveFilterList"]):

                    $this->user->displayUserListInFilterDoneArchived(json_decode($_POST["userDoneArchiveFilterList"]));

                    break;
                default: break;
            }
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