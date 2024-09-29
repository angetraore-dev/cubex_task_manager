<?php

namespace App\Models;

use PDO;

//use \AllowDynamicProperties;

//#[AllowDynamicProperties]
class Department
{
    protected $department_id;
    protected $libelle;
    protected $color;

    /**
     * @return mixed
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     * @return Department
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @param mixed $color
     * @return Department
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return array|false|mixed
     */
    public static function readAll(): mixed
    {
        return StaticDb::getDB()->query("SELECT * FROM department", get_called_class());
    }

    /**
     * @return mixed
     */
    public static function departmentJoinHeader():mixed
    {
        $stmt = "SELECT * FROM department";
        return StaticDb::getDb()->query($stmt, get_called_class());
    }

    /**
     * @param $libelle
     * @return array|false|mixed
     */
    public static function checkIfExist($libelle):mixed
    {
        $stmt = "SELECT * FROM task_db.department WHERE libelle = '$libelle'";
        return StaticDb::getDb()->query($stmt, get_called_class());
    }

    /**
     * @param int $departementId
     * @return array|false|mixed
     */
    public static function getAllUserInOneDepartment(int $departementId): mixed
    {
        $req = "SELECT * JOIN user u on d.department_id = u.department WHERE d.department_id = ?";
        return StaticDb::getDB()->prepare($req, [$departementId], get_called_class());
    }

    /**
     * List Of Department in Department dropdown Filter
     * @return void
     */
    public function departmentInDropdownFilter():void
    {
        $dropdown_department = Department::readAll(); if($dropdown_department): foreach ($dropdown_department as $item):
        ?>
        <li class="list-unstyled departmentList" data-id="<?= $item->getDepartmentId()?>">
            <a class="dropdown-item" href="#">
             <span class="d-block">
               <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$item->getColor()?>"></rect></svg>
                 <?= $item->getLibelle()?>
             </span>
            </a>
        </li>
    <?php endforeach; else:
        echo '<li class="text-center text-muted"><span> No records found</span></li>';
    endif;
    }

    /**
     * List of department display in department dropdown filter in Done Archive
     * @return void
     */
    public function departmentListInDoneArchive():void
    {
        $deps = Department::readAll(); if ($deps): foreach ($deps as $item):
        ?>
        <li class="list-unstyled departmentListArchivedFilter" data-id="<?= 'Task-displayDepBothCheckedTaskTableDoneArchived-'.$item->getDepartmentId()?>">
            <a class="dropdown-item" href="#">
                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$item->getColor()?>"></rect></svg>
                <?= $item->getLibelle()?>
            </a>
        </li>
    <?php endforeach; else:
        echo '<li class="text-center text-muted"><span> No records found</span></li>';
    endif;
    }

    /**
     * Display Department List in Task Page
     * @param $department
     * @return void
     */
    public function displayDepartmentslist($department):void
    {
        if ($department): ?>
            <?php foreach ($department as $item): if ($item->getLibelle() == 'CEO' || $item->getLibelle() =='ceo'):?>
                <!-- CEO DEPARTMENT -->
                <button id="<?=$item->getDepartmentId()?>" data-id="taskMenu" class="btn btn-lg taskMenu row p-0 g-0 mb-2 text-center text-uppercase rounded rounded-0" type="button" style="border: <?=$item->getColor()?> 1px solid !important; font-weight: lighter !important; text-decoration: none; color: #FFFFFF;">
                    <?=$item->getLibelle()?>
                </button>
            <?php endif;endforeach; ?>

            <!-- OTHERS DEPARTMENTS -->
            <div class="d-flex flex-wrap justify-content-between g-0 p-0">
                <?php foreach ($department as $item2): if ($item2->getLibelle() != 'ceo'): ?>
                    <div id="<?=$item2->getDepartmentId()?>" class="col-sm-3 col-3 col-lg-3 m-1 mb-2 text-center text-uppercase" style="border: <?=$item2->getColor()?> 1px solid !important;">
                        <?=$item2->getLibelle()?>
                    </div>
                <?php endif; endforeach;?>
            </div>

        <?php else: echo "<p class='text-muted text-center'>nothing to display- Tell to admin for create department</p>"; endif;
    }

