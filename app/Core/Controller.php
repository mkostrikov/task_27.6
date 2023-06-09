<?php

namespace App\Core;

use App\Core\Utils\UserAuthService;

class Controller
{
    protected $view;
    protected $user;

    public function __construct()
    {
        $this->view = new View();
        $this->user = UserAuthService::getUserByAuthToken();
        if (!empty($this->user)) {
            UserAuthService::setLoginStatus($this->user);
        }
    }
}