<?php

namespace App\Core;

class Model
{
    private $entity;

    public function __construct($entity = null)
    {
        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }

}