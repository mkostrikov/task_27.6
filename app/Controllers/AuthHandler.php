<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Utils\Csrf;
use App\Core\Validators\ValidateForm;
use App\Models\User;

class AuthHandler extends Controller
{
    public function register()
    {
        if  (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['csrf'])
            && Csrf::validate($_POST['csrf'])
        ) {
            $errors = ValidateForm::register($_POST);

            if ($errors === null) {
                $this->view->generateJson(['error' => 'Ошибка, обновите страницу']);
            }

            if ($errors) {
                $this->view->generateJson(['errors' => $errors]);
            }

            $user = User::register($_POST);

            if (!empty($user)) {
                $this->view->generateJson(['register' => 'success']);
            } else {
                $this->view->generateJson(['error' => 'Ошибка при регистрации']);
            }
        } else {
            $this->view->generateJson(['error' => 'Invalid or missing CSRF token']);
        }
    }

    public function login()
    {
        if  (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['csrf'])
            && Csrf::validate($_POST['csrf'])
        ) {
            $userData = ValidateForm::login($_POST);

            if ($userData === null) {
                $this->view->generateJson(['error' => 'Ошибка, обновите страницу']);
            }

            $user = User::login($userData);

            if ($user === null) {
                $this->view->generateJson(['error' => 'Неверно указана почта или пароль']);
            }

            $this->view->generateJson(['login' => 'success']);

        } else {
            $this->view->generateJson(['error' => 'Invalid or missing CSRF token']);
        }
    }
}