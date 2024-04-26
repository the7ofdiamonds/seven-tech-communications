<?php

namespace SEVEN_TECH\Communications\Role;

use Exception;

class Role
{
    private $roles;

    public function __construct()
    {
        $this->roles = [
            [
                'name' => 'investor',
                'display_name' => 'Investor',
                'capabilities' => [],
                'order' => 0
            ],
            [
                'name' => 'founder',
                'display_name' => 'Founder',
                'capabilities' => [],
                'order' => 1
            ],
            [
                'name' => 'managing-member',
                'display_name' => 'Managing Member',
                'capabilities' => [],
                'order' => 2
            ],
            [
                'name' => 'freelancer',
                'display_name' => 'Freelancer',
                'capabilities' => [],
                'order' => 3
            ],
            [
                'name' => 'executive',
                'display_name' => 'Executive',
                'capabilities' => [],
                'order' => 4
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee',
                'capabilities' => [],
                'order' => 5
            ]
        ];
    }

    public function addRoles()
    {
        foreach ($this->roles as $role) {
            add_role(
                $role['name'],
                $role['display_name'],
                $role['capabilities']
            );
        }
    }

    public function getRoleNames()
    {
        $roleNames = [];

        foreach ($this->roles as $role) {
            $roleNames[] = $role['name'];
        };

        return $roleNames;
    }

    public function getRoleDisplayNames()
    {
        $roleDisplayNames = [];

        foreach ($this->roles as $role) {
            $roleDisplayNames[] = $role['display_name'];
        };

        return $roleDisplayNames;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getOrderedRoles($roles)
    {
        if (!is_array($roles)) {
            throw new Exception('Wrong roles format. Must be an array.', 400);
        }

        $order = [];

        foreach ($this->roles as $role) {
            $order[] = [$role['name'] => $role['order']];
        }

        uksort($roles, function ($a, $b) use ($order) {
            return $order[$a] <=> $order[$b];
        });

        return $roles;
    }

    public function getRoleSlug($name){
        $displayName = '';

        foreach ($this->roles as $role) {
            if ($role['name'] == $name) {
                $displayName = $role['display_name'];
                break;
            }
        }

        if ($displayName == '') {
            return '';
        }

        $post_types = get_post_types(['public' => true], 'objects');

        $slug = '';

        foreach ($post_types as $post_type) {
            if ($post_type->labels->singular_name == $displayName) {
                $slug = $post_type->rewrite['slug'];
                break;
            }
        }

        if ($slug == '') {
            return '';
        }

        return $slug;
    }

    public function getRoleLink($name, $nicename)
    {
        $slug = $this->getRoleSlug($name);

        if ($slug == '') {
            return '';
        }

        return "/{$slug}/{$nicename}";
    }
}
