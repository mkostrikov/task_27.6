<?php

namespace App\Core;

use App\Core\Utils\Csrf;

class View
{
    public function setVar(string $name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function generate($contentView, $vars = [], $templateView = 'template.phtml')
    {
        $csrf = Csrf::create();
        extract($vars);
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