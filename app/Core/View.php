<?php

namespace App\Core;

use App\Core\Utils\Csrf;

class View
{
    public function generate($contentView, $templateView = 'template.phtml')
    {
        $csrf = Csrf::create();
        include_once LAYOUT . $templateView;
    }

    public function generateJson($data)
    {
        header('X-CSRF-TOKEN:' . Csrf::create());
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}