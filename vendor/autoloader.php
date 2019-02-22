<?php

require_once  __DIR__ . '/ProjectFunctions/dump.php';

spl_autoload_register(function ($name) {
    $filePath = str_replace('\\', '/', $name);

    require_once __DIR__ . '/../' . $filePath . '.php';
});