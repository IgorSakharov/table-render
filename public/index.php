<?php

use Src\Kernel;

require_once './../vendor/autoloader.php';

error_reporting(0);

$kernel = new Kernel();
$kernel->handel();
$kernel->send();
