<?php

function dd($value, ...$values) {
    var_dump($value);

    if ($values) {
        foreach ($values as $val) {
            var_dump($val);
        }
    }

    die();
}

function dump($value, ...$values) {
    var_dump();

    var_dump($value);

    if ($values) {
        foreach ($values as $val) {
            var_dump($val);
        }
    }
}