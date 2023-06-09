<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function error404()
    {
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        $this->view->generate('errors/404.phtml', 'error.phtml');
    }

    public function error403()
    {
        header('HTTP/1.1 403 Forbidden');
        header('Status: 403 Forbidden');
        $this->view->generate('errors/403.phtml', 'error.phtml');
    }
}