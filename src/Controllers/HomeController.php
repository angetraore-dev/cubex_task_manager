<?php

namespace App\Controllers;

class HomeController
{
    public function index():void
    {
        $title = 'Homepage';
        require_once DOCROOT .'/templates/homepage/index.php';
    }

}