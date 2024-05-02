<?php

namespace SEVEN_TECH\Communications\Post_Types\Managing_Members;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Managing_Members
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
        $this->role = 'managing-member';
        $this->post_type = 'managing_members';

        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
        $this->resume = new Resume;
    }

    function getManagingMembersList()
    {
        $args = ['role__in' => [$this->role]];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no managing members at this time.';
        }

        $managing_members = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $managing_member = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
            );

            $managing_members[] = $managing_member;
        }

        return $managing_members;
    }

    function getManagingMembersWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        if (empty($authors)) {
            return '';
        }

        $managing_members = [];

        foreach ($authors as $author) {
            $managing_members[] = $this->user->getUser($author->post_author);
        }

        return $managing_members;
    }


    function getManagingMember($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $managing_member = $this->user->getUser($id);

        if (!is_array($managing_member)) {
            return '';
        }

        $managing_member['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $managing_member['skills'] = $this->skills->getPostSkills($post->ID);
        $managing_member['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $managing_member['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $managing_member['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $managing_member['resume'] = $this->resume->getResume($id);

        return $managing_member;
    }

    function getManagingMembers()
    {
        $args = [
            'role__in' => [$this->role]
        ];

        $managing_members = $this->user->getUsers($args);

        if (!is_array($managing_members)) {
            return '';
        }

        return $managing_members;
    }
}
