<?php

namespace App\Core;

use App\Models\User;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}