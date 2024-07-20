<?php

namespace App\Controllers;

class DashboardController
{
    public function index():void
    {
        $title = 'Dashboard';
        require DOCROOT .'/templates/dashboard/index.php';
    }

}