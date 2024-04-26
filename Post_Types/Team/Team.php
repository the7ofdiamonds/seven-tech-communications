<?php

namespace SEVEN_TECH\Communications\Post_Types\Team;

use SEVEN_TECH\Communications\Role\Role;

class Team
{
    private $role;
    private $roleNames;
    private $post_type;

    public function __construct()
    {
        $this->role = new role;
        $this->roleNames = (new Role)->getRoleNames();
        $this->post_type = 'team';
    }

    function getTeam()
    {
        $args = [
            'role__in' => $this->roleNames
        ];
        $users = get_users($args);

        if (!is_array($users)) {
            return '';
        }

        $team = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $roles = $this->role->getOrderedRoles($user_data->roles);
            $roleLink = $this->role->getRoleLink($roles[0], $user_data->user_nicename);

            $teamMember = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
                'email' => $user_data->user_email,
                'roles' => $roles,
                'user_url' => $roleLink,
                'avatar_url' => get_avatar_url($user_data->ID, ['size' => 384])
            );

            $team[] = $teamMember;
        }

        return $team;
    }

    function getTeamMember($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $user = get_user_by('ID', $post->post_author);

        if ($user == false) {
            return '';
        }

        $user_data = get_userdata($user->ID);

        if ($user_data == false) {
            return '';
        }

        $id = $user_data->ID;
        $roles = $this->role->getOrderedRoles($user_data->roles);
        $roleLink = $this->role->getRoleLink($roles[0], $user_data->user_nicename);
        $avatar_url = get_avatar_url($id, ['size' => 384]);

        $teamMember = array(
            'id' => $id,
            'full_name' => $post->post_title,
            'email' => $user_data->user_email,
            'title' => $roles[0],
            'bio' => get_the_author_meta('description', $id),
            'user_url' => $roleLink,
            'avatar_url' => $avatar_url == false ? '' : $avatar_url,
        );

        return $teamMember;
    }
}
