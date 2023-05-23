<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Utils\Csrf;
use App\Core\Validators\ValidateForm;
use App\Data\Db\Db;

class AuthHandler extends Controller
{
    public function register()
    {
        if  (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['csrf'])
            && Csrf::validate($_POST['csrf'])
            && isset($_POST['username'])
            && isset($_POST['email'])
            && isset($_POST['password'])
            && isset($_POST['password2'])
        ) {
            header('X-CSRF-TOKEN:' . Csrf::create());
            header('Content-Type: application/json');

            $errors = ValidateForm::register($_POST);

            if ($errors) {
                echo json_encode($errors);
                exit;
            }

            $userId = Db::create(
                'users',
                [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_ARGON2ID),
                    'token' => password_hash($_POST['email'], PASSWORD_ARGON2ID),
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                ]);
            echo json_encode(['id' => $userId]);
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([]);
            exit;
        }
    }
}