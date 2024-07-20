<?php

namespace App\Controllers;

class DashboardController
{
    /**
     * @return void
     */
    public function index():void
    {
        $title = 'Dashboard';
        require DOCROOT .'/templates/dashboard/index.php';
    }

}