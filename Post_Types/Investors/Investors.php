<?php

namespace SEVEN_TECH\Communications\Post_Types\Investors;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Content\Content;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Investors
{
    private $role;
    private $post_type;
    private $user;
    private $content;
    private $resume;
    private $taxonomies;
    private $skills;
    private $frameworks;
    private $technologies;
    private $post_types;
    private $social_networks;

    public function __construct()
    {
        $this->role = 'investor';
        $this->post_type = 'investors';
        
        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->content = new Content;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
        $this->resume = new Resume;
    }

    function getInvestorsList()
    {
        $args = ['role__in' => [$this->role]];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no investors at this time.';
        }

        $investors = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $investor = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
            );

            $investors[] = $investor;
        }

        return $investors;
    }

    function getInvestorsWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        if (empty($authors)) {
            return '';
        }
        
        $investors = [];

        foreach ($authors as $author) {
            $investors[] = $this->user->getUser($author->post_author);
        }

        return $investors;
    }


    function getInvestor($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $investor = $this->user->getUser($id);

        if (!is_array($investor)) {
            return '';
        }
        
        $managing_member['content'] = $this->content->filter($post->post_content);
        $investor['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $investor['skills'] = $this->skills->getPostSkills($post->ID);
        $investor['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $investor['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $investor['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $investor['resume'] = $this->resume->getResume($id);

        return $investor;
    }

    function getInvestors()
    {
        $args = [
            'role__in' => [$this->role]
        ];

        $investors = $this->user->getUsers($args);

        if (!is_array($investors)) {
            return '';
        }

        return $investors;
    }
}
