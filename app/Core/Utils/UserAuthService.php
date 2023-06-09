<?php

namespace App\Core\Utils;

use App\Models\User;

class UserAuthService
{
    private static function createAuthToken(User $user): string
    {
        return $user->id . ':' . $user->token;
    }

    public static function getUserByAuthToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token);
        $user = User::getUserByParam('id', $userId);

        if ($user === null) {
            return null;
        }

        if ($user->token !== $authToken) {
            return null;
        }
        return $user;
    }

    public static function setUserCookie(User $user): void
    {
        $user->refreshToken();
        $authToken = self::createAuthToken($user);
        setcookie(
            'token',
            $authToken,
            [
                'expires' => time() + 60*60*24*30,
                'path' => '/',
                'SameSite' => 'Lax'
            ]);
    }

    public static function setLoginStatus(User $user): void
    {
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'user';
        $_SESSION['username'] = $user->username;
        $_SESSION['id'] = $user->id;
        $_SESSION['vk_id'] = $user->vk_id;
        if (!empty($_SESSION['vk_id'])) {
            $_SESSION['role'] = 'user_vk';
        }
        $_SESSION['token'] = $user->token;
        $_SESSION['access_token'] = $user->access_token;
    }
}