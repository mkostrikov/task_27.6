<?php

namespace App\Controllers;

use App\Core\Controller;

class Error extends Controller
{
    public function index()
    {
        $this->view->generate('error.phtml');
    }
}