    /**
     * @return void
     */
    public static function addDepartmentFormChoice()
    {
        ?>
        <form class="row col-md-8 mx-auto bg-body-tertiary text-dark rounded rounded-2 opacity-80 g-3 my-4 needs-validation" id="departmentFormChoice" novalidate>
            <h3 class="my-3 fw-small fs-6 bg-dark text-white rounded rounded-2 text-center text-uppercase p-1 border border-1">add department Form</h3>

            <div class="col-md-12 mb-3" id="Choices">
                <label for="department_choice">Department name</label>
                <select class="form-select" name="department_choice" id="department_choice">
                    <option class="form-control" value="">-->Select<--</option>
                    <option class="form-control" value="ceo_#FFFFFF">ceo</option>
                    <option class="form-control" value="pmo_#FF0000">pmo</option>
                    <option class="form-control" value="operations_#DA7843">operations</option>
                    <option class="form-control" value="finance_#4FAD5B">finance</option>
                    <option class="form-control" value="shared services_#4FADEA">shared services</option>
                    <option class="form-control" value="strategy_#FFFF55">strategy</option>
                    <option class="form-control" value="marketing_#1431F5">marketing</option>
                    <option class="form-control" value="creative_#68349A">creative</option>
                    <option class="form-control" value="procurement_#8E2966">procurement</option>
                    <option class="form-control" value="factory_#AEAEAE">factory</option>

                </select>
            </div>

            <div class="d-none" id="result">
                <div class="col-md-6 mb-3">
                    <label for="department_libelle">Department name</label>
                    <input type="text" name="department_libelle" id="department_libelle" class="form-control bg-body-tertiary text-dark" required>
                    <div class="invalid-feedback">
                        enter a department
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="department_color">Department color</label><br>
                    <input type="color" name="department_color" id="department_color" value="#FFFF55" class="form-control-color bg-body-tertiary text-dark" required>
                    <div class="invalid-feedback">
                        enter a department
                    </div>
                </div>

            </div>

            <div class="text-end mb-3">
                <!--<button type="button" class="btn btn-sm btn-secondary cancelForm">Cancel</button>-->
                <button type="button" class="btn btn-sm btn-secondary cancelForm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-dark sendFormBtn" data-id="departmentFormChoice_department_insert">create</button>
            </div>
        </form>

        <script type="text/javascript">
            $(document).ready(function (){
                $('#department_choice').change(function (){
                    let value = $(this).val()
                    let data = value.split("_")
                    $('#department_libelle').val(data[0])
                    $('#department_color').val(data[1])
                    $("#result").removeClass('d-none').fadeIn()
                })
            })
        </script>
        <?php
    }

    /**
     * @param $task
     * @return void
     */
    public static function buttonAddDepartment($task):void
    {
        //var_dump($task);
        ?>
            <div class="d-flex flex-wrap">
                <!--id="callDepartmentChoiceForm" data-id="department_addDepartmentFormChoice"-->
                <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" class="btn border-0 align-self-start" style="color: white !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"></path>
                    </svg>
                </button>

                <div class="align-self-center justify-content-between">
                    <?php $departments = Department::readAll(); foreach ($departments as $department): if ($department->getColor() == $task->color): ?>
                        <svg style="background-color: <?= $task->color?>" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?=$task->color?>" class="bi bi-square me-1" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        </svg>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?=$department->getColor()?>" class="bi bi-square me-1" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        </svg>

                    <?php endif; endforeach;?>
                </div>
            </div>
        <!-- Modal is in admin index view-->
        <?php
    }

    /**
     * @return void
     */
    public function delDepartmentForm():void
    {
        $list = self::readAll();
        if ($list):
        ?>
        <!--delgped-dep-->
        <form class="row col-md-8 mx-auto bg-body-tertiary text-dark rounded rounded-2 opacity-80 g-3 my-4 needs-validation" id="deleteGroupedDepartmentForm" novalidate>
            <h3 class="my-3 fw-small fs-6 bg-dark text-white rounded rounded-2 text-center text-uppercase p-1 border border-1">Delete Multiple departments Form</h3>

            <?php foreach ($list as $item): ?>
                <div class="input-group <?=$item->getDepartmentId()?>">
                    <input class="form-check-input" type="checkbox" id="<?='list_'.$item->getDepartmentId()?>" name="<?='list_'.$item->getDepartmentId()?>" value="<?=$item->getDepartmentId()?>">
                    <label class="form-check-label mx-1" for="<?='list_'.$item->getDepartmentId()?>"><?=$item->getLibelle()?></label>
                </div>
            <?php endforeach;?>
            <div class="invalid-feedback">You must select at least one item</div>
            <!--cancelDelGpedDep-->
            <div class="text-end mb-3">
                <button type="button" class="btn btn-secondary cancelForm">cancel</button>
                <button type="button" class="btn btn-primary sendFormBtn" data-id="deleteGroupedDepartmentForm_department_delete">delete</button>
            </div>
        </form>
    <?php
        else: echo "<p class='text-muted text-center'>No data found</p>";
        endif;
    }

    //good
    public function addDepartmentForm():void
    {
        ?>
        <form class="row col-md-8 mx-auto bg-body-tertiary text-dark rounded rounded-2 opacity-80 g-3 my-4 needs-validation" id="departmentForm" novalidate>
            <h3 class="my-3 fw-small fs-6 bg-dark text-white rounded rounded-2 text-center text-uppercase p-1 border border-1">add department Form</h3>


            <div class="col-md-6 mb-3">
                <label for="department_libelle">Department name</label>
                <input type="text" name="department_libelle" id="department_libelle" class="form-control bg-body-tertiary text-dark" required>
                <div class="invalid-feedback">
                    enter a department
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="department_color">Department color</label><br>
                <input type="color" name="department_color" id="department_color" value="#FFFF55" class="form-control-color bg-body-tertiary text-dark" required>
                <div class="invalid-feedback">
                    enter a department
                </div>
            </div>

            <div class="text-end mb-3">
                <button type="button" class="btn btn-sm btn-secondary cancelForm">Cancel</button>
                <button type="button" class="btn btn-sm btn-dark sendFormBtn" data-id="departmentForm_department_insert">create</button>
            </div>
        </form>
        <?php
    }

}