<?php

namespace lib;

use lib\Route;

class Error
{
    //me estructura el error ni bien no encuentre la url, solo llamando al metodo de la clase 
    public function __construct()
    {
        return Route::redirect(Route::getPreviousUrl());
    }
}
