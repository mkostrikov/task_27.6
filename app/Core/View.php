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
}