<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Handlers\VkAuthHandler;
use App\Core\Utils\Csrf;
use App\Models\User;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class VkAuthController extends Controller
{
    public function index()
    {
        if (!($_SERVER['REQUEST_METHOD'] === 'POST' && Csrf::validate($_POST))) {
            throw new \Exception('Invalid or missing CSRF token');
        }
        $oauth = new VKOAuth();
        $display = VKOAuthDisplay::PAGE;
        $scope = [VKOAuthUserScope::OFFLINE, VKOAuthUserScope::EMAIL];
        $browserUrl = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, CLIENT_ID, REDIRECT_URI, $display, $scope);
        header('Location: ' . $browserUrl);
    }

    public function oauth()
    {
        $oauth = new VKOAuth();
        $code = htmlspecialchars($_GET['code']);
        $response = $oauth->getAccessToken(CLIENT_ID, CLIENT_SECRET, REDIRECT_URI, $code);
        $userData = VkAuthHandler::getUserData($response);
        User::vkAuth($userData);
        header('Location: /dashboard');
    }

}