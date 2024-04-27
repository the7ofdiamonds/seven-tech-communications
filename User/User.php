<?php

namespace SEVEN_TECH\Communications\User;

use SEVEN_TECH\Communications\Role\Role;

class User
{
    private $role;

    public function __construct()
    {
        $this->role = new Role;
    }

    public function getUser($id)
    {
        $user_data = get_userdata($id);

        if ($user_data == false) {
            return '';
        }

        $roles = $this->role->getOrderedRoles($user_data->roles);
        $roleLink = $this->role->getRoleLink($roles[0], $user_data->user_nicename);
        $avatar_url = get_avatar_url($id, ['size' => 384]);

        $user = array(
            'id' => $id,
            'full_name' => "{$user_data->first_name} {$user_data->last_name}",
            'email' => $user_data->user_email,
            'title' => $roles[0],
            'bio' => get_the_author_meta('description', $id),
            'user_url' => $roleLink,
            'avatar_url' => $avatar_url == false ? '' : $avatar_url,
        );

        return $user;
    }

    public function getUsers($args)
    {
        $users_data = get_users($args);

        if (!is_array($users_data)) {
            return '';
        }

        $users = [];

        foreach ($users_data as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $roles = $this->role->getOrderedRoles($user_data->roles);
            $roleLink = $this->role->getRoleLink($roles[0], $user_data->user_nicename);

            $users[] = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
                'email' => $user_data->user_email,
                'roles' => $roles,
                'user_url' => $roleLink,
                'avatar_url' => get_avatar_url($user_data->ID, ['size' => 384])
            );
        }

        return $users;
    }
}
