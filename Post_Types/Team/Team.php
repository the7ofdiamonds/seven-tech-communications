<?php

namespace SEVEN_TECH\Communications\Post_Types\Team;

use SEVEN_TECH\Communications\Role\Role;

class Team
{
    private $roles;
    private $post_type;

    public function __construct()
    {
        $this->roles = (new Role)->getRoles();
        $this->post_type = 'team';
    }

    function getTeam()
    {
        $args = [
            'role__in' => $this->roles
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

            $teamMember = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
                'email' => $user_data->user_email,
                'role' => $user_data->roles,
                'user_url' => "/founders/{$user_data->user_nicename}",
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
        $avatar_url = get_avatar_url($id, ['size' => 384]);

        $teamMember = array(
            'id' => $id,
            'fullName' => $post->post_title,
            'email' => $user_data->user_email,
            'title' => 'founder',
            'greeting' => get_the_author_meta('description', $id),
            'author_url' => "/founders/{$user_data->user_nicename}",
            'avatar_url' => $avatar_url == false ? '' : $avatar_url,
        );

        return $teamMember;
    }
}
