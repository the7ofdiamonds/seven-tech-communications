<?php

namespace SEVEN_TECH\Communications\Post_Types\Founders;

use Exception;

use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
// use SEVEN_TECH\Communications\Taxonomies\Frameworks;
// use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Founders
{
    private $post_type;
    private $role;
    private $user;
    private $resume;
    private $taxonomies;
    private $skills;
    private $frameworks;
    private $technologies;

    public function __construct()
    {
        $this->role = 'founder';
        $this->post_type = 'founders';
        $this->user = new User;
        $this->resume = new Resume;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        // $this->frameworks = new Frameworks;
        // $this->technologies = new Technologies;
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

        $founder['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $founder['skills'] = $this->skills->getPostSkills($post->ID);
        // $founder['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        // $founder['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $founder['social_networks'] = $this->getFounderSocialNetworks($post->ID);
        $founder['founder_resume'] = $this->resume->getResume($id);

        return $founder;
    }
}
