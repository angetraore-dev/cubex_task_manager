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
                <div class="container-fluid p-0 d-flex flex-wrap justify-content-between activeTasksInTaskPage" id="activeTasksInTaskPage"></div>

            </div>

            <!-- AddTask - page and Done Archive Div-->
            <div class="col-lg-11 col-10 p-1 d-none" id="addTask-page">
                <!-- Header -->
                <div class="col d-flex flex-row">
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
                            <button data-id="doneArchiveContainerDiv" class="pageHref btn btn-sm text-uppercase" style="border: gold 1px solid; text-decoration: none !important; color: #FFFFFF;" type="button">Done Archive</button>
                        </div>
                    </div>
                </div>
                <!-- End Row Header -->

                <div class="container-fluid border border-1" id="addTaskPageContainerDiv">

                <!-- All Button in Add-Task-Page BTN DIV-->
                <div class="row allBtnsAddTaskPage" id="depUserTaskDiv">

                    <!-- DIV FOR DEPARTMENT TASK BTN ROW -->
                    <div class="row ps-0 justify-content-around departmentTaskDiv">
                        <div class="col-sm-3">
                            <fieldset class="d-flex flex-wrap align-self-start justify-content-around border border-1 pb-2">
                                <legend  class="float-none w-auto fw-small fs-6 text-uppercase">Department</legend>

                                <!--department_addDepartmentFormChoice-->
                                <button id="addDepBtn" data-id="department_addDepartmentForm" class="addBtn btn btn-sm btn-outline-success text-uppercase border border-1" style="text-decoration: none !important; color: #FFFFFF;" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill mx-4" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                </button>
                                <!-- i ve use addBtn to display deleteform because jquery post is the same
                                   <button data-id="department_delDepartmentForm" data-bs-toggle="modal" data-bs-target="#delDep" data-id="department_delDepartmentForm" class="addBtn delDep delBtn btn btn-sm text-uppercase btn-outline-danger border border-1" style="text-decoration: none !important; color: #FFFFFF;" type="button">
                                -->
                                <button type="button" class="addBtn btn btn-sm text-uppercase btn-outline-danger border border-1" data-id="department_delDepartmentForm" style="text-decoration: none !important; color: #FFFFFF;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill mx-4" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </fieldset>
                        </div>
                        <div class="col-sm-3">
                            <fieldset class="d-flex flex-wrap align-self-center justify-content-around pb-2">
                                <legend  class="float-none w-auto fw-small fs-6 text-uppercase mx-auto">add task</legend>
                                <button type="button" id="addTaskBtn" data-id="task_addTaskForm" class="addBtn btn btn-sm btn-outline-success text-uppercase border-success mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill mx-4" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                </button>
                            </fieldset>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                    <!-- VIEW ALL TASK BTN -->
                    <div class="row justify-content-around">
                        <div class="col-sm-3 mb-4">
                            <div class="d-flex flex-wrap align-self-center justify-content-around pb-2">
                                <!-- id=viewAllTasksBtn class=viewAllTasksBtn-->
                                <button type="button" data-id="viewAllTasksInAddTaskPage"  class="btn btn-sm btn-outline-success text-uppercase border border-1 viewTasksBtn" style="text-decoration: none !important; color: #FFFFFF;">
                                    View all tasks
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- DIV FOR USER LATE TODAY FUTURE DROPDOWN DEPARTMENT-RESPONSIBLE -->
                    <div class="row justify-content-around">
                        <!-- USER Btn -->
                        <div class="col-sm-3 mb-4">
                            <fieldset class="d-flex flex-wrap align-self-center justify-content-around border border-1 pb-2">
                                <legend  class="float-none w-auto fw-small fs-6 text-uppercase">User</legend>
                                <button data-id="user_addUserForm" id="add-user" class="addBtn btn btn-sm btn-outline-success text-uppercase border border-1" style="text-decoration: none !important; color: #FFFFFF;" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill mx-4" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                </button>
                                <button type="button" data-id="user_delUserForm" class="addBtn btn btn-sm text-uppercase btn-outline-danger border border-1" style="text-decoration: none !important; color: #FFFFFF;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill mx-4" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </fieldset>
                        </div>

                        <!-- LATE - TODAY - FUTURE Btn -->
                        <div class="col-sm-5 mb-4">
                            <fieldset class="d-flex flex-wrap justify-content-around align-content-around border border-1 pb-2">
                                <legend  class="float-none w-auto fw-small fs-6 text-uppercase">tasks Btn</legend>

                                <button type="button" data-id="viewLateTasksInAddTaskPage"  class="btn btn-sm text-uppercase border border-1 text-center viewTasksBtn" style="text-decoration: none !important; color: #FFFFFF;">Late</button>

                                <button type="button" data-id="viewTodayTasksInAddTaskPage" class="btn btn-sm text-uppercase border border-1 text-center viewTasksBtn" style="text-decoration: none !important; color: #FFFFFF;">Today</button>

                                <button type="button" data-id="viewFutureTasksInAddTaskPage" class="btn btn-sm text-uppercase border border-1 text-center viewTasksBtn" style="text-decoration: none !important; color: #FFFFFF;">Future</button>

                                <!--<span class="badge text-bg-secondary">1</span>-->
                                <button type="button" data-id="viewInWaitingTasksInAddTaskPage" class="btn btn-sm text-uppercase border border-1 text-center viewTasksBtn" style="text-decoration: none !important; color: #FFFFFF;">Waiting </button>

                            </fieldset>
                        </div>

                        <!-- DEPARTMENT - USER FILTER Btn -->
                        <div class="col-sm-3 mb-4">
                            <fieldset class="d-flex flex-wrap justify-content-around align-content-around border border-1 pb-2">
                                <legend  class="float-none w-auto fw-smaller fs-6 text-uppercase">filter</legend>

                                <!-- List of all departments mx-2-->
                                <div class="dropdown departmentListFilter">
                                    <button class="btn btn-sm border border-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="text-decoration: none; color: white !important;">
                                        departments
                                    </button>
                                    <ul class="dropdown-menu receiveDepartmentList" id="receiveDepartmentList"></ul>
                                </div>

                                <!-- List of all responsible -->
                                <div class="dropdown mx-2">
                                    <button class="btn btn-sm border border-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-autohide="true"
                                            style="text-decoration: none; color: white !important;">
                                        users
                                    </button>
                                    <ul class="dropdown-menu list-unstyled" id="userbydepartment-1"></ul>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                    <!-- End Row AllBtnsAddTaskPage -->
                <!-- Tab-Content-->
                <div class="row" id="AddTaskPageContainerBtnClick">

                    <!-- Dynamics displayed all tables -->
                    <div class="table-responsive allTables d-none" id="allTables"></div>
                    <!-- Div for Filter Department-User selected -->
                    <div class="row my-2 d-none" id="user-task-table"></div>
                    <div class="row my-2 d-none" id="department-task-table"></div>
                    <!-- Div To display All Forms Kind (ADD or DELETE ) -->
                    <div class="row my-2 d-none" id="addTaskPageFormsDisplay"></div>
                    <div class="text-end my-4">
                        <button type="button" class="btn btn-success btn-outline-secondary text-white text-center" onclick="return window.location.reload();">REFRESH</button>
                    </div>
                </div>
                <!-- End Row id AddTaskPageContainerBtnClick -->
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
                        </div>

                    </div>
                </div>
                <!--container -->
                <div class="row g-0"><h3 class="text-center my-4">Add Meeting Form</h3> </div>
            </div>
            <!-- Col Container Page -->
        </div>

            <!-- Done Archive container -->
            <div class="col-lg-11 col-10 p-1 d-none border border-1" id="doneArchiveContainerDiv">
                <h3 class="text-center mb-3" id="doneArchiveH3">Done archive</h3>
                <!-- DIV ROW Total count in rapport with filter department or responsible -->
                <div class="row min-vh-100 vh-100 h-100 g-0 justify-content-between mb-4">
                    <!-- Total Btn -->
                    <div class="col-sm-1 ms-0">
                        <fieldset class="border border-1">
                            <legend class="float-none w-auto text-sm fs-6 fw-small text-uppercase">total</legend>
                            <p data-id="" class="text-center showTaskTotalParagraph gold" id="showTaskTotalParagraph"></p>
                        </fieldset>
                    </div>
                    <div class="col-sm-3 me-0">
                        <fieldset class="d-flex flex-wrap justify-content-around align-content-around border border-1">
                            <legend class="float-none w-auto text-sm fw-smaller fs-6 text-uppercase">filter</legend>

                            <!-- List of all departments doneArchive mx-2-->
                            <div class="dropdown mx-2 mb-2 departmentListFilterInDoneArchive">
                                <button class="btn btn-sm border border-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" style="text-decoration: none; color: white !important;">
                                    departments
                                </button>
                                <ul class="dropdown-menu list-unstyled doneArchiveDepartmentListFilter" id="doneArchiveDepartmentListFilter">
                                    <li><span class="loader text-center" id="loader-sm"></span></li>
                                </ul>
                            </div>

                            <!-- List of all responsibles done Archive -->
                            <div class="dropdown mx-2 mb-2 doneArchiveUserFilterDropdown">
                                <button class="btn btn-sm border border-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-autohide="true" style="text-decoration: none; color: white !important;">
                                    users
                                </button>
                                <ul class="dropdown-menu list-unstyled" id="doneArchiveUserFilterList">
                                    <li><span class="loader text-center" id="loader-sm"></span></li>
                                </ul>
                            </div>
                        </fieldset>
                        <!-- End Row Total And Filter Div DONE ARCHIVE -->
                    </div>

                    <!-- DONE ARCHIVE RESPONSE DIV -->
                    <div class="row  min-vh-100 vh-100 h-100 g-0 mb-4 d-none doneArchiveResponseDiv" id="doneArchiveResponseDiv"></div>
                </div>
            </div>
        </div>
    </div>
 <!-- End DIVs for differents menu items -->

<!-- Modal add Department by small caret click -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php Department::addDepartmentFormChoice();?>
            </div>

        </div>
    </div>
</div>


<?php $content = ob_get_clean(); ?>
<?php require_once DOCROOT .'/templates/layout.php';?>

