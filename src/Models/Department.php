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

    //private Database $database;
    //    function __construct()
    //    {
    //        $this->database = new Database();
    //    }

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
     * @return void
     */
    function delGrpedForm():void
    {
        $list = self::readAll(); if ($list):
        ?>

        <form class="row g-3 needs-validation delgped-dep" novalidate>
            <?php foreach ($list as $item): ?>
                <div class="input-group <?=$item->getDepartmentId()?>">
                    <input class="form-check-input" type="checkbox" id="<?='list_'.$item->getDepartmentId()?>" name="<?='list_'.$item->getDepartmentId()?>" value="<?=$item->getDepartmentId()?>">
                    <label class="form-check-label mx-1" for="<?='list_'.$item->getDepartmentId()?>"><?=$item->getLibelle()?></label>
                </div>
            <?php endforeach;?>
            <div class="invalid-feedback">You must select at least one item</div>
            <button type="button" class="btn btn-secondary cancelDelGpedDep" data-bs-dismiss="modal">cancel</button>
            <button type="button" id="delGpedDep" name="delGpedDep" class="btn btn-primary">delete</button>
        </form>
        <?php else: echo "<p class='text-muted text-center'>No data found</p>"; endif;
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

}