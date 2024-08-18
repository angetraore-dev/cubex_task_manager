<?php
use App\Models\Department;
use App\Models\Role;
use App\Models\Task;

ob_start();?>



<div class="d-flex align-items-center justify-content-center col-12 col-lg-12 d-none">
    <div class="loader my-4"></div>
</div>
<div class="container" id="first-page-admin">
    <div class="row">
        <div class="d-flex justify-content-between mt-4 mb-2">
            <button data-id="project-page" class="pageHref btn btn-lg col-4 h-auto mb-3 text-center text-capitalize rounded rounded-0 border border-1 border-tertiary" type="button" style="color: gold !important; font-weight: lighter !important; height: 200px !important; ">Projects</button>
            <button data-id="task-page" class="pageHref btn btn-lg col-4 h-auto mb-3 text-center text-capitalize rounded rounded-0 border border-1 border-tertiary" type="button" style="color: gold !important; font-weight: lighter !important; height: 200px !important; ">tasks</button>
        </div>
        <div class="d-flex justify-content-end mb-4">
            <?php $role= $_SESSION['role']; if ($role == 1) : ?>
                <button data-id="addTask-page" class="pageHref btn btn-lg col-4 text-center text-capitalize rounded rounded-0 border border-1 border-tertiary" type="button" style="color: gold !important; font-weight: lighter !important;">add tasks</button>
            <?php endif;?>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <button data-id="meeting-page" class="pageHref btn btn-lg col-4 mb-3 text-center text-capitalize rounded rounded-0 border border-1 border-tertiary" type="button" style="color: gold !important; font-weight: lighter !important; height: 200px !important;">meetings</button>
            <button data-id="order-page" class="pageHref btn btn-lg col-4 mb-3 text-center text-capitalize rounded rounded-0 border border-1 border-tertiary" type="button" style="color: gold !important; font-weight: lighter !important; height: 200px !important;">orders</button>
        </div>
        <?php $role= $_SESSION['role']; if ($role == 1) : ?>
            <div class="d-flex align-items-start justify-content-between mb-4"><!--col-md-4-->
                <button data-id="addMeeting-page" class="pageHref btn btn-lg col-4 mb-3 text-center text-capitalize rounded rounded-0 border border-1 border-tertiary" type="button" style="color: gold !important; font-weight: lighter !important;">add meetings (Only x)</button>
            </div>
        <?php endif;?>
    </div>
