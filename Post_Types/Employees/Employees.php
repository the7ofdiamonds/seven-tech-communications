<?php

namespace SEVEN_TECH\Communications\Post_Types\Employees;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Resume\Resume;
use SEVEN_TECH\Communications\Social_Networks\Social_Networks;
use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Employees
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
        $this->role = 'employee';
        $this->post_type = 'employees';
        
        $this->post_types = new Post_Types;
        $this->user = new User;
        $this->taxonomies = new Taxonomies;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
        $this->social_networks = new Social_Networks;
        $this->resume = new Resume;
    }

    function getEmployeesList()
    {
        $args = ['role__in' => [$this->role]];
        $users = get_users($args);

        if (!is_array($users)) {
            return 'There are no employees at this time.';
        }

        $employees = [];

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $employee = array(
                'id' => $user_data->ID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
            );

            $employees[] = $employee;
        }

        return $employees;
    }

    function getEmployeesWithTerm($taxonomy, $term)
    {
        $authors = $this->post_types->getPostTypeWithTerm($this->post_type, $taxonomy, $term);

        $employees = [];

        foreach ($authors as $author) {
            $employees[] = $this->user->getUser($author->post_author);
        }

        return $employees;
    }


    function getEmployee($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_type);

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $employee = $this->user->getUser($id);

        if (!is_array($employee)) {
            return '';
        }

        $employee['projectTypes'] = $this->taxonomies->getPostTaxonomy($post->ID, 'project_types');
        $employee['skills'] = $this->skills->getPostSkills($post->ID);
        $employee['frameworks'] = $this->frameworks->getPostFrameworks($post->ID);
        $employee['technologies'] = $this->technologies->getPostTechnologies($post->ID);
        $employee['social_networks'] = $this->social_networks->getSocialNetworks($post->ID);
        $employee['resume'] = $this->resume->getResume($id);

        return $employee;
    }

    function getEmployees()
    {
        $args = [
            'role__in' => [$this->role]
        ];

        $employees = $this->user->getUsers($args);

        if (!is_array($employees)) {
            return '';
        }

        return $employees;
    }
}
