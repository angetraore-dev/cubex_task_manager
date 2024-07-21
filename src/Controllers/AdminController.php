<?php

namespace App\Controllers;

class AdminController
{
    public function index():void
    {
        $title = 'Admin panel';
        require_once DOCROOT .'/templates/admin/index.php';
    }

}