<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Utils\Csrf;
use App\Models\User;
use App\Core\Handlers;

class Auth extends Controller
{
    public function login()
    {
        if  ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (Csrf::validate($_POST)) {
                $this->view->generateJson(Handlers\AuthHandler::login($_POST));
            } else {
                $this->view->generateJson(['error' => 'Invalid or missing CSRF token']);
            }
        }
            $this->view->generate('Auth/login.phtml');
    }

    public function register()
    {
        if  ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (Csrf::validate($_POST)) {
                $this->view->generateJson(Handlers\AuthHandler::register($_POST));
            } else {
                $this->view->generateJson(['error' => 'Invalid or missing CSRF token']);
            }
        }
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