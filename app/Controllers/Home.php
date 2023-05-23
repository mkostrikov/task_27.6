<?php

namespace App\Controllers;

use App\Core\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view->generate('Home/home.phtml');
    }
}