<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ArticlesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (User::getRole() === 'non_authorized') {
            throw new \Exception('<p>Доступ запрещен.<br><a href="/auth/login">Войти</a></p>');
        }
    }

    public function index()
    {
        $article = 'Article';
        $image = null;
        if  (User::getRole() === 'user_vk') {
            $image = 'http://' . HOST . '/assets/img/1.jpg';
        }
        $this->view->generate('articles/article.phtml', ['article' => $article, 'image' => $image]);
    }
}