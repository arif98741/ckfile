<?php
include "App/System.php";
include 'App/Opacity.php';
use App\System;
use App\Opacity;


$system = new System('file');
new Opacity($system);
