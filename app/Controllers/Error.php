<?php

namespace App\Controllers;

use App\Core\Controller;

class Error extends Controller
{
    public function error(\Exception $e)
    {
        $this->view->generate('Error/error.phtml', 'error.phtml', ['error' => $e->getMessage()]);
    }
}