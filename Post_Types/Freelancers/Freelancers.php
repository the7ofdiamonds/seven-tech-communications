<?php

namespace SEVEN_TECH\Communications\Post_Types\Freelancers;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Freelancers
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
        $this->role = 'freelancer';
        $this->post_type = 'freelancers';
        
        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
        $this->resume = new Resume;
    }

    function getFreelancersList()
    {
        $args = ['role__in' => [$this->role]];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no freelancers at this time.';
        }

        $freelancers = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $freelancer = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
            );

            $freelancers[] = $freelancer;
        }

        return $freelancers;
    }

    function getFreelancersWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        if (empty($authors)) {
            return '';
        }
        
        $freelancers = [];

        foreach ($authors as $author) {
            $freelancers[] = $this->user->getUser($author->post_author);
        }

        return $freelancers;
    }


    function getFreelancer($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $freelancer = $this->user->getUser($id);

        if (!is_array($freelancer)) {
            return '';
        }

        $freelancer['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $freelancer['skills'] = $this->skills->getPostSkills($post->ID);
        $freelancer['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $freelancer['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $freelancer['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $freelancer['resume'] = $this->resume->getResume($id);

        return $freelancer;
    }

    function getFreelancers()
    {
        $args = [
            'role__in' => [$this->role]
        ];

        $freelancers = $this->user->getUsers($args);

        if (!is_array($freelancers)) {
            return '';
        }

        return $freelancers;
    }
}
