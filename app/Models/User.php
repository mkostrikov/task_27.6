<?php

namespace App\Models;

use App\Core\Utils\Checker;
use App\Data\Db\Db;

class User extends \RedBean_SimpleModel
{
    public static function getUserByParam(string $param, string $value): ?User
    {
        $user = \R::findOne('user', " $param = ? ", [$value]);
        if (!empty($user)) {
            return $user->box();
        }
        return null;
    }

    public static function register($userData): ?User
    {
        $username = $userData['username'] ?? null;
        $vk = $userData['vk_id'] ?? null;
        $password = $userData['password'] ?? null;
        if (!empty($password)) {
            $password = password_hash($userData['password'], PASSWORD_ARGON2ID);
        }
        $email = $userData['email'] ?? null;
        $token = null;
        if (!empty($email)) {
            $token = self::salt($email);
        }
        $userDb = [
            'username' => $username,
            'vk_id' => $vk,
            'password' => $password,
            'token' => $token,
            'created' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];
        $id = Db::create('user', $userDb);
        if (empty($id)) {
            return null;
        }
        return Db::getById('user', $id)->box();
    }

    public static function login(array $data): ?User
    {
        $token = self::salt($data['email']);
        $user = self::getUserByParam('token', $token);

        if (empty($user)) {
            return null;
        }

        $passwordHash = $user->password;

        if (!password_verify(Checker::checkInput($data['password']), $passwordHash)) {
            return null;
        }

        $user->setLoginStatus();

        if (isset($data['remember'])) {
            $user->setUserCookie();
        }
        return $user;
    }

    public static function vkAuth(array $userData)
    {
        $user = self::getUserByParam('vk_id', $userData['vk_id']);
        if (empty($user)) {
            $user = User::register($userData);
        }

        $userBean = $user->unbox();
        $id = Db::update($userBean, $userData);

        $updatedUser = self::getUserByParam('id', $id);

        $updatedUser->setLoginStatus();
    }

    public function setLoginStatus(): void
    {
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $this->username;
        $_SESSION['id'] = $this->id;
        $_SESSION['vk_id'] = $this->vk_id;
//        $_SESSION['token'] = $this->id;
    }

    public function setUserCookie(): void
    {
        setcookie(
            'token',
            $_SESSION['token'],
            [
                'expires' => time() + 60*60*24*30,
                'path' => '/',
                'SameSite' => 'Lax'
            ]);
    }

    public static function logout()
    {
        $_SESSION = [];
        setcookie('token', '', -1, '/', '', false, true);
    }

    public static function isLogged(): bool
    {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            return true;
        }
        return false;
    }

    public static function salt(string $data)
    {
        return md5(Checker::checkInput($data) . SECRET_WORD);
    }

    public function getRole(): string
    {
        $role = 'non authorized';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $role = 'user';
            if (isset($_SESSION['vk_id'])) {
                $role = 'user_vk';
            }
        }
        return $role;
    }

}