</div>

 <!-- NEW NEW MENU Start DIVs for differents menu items -->
    <div class="container-fluid p-0" id="BigContainer">

        <div class="d-flex align-items-stretch py-1 h-100 min-vh-100 vh-100 mh-100" style="height: 100%">

        <!-- left Bar contain Logo and go back button -->
        <div class="col-lg-1 p-1 mh-100 backDiv d-none" style="height: 100vh;">
            <!-- Logo -->
            <div class="text-center justify-content-start align-self-start mb-3">
                <h3 class="fs-2 fw-bolder">X</h3>
            </div>

            <!--Back Button -->
            <button class="btn btn-link-hover text-white align-self-end justify-content-end back" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"></path>
                </svg>
                Back
            </button>
        </div>

        <!-- Menu Main container -->

        <!-- TASK-page -->
        <div class="col-lg-11 col-10 p-1 d-none" id="task-page">
            <!-- Header -->
            <div class="d-flex flex-row">
                <div class="align-self-start">
                    <div class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <p class="navbar-brand fs-3 fw-smaller" style="color: gold">
                                <i class="fa fa-home"></i> Tasks
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ms-auto me-0">
                    <div class="d-flex flex-column flex-grow-1 justify-content-between p-1">
                        <button class="btn btn-sm mb-2" style="background-color: gold; text-decoration: none !important; color: #FFFFFF;" type="button">Checked</button>
                        <button class="btn btn-sm" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">not Checked</button>
                    </div>

                </div>
            </div>
            <!-- Header -->

            <!-- Departments View -->
            <div class="row g-0 p-0" id="departmentListInTaskPage"></div>

            <!-- Active Task List view -->
            <div class="container-fluid p-0 d-flex flex-wrap justify-content-between activeTasksInTaskPage" id="activeTasksInTaskPage">


            </div>


        </div>

        <!-- AddTask - page -->
        <div class="col-lg-11 col-10 p-1 d-none" id="addTask-page">
            <!-- Header -->
            <div class="d-flex flex-row">
                <div class="align-self-start">
                    <div class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <p class="navbar-brand fs-3 fw-smaller" style="color: gold">
                                <i class="fa fa-home"></i> Tasks
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ms-auto me-0">
                    <div class="d-flex flex-column flex-grow-1 justify-content-between p-1">
                        <button class="btn btn-sm mb-2" style="background-color: gold; text-decoration: none !important; color: #FFFFFF;" type="button">Checked</button>
                        <button class="btn btn-sm" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">not Checked</button>
                    </div>

                </div>
            </div>

            <!--container -->
            <div class="row g-0 mt-4"><h3 class="text-center my-4"> Add Task Page</h3> </div>
        </div>

        <!--PROJECT Page -->
        <div class="col-lg-11 col-10 p-1 d-none" id="project-page">
            <!--Header -->
            <div class="d-flex flex-row">

                <!-- Menu Page title -->
                <div class="align-self-start">
                    <div class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <p class="navbar-brand fs-3 fw-smaller" style="color: gold">
                                <i class="fa fa-home"></i> Projects
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Lexik checked not checked -->
                <div class="ms-auto me-0">
                    <div class="d-flex flex-column justify-content-between p-1">
                        <button class="btn btn-sm mb-2" style="background-color: gold; text-decoration: none !important; color: #FFFFFF;" type="button">Checked</button>
                        <button class="btn btn-sm" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">not Checked</button>

                        <!--
                        <div class="container-fluid">
                            <h3 class="text-center fs-4">X</h3>
                        </div>
                        -->
                    </div>

                </div>
            </div>
            <!--container -->
            <div class="row g-0"><h3 class="text-center my-4">Project Page</h3> </div>

        </div>

        <!--MEETING Page -->
        <div class="col-lg-11 col-10 p-1 d-none" id="meeting-page">
            <!--Header -->
            <div class="d-flex flex-row">
                <div class="align-self-start">
                    <div class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <p class="navbar-brand fs-3 fw-smaller" style="color: gold">
                                <i class="fa fa-home"></i> Meetings
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ms-auto me-0">
                    <div class="d-flex flex-column justify-content-between p-1">
                        <button class="btn btn-sm mb-2" style="background-color: gold; text-decoration: none !important; color: #FFFFFF;" type="button">Checked</button>
                        <button class="btn btn-sm" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">not Checked</button>

                        <!--
                        <div class="container-fluid">
                            <h3 class="text-center fs-4">X</h3>
                        </div>
                        -->
                    </div>

                </div>
            </div>
            <!--container -->
            <div class="row g-0"><h3 class="text-center my-4">Meeting Page</h3> </div>
        </div>

        <!--ORDER Page -->
        <div class="col-lg-11 col-10 p-1 d-none" id="order-page">
            <!-- Header -->
            <div class="d-flex flex-row">
                <div class="align-self-start">
                    <div class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <p class="navbar-brand fs-3 fw-smaller" style="color: gold">
                                <i class="fa fa-home"></i> Orders
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ms-auto me-0">
                    <div class="d-flex flex-column justify-content-between p-1">
                        <button class="btn btn-sm mb-2" style="background-color: gold; text-decoration: none !important; color: #FFFFFF;" type="button">Checked</button>
                        <button class="btn btn-sm" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">not Checked</button>
                    </div>
                </div>
            </div>
            <!--container -->
            <div class="row g-0"><h3 class="text-center my-4">Order Page</h3> </div>
        </div>

        <!--ADD MEETING PAGE Page -->
        <div class="col-lg-11 col-10 p-1 d-none" id="addMeeting-page">
            <!-- Header -->
            <div class="d-flex flex-row">
                <div class="align-self-start">
                    <div class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <p class="navbar-brand fs-3 fw-smaller" style="color: gold">
                                <i class="fa fa-home"></i> Meeting Form
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ms-auto me-0">
                    <div class="d-flex flex-column justify-content-between p-1">
                        <button class="btn btn-sm mb-2" style="background-color: gold; text-decoration: none !important; color: #FFFFFF;" type="button">Checked</button>
                        <button class="btn btn-sm" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">not Checked</button>

                        <!--
                        <div class="container-fluid">
                            <h3 class="text-center fs-4">X</h3>
                        </div>
                        -->
                    </div>

                </div>
            </div>
            <!--container -->
            <div class="row g-0"><h3 class="text-center my-4">Add Meeting Form</h3> </div>
        </div>
        <!-- Col Container Page -->
    </div>
    <!-- End BigContainer -->
