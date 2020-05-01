<?php
include "App/System.php";

use App\System;

$system = new System('file');
echo '<pre>';
print_r($system->getDirList('dir1'));
exit;
