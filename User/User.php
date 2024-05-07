<?php

namespace SEVEN_TECH\Communications\User;

use Exception;

use  WP_Query;

use SEVEN_TECH\Communications\Roles\Roles;

class User
{
    private $role;

    public function __construct()
    {
        $this->role = new Roles;
    }

    public function getUser($id)
    {
        $user_data = get_userdata($id);

        if ($user_data == false) {
            return '';
        }

        $ordered_roles = $this->role->getOrderedRoles($user_data->roles);
        $roles = $this->role->getRoleDisplayNames($ordered_roles);
        $roleLink = $this->role->getRoleLink($ordered_roles[0], $user_data->user_nicename);
        $avatar_url = get_avatar_url($id, ['size' => 384]);

        $user = array(
            'id' => $id,
            'full_name' => "{$user_data->first_name} {$user_data->last_name}",
            'email' => $user_data->user_email,
            'title' => $roles,
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
            $user_data = $this->getUser($user->ID);

            if ($user_data == '') {
                continue;
            }

            $users[] = $user_data;
        }

        return $users;
    }

    public function userHasPostsOfType($postType, $nicename)
    {
        try {
            $user = get_user_by('slug', $nicename);

            if ($user == false) {
                return false;
            }

            $post_type = str_replace('-', '_', $postType);

            $args = array(
                'post_type' => $post_type,
                'author' => $user->ID,
                'posts_per_page' => -1,
            );

            $query = new WP_Query($args);

            $projects = $query->posts;

            if (empty($projects)) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function userHasAmountPosts($id, $post_type)
    {
        $count_posts = count_user_posts($id, $post_type);

        return $count_posts;
    }
}