</div>
 <!-- End DIVs for differents menu items -->


<div class="container-fluid d-none">
    <!-- Department user responsible task Buttond DIV close on click add task-->
    <div id="depUserTaskDiv">
        <!-- Container for first buttons line row mt-4-->
        <div class="row justify-content-between mt-4">
            <!-- Left Buttons div -->
            <div class="col-sm-4">
                <!-- add department delete department
                justify-content-around
                -->
                <div class="bg-body-tertiary shadow-lg rounded rounded-2 mb-3 p-1">
                    <fieldset class="border border-2 p-1 fw-bolder text-uppercase">
                        <legend  class="float-none w-auto text-wrap">Department</legend>
                        <div class="d-flex col justify-content-between">

                            <div class="me-2">
                                <button data-bs-toggle="modal" data-bs-target="#addDepartment" type="button" id="add-dep" class="add-dep col btn btn-success btn-outline-light text-uppercase border-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#delDep" class="delDep col btn btn-danger btn-outline-light text-uppercase border-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <!-- add User delete delete user -->
                <div class="justify-content-around bg-body-tertiary shadow-lg rounded rounded-2 mx-2 mb-3 p-2">
                    <fieldset class="border border-2 p-2 fw-bold text-end text-uppercase">
                        <legend  class="float-none w-auto">User</legend>
                        <div class="d-flex col justify-content-between">

                            <div class="me-2">
                                <button data-bs-toggle="modal" data-bs-target="#addUser" type="button" id="add-user" class="add-user col btn btn-success btn-outline-light text-uppercase border-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="">
                                <button data-bs-toggle="modal" data-bs-target="#delUser"  type="button" class="delUser col btn btn-danger btn-outline-light text-uppercase border-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <!-- Right Buttons div -->
            <div class="col-sm-4">
                <!--filter for departments and responsibles-->
                <div class="d-flex shadow-lg justify-content-between rounded rounded-2 mb-5 p-1">

                    <!-- List of all departments -->
                    <div class="dropdown mx-2 departmentlist" id="departmentlist">
                        <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            departments
                        </button>
                        <ul class="dropdown-menu depList">
                            <?php $dropdown_department = Department::readAll(); if($dropdown_department): foreach ($dropdown_department as $item): ?>
                                <li class="list-unstyled deptarment" data-id="<?= $item->getDepartmentId()?>">
                                    <a class="dropdown-item" href="#">
                                    <span class="d-block">
                                    <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$item->getColor()?>"></rect></svg>
                                    <?= $item->getLibelle()?>
                                    </span>
                                    </a>

                                </li>
                            <?php endforeach; else:?>
                                <li class="text-center text-muted"><span> No records found</span></li>
                            <?php endif;?>
                        </ul>
                    </div>

                    <!-- List of all responsible -->
                    <div class="dropdown mx-2">
                        <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            responsibles
                        </button>
                        <ul class="dropdown-menu" id="userbydepartment-1">

                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <!-- Centered Button ADD TASK -->
        <div class="d-flex justify-content-center align-items-center my-2">
            <fieldset class="border border-2 fw-bold text-center text-uppercase">
                <legend  class="float-none w-auto">add task</legend>
                <button type="button" id="addTaskBtn" class="add-user btn btn-success btn-outline-light text-uppercase border-success mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                </button>
            </fieldset>
        </div>
    </div>
    <!-- loader -->
    <div class="d-flex justify-content-center align-items-center d-none" id="loaderDiv">
        <div class="loader"></div>
    </div>

    <!-- Form add Task Div -->
    <div class="col-md-8 mx-auto d-flex justify-content-center align-items-center d-none" id="taskFormDiv"></div>
    <!-- Tasks(title-tasks-checked) Department Responsible - due date-->
    <div class="row">
        <div class="table-responsive" id="activeTaskDiv">
            <table class="table table-condensed table-hover text-capitalize" id="activesTasksTable">
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
                <?php $i=1; $activeTasksList= Task::activesTasks(); if ($activeTasksList) : foreach ($activeTasksList as $activeList): var_dump($activeTasksList);?>
                    <tr data-id="<?=$activeList->getTaskId()?>">
                        <td><?= $i++?></td>
                        <td><?=$activeList->getTaskId()?></td>
                        <td class="d-flex justify-content-between fs-6 fw-lighter">
                            <ul class="list-unstyled">
                                <li class="nav-item"><?= '<p class="text-muted fw-bolder fs-6 text-capitalize mb-1">title: '.$activeList->getTitle() .'<br>To do: '. $activeList->getTodo()
                                    .'<br>assigned To: "'.$activeList->fullname.'"</p>';
                                    if ($activeList->getFile()){
                                        $item = json_decode($activeList->getFile(), true);
                                        foreach ($item as $file){?>
                                            <a href="<?= HTTP .'/'.$file ?>" target="_blank"><i class="fa fa-paperclip"></i> </a><br>
                                            <p class="text-muted text-capitalize fs-6">created at: <?php $f = new DateTime($activeList->getCreatedAt()); echo $f->format('Y-m-d');?> </p>
                                            <?php
                                        }
                                    }
                                    ?></li>

                            </ul>
                            <ul class="list-unstyled">
                                <li>
                                        <span class="d-inline">
                                            <input type="checkbox" value="<?=$activeList->getIsChecked()?>" <?php echo ($activeList->getIsChecked()) ? 'checked="checked"' : ''?> name="responsible" id="responsible" data-id="<?=$activeList->getTaskId()?>">
                                            <label class="text-sm" for="responsible">Responsible</label>
                                        </span>
                                </li>
                                <li class="d-inline">
                                    <input type="checkbox" value="<?=$activeList->getIsCheckedByAdmin()?>" <?php echo ($activeList->getIsCheckedByAdmin()) ? 'checked="checked"' : ''?> name="admin" id="admin" data-id="<?=$activeList->getTaskId()?>">
                                    <label for="admin" class="text-sm">Admin</label>
                                </li>
                            </ul>
                        </td>
                        <td><?=$activeList->libelle .
                            ' <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="'.$activeList->color.'"></rect></svg>'?>
                        </td>
                        <td>
                            <?php if ($activeList->getDueDate()){
                                $f = new DateTime($activeList->getDueDate()); echo '<svg class="bd-placeholder-img rounded me-2" width="10" height="10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="green"></rect></svg>'.$f->format('Y-m-d H:i A');
                            }?>
                        </td>
                    </tr>

                <?php endforeach; else: echo "<p class='text-muted text-center'>No records found ! </p>"; endif;?>
                </tbody>
            </table>
        </div>

        <div class="row my-2 d-none" id="user-task-table"></div>
        <div class="row my-2 d-none" id="department-task-table"></div>
        <div class="text-end">
            <button type="button" class="btn btn-success btn-outline-secondary text-white text-center" onclick="return window.location.reload();">REFRESH</button>
        </div>
    </div>
    <!-- Tabs d-non -->
    <div class="row d-none">
        <ul class="nav nav-fill nav-tabs btn" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="activesTasks-tab" data-bs-toggle="tab" data-bs-target="#nav-activesTasks" role="tab" aria-controls="nav-activesTasks" aria-selected="true"> Actives Tasks </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="archivedTasks-tab" data-bs-toggle="tab" data-bs-target="#nav-archivedTasks" role="tab" aria-controls="nav-archivedTasks" aria-selected="false"> Archived Tasks </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="futuresTasks-tab" data-bs-toggle="tab" data-bs-target="#nav-futuresTasks" role="tab" aria-controls="nav-futuresTasks" aria-selected="false"> Today Tasks </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="inWaitingTasks-tab" data-bs-toggle="tab" data-bs-target="#nav-inWaitingTasks" role="tab" aria-controls="nav-inWaitingTasks" aria-selected="false"> Tasks in Waiting </a>
            </li>
        </ul>
        <div class="tab-content pt-5" id="tab-content">
            <!-- Actives Tasks -->
            <div class="tab-pane active" id="nav-activesTasks" role="tabpanel" aria-labelledby="nav-activesTasks">

                <div class="row my-2" id="activesTasksTableDiv">
                    <div class="table-responsive">
                        <!--
                        <table class="table table-condensed text-uppercase" id="activesTasksTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>id</th>
                                <th>task</th>
                                <th>checked</th>
                                <th>department</th>
                                <th>responsible</th>
                                <th>due date</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        -->
                    </div>
                </div>
            </div>
            <!--ArchivedTasks -->
            <div class="tab-pane" id="nav-archivedTasks" role="tabpanel" aria-labelledby="nav-archivedTasks">
                <div class="row my-2" id="archivedTableDiv">
                    <div class="table-responsive">
                        <table class="table table-condensed text-uppercase" id="archivedTasksTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>id</th>
                                <th>task</th>
                                <th>due date</th>
                                <th>checked</th>
                                <th>archived</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!--Future Tasks -->
            <div class="tab-pane" id="nav-futuresTasks" role="tabpanel" aria-labelledby="nav-futuresTasks">Today and future tasks</div>
            <!-- In waiting To check Tasks -->
            <div class="tab-pane" id="nav-inWaitingTasks" role="tabpanel" aria-labelledby="nav-inWaitingTasks">In waiting task</div>

        </div>
    </div>

