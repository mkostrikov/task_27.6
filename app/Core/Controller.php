<?php

namespace App\Core;

class Controller
{
    protected $view;

    public function __construct($model = null)
    {
        $this->view = new View();
    }
}