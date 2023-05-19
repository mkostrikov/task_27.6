<?php

namespace App\Models\Entities;

class User
{
    private $username;
    private $password;
    private $email;
    private $role;
    private $token;
    private $created;

    public function __construct($entity = null)
    {
        $this->username = $entity->username;
        $this->password = $entity->password;
        $this->email = $entity->email;
        $this->token = $entity->token;
        $this->created = \DateTime::createFromFormat('U', time());

        if (isset($entity->role)) {
            $this->role = $entity->role;
        } else {
            $this->role = 'user';
        }
    }
}