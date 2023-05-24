<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validators\ValidateForm;
use App\Models\User;

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
        header('Refresh: 3; URL=/auth/login');
        $this->view->generate('Auth/success.phtml');
    }

    public function logout()
    {
        User::logout();
        header('Location: /');
        exit;
    }
}