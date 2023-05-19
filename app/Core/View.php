<?php

namespace App\Core;

class View
{
    public function generate($contentView, $templateView = 'template.phtml', $data = null)
    {
        include_once LAYOUT . $templateView;
    }
}