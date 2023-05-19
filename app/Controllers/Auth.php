<?php

namespace App\Controllers;

use App\Core\Controller;

class Auth extends Controller
{
    public function login()
    {
        $this->view->generate('Auth/login.phtml');
    }

    public function register()
    {
        $this->view->generate('Auth/reg.phtml');
    }

    public function success()
    {
        $this->view->generate('Auth/success.phtml');
    }

    public function logout()
    {
        $this->view->generate('Auth/logout.phtml');
    }
}