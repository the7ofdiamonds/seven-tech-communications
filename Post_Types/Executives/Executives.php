<?php

namespace SEVEN_TECH\Communications\Post_Types\Executives;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Executives
{
    private $post_type;
    private $role;
    private $user;
    private $resume;
    private $taxonomies;
    private $skills;
    private $frameworks;
    private $technologies;
    private $post_types;
    private $social_networks;

    public function __construct()
    {
        $this->role = 'executive';
        $this->post_type = 'executives';
        
        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
        $this->resume = new Resume;
    }

    function getExecutivesList()
    {
        $args = ['role__in' => [$this->role]];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no executives at this time.';
        }

        $executives = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $executive = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
            );

            $executives[] = $executive;
        }

        return $executives;
    }

    function getExecutivesWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        if (empty($authors)) {
            return '';
        }
        
        $executives = [];

        foreach ($authors as $author) {
            $executives[] = $this->user->getUser($author->post_author);
        }

        return $executives;
    }


    function getExecutive($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $executive = $this->user->getUser($id);

        if (!is_array($executive)) {
            return '';
        }

        $executive['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $executive['skills'] = $this->skills->getPostSkills($post->ID);
        $executive['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $executive['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $executive['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $executive['resume'] = $this->resume->getResume($id);

        return $executive;
    }

    function getExecutives()
    {
        $args = [
            'role__in' => [$this->role]
        ];

        $executives = $this->user->getUsers($args);

        if (!is_array($executives)) {
            return '';
        }

        return $executives;
    }
}
