<?php

namespace SEVEN_TECH\Communications\Role;

class Role
{
    private $roles;

    public function __construct()
    {
        $this->roles = [
            'administrator',
            'founder'
        ];
    }

    public function getRoles()
    {
        return $this->roles;
    }
}
