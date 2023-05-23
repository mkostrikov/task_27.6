<?php

namespace App\Controllers;

use App\Core\Controller;

class Error extends Controller
{
    public function error404()
    {
        $this->view->generate('Error/404.phtml', 'error.phtml');
    }
}