</div>


<!-- Modal add Department-->
<div class="modal fade" id="addDepartment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">add department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form g-3 needs-validation" id="departmentForm" novalidate>
                    <div class="form-group">
                        <label for="department_libelle">Department name</label>
                        <input type="text" name="department_libelle" id="department_libelle" class="form-control" required>
                        <div class="invalid-feedback">
                            enter a department
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="department_color">Department color</label>
                        <input type="color" name="department_color" id="department_color" class="form-control" required>
                        <div class="invalid-feedback">
                            enter a department
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancelDepartment" data-bs-dismiss="modal">cancel</button>
                        <button type="button" id="saveDepartment" name="saveDepartment" class="btn btn-primary">create</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal add User-->
<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">add user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="userForm" role="form" novalidate>
                    <div class="col-md-4 mb-3">
                        <label for="fullname">Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
                        <div class="invalid-feedback">
                            Please fill out
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="password">Password</label>
                        <input minlength="6" maxlength="9" type="password" name="password" id="password" class="form-control" required>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancelUser" data-bs-dismiss="modal">cancel</button>
                        <button type="button" id="saveUser" name="saveUser" class="btn btn-primary">add</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal delete user List -->
<div class="modal fade" id="delUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabelDel">Delete user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="delUserList"></div>
            </div>

        </div>
    </div>
</div>

<!-- Modal delete department List -->
<div class="modal fade" id="delDep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabelDel">Delete department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="delDepList">hey</div>
            </div>

        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once DOCROOT .'/templates/layout.php';?>