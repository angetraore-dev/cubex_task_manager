<?php

namespace App\Models;

class Archive
{
    protected $archive_id;
    protected $libelle;

    /**
     * @return int
     */
    public function getArchiveId():int
    {
        return $this->archive_id;
    }

    /**
     * @return string
     */
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     * @return Archive
     */
    public function setLibelle($libelle): static
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return array|false|mixed
     */
    public static function readAll():mixed
    {
        //$stmt = "SELECT * FROM archive JOIN archivetask a on archive.archive_id = a.archiveid";
        $stmt = "SELECT * FROM archive";
        return StaticDb::getDb()->query($stmt, get_called_class());
    }

    public static function returnIdByLibelle($libelle):mixed
    {
        $stmt = "SELECT * FROM archive WHERE libelle = ?";
        return StaticDb::getDb()->prepare($stmt, [$libelle], get_called_class());
    }

    public static function addArchiveForm():void
    {
        ?>
        <form class="row bg-body-tertiary text-dark rounded rounded-2 opacity-80 g-3 my-4 needs-validation" id="addArchiveForm" novalidate>
            <h3 class="my-3 fw-small fs-6 bg-dark text-white rounded rounded-2 text-center text-uppercase p-1 border border-1">add archive's Libelle Form</h3>

            <div class="col-md-6 mb-3 archive_libelle_div">
                <label for="archive_libelle">Archive Name</label>
                <input placeholder="poor task ... done good task archive ..." type="text" name="archive_libelle" id="archive_libelle" class="form-control bg-body-tertiary text-dark">
                <div class="invalid-feedback">
                    enter a libelle
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="col archive_libelle_select">
                    <label for="existing_archive">Or</label>
                    <select id="existing_archive" class="form-control bg-body-tertiary text-dark" name="existing_archive">
                        <option value="" selected>choose here</option>
                        <?php $allArchiveLibelle = Archive::readAll(); if ($allArchiveLibelle): foreach ($allArchiveLibelle as $item): ?>
                            <option value="<?= $item->getArchiveId()?>"><?= $item->getLibelle()?></option>
                        <?php endforeach; else: echo '<option value="">no archive record found Yep</option>'; endif;?>
                    </select>

                </div>
            </div>
            <input class="form-control" type="hidden" name="taskId">
            <input type="hidden" name="lastOpenedFunc">

            <div class="col-md-6 mb-3">
                <label for="taskTitle">Title Task</label>
                <input readonly="readonly" class="form-control bg-body-tertiary text-dark" type="text" id="taskTitle" name="taskTitle">
            </div>

            <div class="col-md-6 mb-3">
                <label for="obs">Observation</label>
                <input readonly="readonly" class="form-control bg-body-tertiary text-dark" type="text" id="obs" name="obs">
            </div>

            <div class="col mb-3">
                <label for="userFullname">Responsible</label>
                <input readonly="readonly" class="form-control bg-body-tertiary text-dark" type="text" id="userFullname" name="userFullname">
            </div>


            <div class="text-end mb-3">
                <button type="button" id="cancelFormDoneArchive" class="btn btn-sm btn-secondary cancelFormDoneArchive">Cancel</button>
                <button type="button" id="sendFormBtnDoneArchive" class="btn btn-sm btn-dark sendFormBtnDoneArchive" data-id="addArchiveForm_Archive_insert">confirm</button>
            </div>
        </form>

        <?php
    }

}