<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('activeLink')) {
    function activeLink($name, $active = 'active')
    {
        return Route::is($name) ? $active : '';
    }
}
