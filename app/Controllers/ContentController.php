<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Exceptions\ForbiddenException;
use App\Core\Utils\Acl;
use App\Models\Content;

class ContentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Acl::access(['user', 'user_vk'])) {
            throw new ForbiddenException();
        }
    }

    public function index()
    {
        $content['text'] ='Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veniam, inventore. Modi, odit necessitatibus qui at voluptate excepturi expedita! Nulla officia harum repudiandae impedit ratione reiciendis quisquam facilis magnam possimus officiis?';
        if (Acl::access(['user_vk'])) {
            $content['image'] = IMG . 'img.jpg';
        }
        $this->view->generate('content/content.phtml', 'template.phtml', [...$content]);
    }
}