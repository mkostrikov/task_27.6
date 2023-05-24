<?php

namespace App\Models;

use App\Core\Utils\Checker;
use App\Data\Db\Db;

class User extends \RedBean_SimpleModel
{
    public static function getUserByToken(string $token): ?User
    {
        $user = \R::findOne('user', ' token = ? ', [$token]);
        if (!empty($user)) {
            return $user->box();
        }
        return null;
    }

    public static function register(array $data): ?User
    {
        $userData = [
            'username' => Checker::checkInput($data['username']),
            'vk_id' => null,
            'password' => password_hash(Checker::checkInput($data['password']), PASSWORD_ARGON2ID),
            'token' => Checker::salt($data['email']),
            'created' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];
        $id = Db::create('user', $userData);
        if (empty($id)) {
            return null;
        }
        return Db::getById('user', $id)->box();
    }

    public static function login(array $data): ?User
    {
        $token = Checker::salt($data['email']);
        $user = self::getUserByToken($token);

        if (empty($user)) {
            return null;
        }

        $passwordHash = $user->password;

        if (!password_verify(Checker::checkInput($data['password']), $passwordHash)) {
            return null;
        }

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user->username;
        $_SESSION['token'] = $user->token;
        $_SESSION['id'] = $user->id;
        if (isset($data['remember'])) {
            setcookie(
                'token',
                $_SESSION['token'],
                [
                    'expires' => time() + 60*60*24*30,
                    'path' => '/',
                    'SameSite' => 'Lax'
                ]);
        }
        return $user;
    }

    public static function logout()
    {
        setcookie('token', '', -1, '/', '', false, true);
    }
}