<?php

namespace SEVEN_TECH\Communications\Post_Types\Founders;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

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
    private $post_types;
    private $social_networks;

    public function __construct()
    {
        $this->role = 'founder';
        $this->post_type = 'founders';
        
        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
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

    function getFoundersWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        $founders = [];

        foreach ($authors as $author) {
            $founders[] = $this->user->getUser($author->post_author);
        }

        return $founders;
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
        $founder['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $founder['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $founder['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $founder['resume'] = $this->resume->getResume($id);

        return $founder;
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
}
