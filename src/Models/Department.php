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
        $stmt = "SELECT * FROm task_db.department WHERE libelle = '$libelle'";
        return StaticDb::getDb()->query($stmt, get_called_class());
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
     * @param int $departementId
     * @return array|false|mixed
     */
    public static function getAllUserInOneDepartment(int $departementId): mixed
    {
        $req = "SELECT * JOIN user u on d.department_id = u.department WHERE d.department_id = ?";
        return StaticDb::getDB()->prepare($req, [$departementId], get_called_class());
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