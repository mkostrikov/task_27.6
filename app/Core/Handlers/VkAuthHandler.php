<?php

namespace App\Core\Handlers;

use VK\Client\VKApiClient;

class VkAuthHandler
{
    public static function getUserData($data): array
    {
        $accessToken = $data['access_token'];
        $userVkId = $data['user_id'];
        $email = null;
        if (!empty($data['email'])) {
            $email = $data['email'];
        }
        $vk = new VKApiClient('5.131');
        $response = $vk->users()->get($accessToken, [
            'user_ids' => [$userVkId],
            'fields' => ['first_name,last_name']
        ]);
        $username = $response[0]['first_name'] . ' ' . $response[0]['last_name'];
        return ['username' => $username, 'email' => $email, 'vk_id' => $userVkId];
    }
}