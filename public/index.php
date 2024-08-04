<?php
session_start();
use App\Config;
use App\Route;

//require_once '../config/config.php';
require_once '../vendor/autoload.php';
Config::conf();
Route::contentToRender();

