<?php
use App\Models\Department;
use App\Models\Role;

ob_start();?>
<div class="container-fluid">

    <!-- Container for first buttons line row mt-4-->
    <div class="row justify-content-between mt-4">

        <!-- Left Buttons div -->
        <div class="col-sm-3 ">
            <!-- add department delete department-->
            <div class="row justify-content-around bg-body-tertiary shadow-lg rounded rounded-2 mx-2 mb-3 p-1">
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
            <div class="row justify-content-around bg-body-tertiary shadow-lg rounded rounded-2 mx-2 mb-3 p-2">
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
        <div class="col-sm-3">
            <!--filter for departments and responsibles-->
            <div class="d-flex ms-0 me-auto shadow-lg justify-content-around rounded rounded-2 mb-5 p-2">

                <!-- List of all departments -->
                <div class="dropdown mx-2">
                    <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        departments
                    </button>
                    <ul class="dropdown-menu">
                        <?php $dropdown_department = Department::readAll(); if($dropdown_department): foreach ($dropdown_department as $item): ?>
                            <li class="list-unstyled deptarment text-center" data-id="<?= $item->getDepartmentId()?>"><a class="dropdown-item" href="#" data-id="<?= $item->getDepartmentId()?>" ><?= $item->getLibelle()?></a></li>
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
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">loop foreach</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Centered Button -->
    <div class="row d-flex justify-content-center align-items-center my-4">
        <div class="col-sm-2 shadow-lg mb-5 p-1">
            <fieldset class="border border-2 p-2 fw-bold text-center text-uppercase">

                <legend  class="float-none w-auto">add task</legend>

                <div class="d-flex col  align-items-center justify-content-center">
                    <div>
                        <button type="button" id="add-user" class="add-user col btn btn-success btn-outline-light text-uppercase border-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

</div>
<?php $content = ob_get_clean(); ?>

<?php require_once DOCROOT .'/templates/layout.php';?>

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
                        <label for="role">User department</label>
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

