<?php

namespace App\Models;

use App\Core\Utils\Checker;
use App\Core\Utils\UserAuthService;
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
        $email = self::salt($userData['email']) ?? null;
        $token = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $accessToken = $userData['access_token'] ?? null;

        $userDb = [
            'username' => $username,
            'vk_id' => $vk,
            'password' => $password,
            'email' => $email,
            'token' => $token,
            'access_token' => $accessToken,
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
        $email = self::salt($data['email']);
        $user = self::getUserByParam('email', $email);

        if (empty($user)) {
            return null;
        }

        $passwordHash = $user->password;

        if (!password_verify(Checker::checkInput($data['password']), $passwordHash)) {
            return null;
        }

        UserAuthService::setLoginStatus($user);

        if (isset($data['remember'])) {
            UserAuthService::setUserCookie($user);
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

        UserAuthService::setLoginStatus($updatedUser);

        UserAuthService::setUserCookie($updatedUser);
    }

    public static function logout()
    {
        $_SESSION = [];
        setcookie('token', '', -1, '/', '', false, true);
    }

    public static function salt(string $data)
    {
        return md5(Checker::checkInput($data) . SECRET_WORD);
    }

    public static function getRole(): string
    {
        $role = 'non_authorized';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $role = 'user';
            if (isset($_SESSION['vk_id'])) {
                $role = 'user_vk';
            }
        }
        return $role;
    }

    public function refreshToken()
    {
        $token = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $userBean = $this->unbox();
        Db::update($userBean, ['token' => $token]);
    }

}