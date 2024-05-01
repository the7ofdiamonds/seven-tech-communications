<?php

namespace SEVEN_TECH\Communications\Post_Types\Team;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Team
{
    private $post_type;
    private $roles;
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
        $this->roles = ['employee', 'executive', 'founder', 'freelancer', 'investor', 'managing-member'];
        $this->post_type = 'team';

        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
        $this->resume = new Resume;
    }


    function getTeamList()
    {
        $args = ['role__in' => $this->roles];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no team at this time.';
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
            );

            $team[] = $teamMember;
        }

        return $team;
    }

    function getTeamWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        $team = [];

        foreach ($authors as $author) {
            $team[] = $this->user->getUser($author->post_author);
        }

        return $team;
    }


    function getTeamMember($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $teamMember = $this->user->getUser($id);

        if (!is_array($teamMember)) {
            return '';
        }

        $teamMember['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $teamMember['skills'] = $this->skills->getPostSkills($post->ID);
        $teamMember['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $teamMember['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $teamMember['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $teamMember['resume'] = $this->resume->getResume($id);

        return $teamMember;
    }

    function getTeam()
    {
        $args = [
            'role__in' => $this->roles
        ];

        $team = $this->user->getUsers($args);

        if (!is_array($team)) {
            return '';
        }

        return $team;
    }
}
