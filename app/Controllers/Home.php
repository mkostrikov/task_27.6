<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Data\Db\Db;
use App\Models\User;

class Home extends Controller
{
    public function index()
    {
        $this->view->generate('Home/home.phtml');
    }
}