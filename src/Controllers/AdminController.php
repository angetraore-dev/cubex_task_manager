<?php

namespace App\Controllers;

use App\Models\Department;
use App\Models\User;

class AdminController
{
    private Department $department;
    private User $user;

    public function __construct()
    {
        $this->department = new Department();
        $this->user = new User();

    }

    public function index():void
    {
        $title = 'Admin panel';
        require_once DOCROOT .'/templates/admin/index.php';
    }

    public function adminRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            switch ($_POST){
                case isset($_POST["saveDepartment"]):

                    $item = json_decode($_POST["saveDepartment"]);
                    $field = ['libelle' => $item->department_libelle];
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
                    $this->user->delGrpedForm();
                    break;
                case isset($_POST["deleteUser"]):
                    $data = json_decode($_POST["deleteUser"]);
                    foreach ($data as $key => $value){
                        $del = $this->user->delete($value);
                    }
                    echo $del;
                    break;

            }
        }
    }

}