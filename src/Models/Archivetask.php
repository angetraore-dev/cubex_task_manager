<?php

namespace App\Models;

class Archivetask
{
    protected $archivetask_id;
    protected $taskid;
    protected $observation;
    protected $archiveid;

    /**
     * @return int
     */
    public function getArchivetaskId()
    {
        return $this->archivetask_id;
    }

    /**
     * @return mixed
     */
    public function getTaskid()
    {
        return $this->taskid;
    }

    /**
     * @param mixed $taskid
     * @return Archivetask
     */
    public function setTaskid($taskid)
    {
        $this->taskid = $taskid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param mixed $observation
     * @return Archivetask
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArchiveid()
    {
        return $this->archiveid;
    }

    /**
     * @param mixed $archiveid
     * @return Archivetask
     */
    public function setArchiveid($archiveid)
    {
        $this->archiveid = $archiveid;
        return $this;
    }



}