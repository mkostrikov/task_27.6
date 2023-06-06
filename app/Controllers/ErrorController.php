<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function error(\Exception $e)
    {
        $this->view->generate('', 'error.phtml', ['error' => $e->getMessage()]);
    }
}