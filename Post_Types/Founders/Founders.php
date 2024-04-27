<?php

namespace SEVEN_TECH\Communications\Post_Types\Founders;

use Exception;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\User\User;

class Founders
{
    private $post_type;
    private $role;
    private $user;
    private $resume;

    public function __construct()
    {
        $this->role = 'founder';
        $this->post_type = 'founders';
        $this->user = new User;
        $this->resume = new Resume;
    }

    function getFoundersList()
    {
        $args = ['role__in' => [$this->role]];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no founders at this time.';
        }

        $founders = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $founder = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
            );

            $founders[] = $founder;
        }

        return $founders;
    }

    function getFounders()
    {
        $args = [
            'role__in' => [$this->role]
        ];

        $founders = $this->user->getUsers($args);

        if (!is_array($founders)) {
            return '';
        }

        return $founders;
    }

    function getFounderSkills($post_id)
    {
        if (empty($post_id)) {
            throw new Exception('Post ID is required to get skills.', 400);
        }

        $taxonomies = get_post_taxonomies($post_id);

        if (!is_array($taxonomies)) {
            return '';
        }

        $skills = [];

        foreach ($taxonomies as $taxonomy) {
            $terms = get_the_terms($post_id, $taxonomy);

            if (!is_array($terms) || $terms == false || is_wp_error($terms)) {
                continue;
            }

            foreach ($terms as $term) {
                $skills[] = $term;
            }
        }

        return $skills;
    }

    function getFounderSocialNetworks($post_id)
    {
        $github_link = get_post_meta($post_id, 'github_link', true);
        $linkedin_link = get_post_meta($post_id, 'linkedin_link', true);
        $facebook_link = get_post_meta($post_id, 'facebook_link', true);
        $instagram_link = get_post_meta($post_id, 'instagram_link', true);
        $x_link = get_post_meta($post_id, 'x_link', true);
        $hacker_rank_link = get_post_meta($post_id, 'hacker_rank_link', true);

        $social_networks = [
            [
                'name' => 'GitHub',
                'icon' => 'github',
                'link' => $github_link
            ],
            [
                'name' => 'LinkedIn',
                'icon' => 'linkedin',
                'link' => $linkedin_link
            ],
            [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'link' => $facebook_link
            ],
            [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'link' => $instagram_link
            ],
            [
                'name' => 'X',
                'icon' => 'x-twitter',
                'link' => $x_link
            ],
            [
                'name' => 'Hacker Rank',
                'icon' => 'hackerrank',
                'link' => $hacker_rank_link
            ],
        ];

        return $social_networks;
    }

    function getFounder($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $founder = $this->user->getUser($id);

        if (!is_array($founder)) {
            return '';
        }

        $founder['skills'] = $this->getFounderSkills($post->ID);
        $founder['social_networks'] = $this->getFounderSocialNetworks($post->ID);
        $founder['founder_resume'] = $this->resume->getResume($id);

        return $founder;
    }
}
