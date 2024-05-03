<?php

namespace SEVEN_TECH\Communications\Roles;

use Exception;

use WP_QUery;

use SEVEN_TECH\Communications\Post_Types\Post_Types;

class Roles
{
    private $roles;
    private $post_types_list;
    private $roleNames;

    public function __construct()
    {
        $this->roles = [
            [
                'name' => 'investor',
                'display_name' => 'Investor',
                'capabilities' => [],
                'order' => 0,
                'post_type' => 'investors'
            ],
            [
                'name' => 'founder',
                'display_name' => 'Founder',
                'capabilities' => [],
                'order' => 1,
                'post_type' => 'founders'
            ],
            [
                'name' => 'managing-member',
                'display_name' => 'Managing Member',
                'capabilities' => [],
                'order' => 2,
                'post_type' => 'managing_members'
            ],
            [
                'name' => 'freelancer',
                'display_name' => 'Freelancer',
                'capabilities' => [],
                'order' => 3,
                'post_type' => 'freelancers'
            ],
            [
                'name' => 'executive',
                'display_name' => 'Executive',
                'capabilities' => [],
                'order' => 4,
                'post_type' => 'executives'
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee',
                'capabilities' => [],
                'order' => 5,
                'post_type' => 'employees'
            ]
        ];

        $this->post_types_list = (new Post_Types)->post_types_list;
        $this->roleNames = $this->getRoleNames();
    }

    function addRolePages()
    {
        $args = [
            'role__in' => $this->roleNames
        ];
        $users = get_users($args);

        if (!is_array($users)) {
            return '';
        }

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $roles = $this->getOrderedRoles($user_data->roles);

            foreach ($roles as $role) {
                $rolePageCount = count_user_posts($user->ID, $role);

                if ($rolePageCount >= 1) {
                    continue;
                }
            }

            $first_name = $user_data->first_name;
            $last_name = $user_data->last_name;

            $post_title = $first_name . ' ' . $last_name;
            $post_slug = $user_data->nicename;

            if (empty($post_slug)) {
                $post_slug = preg_replace('/[^a-zA-Z]/', "", $post_title);
            }

            $slug = $this->getRolePostType($roles[0]);

            if ($slug == '') {
                continue;
            }

            $postType = '';

            foreach ($this->post_types_list as $post_type) {
                if ($post_type['slug'] == $slug) {
                    $postType = $post_type['name'];
                    break;
                }
            }

            if ($postType == '') {
                continue;
            }

            $args = array(
                'post_author'   => $user->ID,
                'post_title'    => $post_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => $postType,
                'post_name'     => $post_slug,
            );

            $query = new WP_Query($args);

            $existing_post = $query->posts;

            if (!empty($existing_post)) {
                continue;
            }

            $role_page = wp_insert_post($args);

            if (!is_int($role_page)) {
                error_log('There was an error creating team member page.');
                continue;
            }
        }
    }

    public function addRoles()
    {
        foreach ($this->roles as $role) {
            add_role(
                $role['name'],
                $role['display_name'],
                $role['capabilities']
            );
        }
    }

    public function getRoleNames()
    {
        $roleNames = [];

        foreach ($this->roles as $role) {
            $roleNames[] = $role['name'];
        };

        return $roleNames;
    }

    public function getRoleDisplayNames()
    {
        $roleDisplayNames = [];

        foreach ($this->roles as $role) {
            $roleDisplayNames[] = $role['display_name'];
        };

        return $roleDisplayNames;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getOrderedRoles($roles)
    {
        if (!is_array($roles)) {
            throw new Exception('Wrong roles format. Must be an array.', 400);
        }

        $order = [];

        foreach ($this->roles as $role) {
            $order[] = [$role['name'] => $role['order']];
        }

        uksort($roles, function ($a, $b) use ($order) {
            return $order[$a] <=> $order[$b];
        });

        return $roles;
    }

    public function getRolePostType($name)
    {
        $post_type = '';

        foreach ($this->roles as $role) {
            if ($role['name'] == $name) {
                $post_type = $role['post_type'];
                break;
            }
        }

        if ($post_type == '') {
            return '';
        }

        $post_types = get_post_types(['public' => true], 'objects');

        $slug = '';

        foreach ($post_types as $post_type) {
            if ($post_type->labels->singular_name == $post_type) {
                $slug = $post_type->rewrite['slug'];
                break;
            }
        }

        if ($slug == '') {
            return '';
        }

        return $slug;
    }

    public function getRoleLink($name, $nicename)
    {
        $slug = $this->getRolePostType($name);

        if ($slug == '') {
            return '';
        }

        return "/{$slug}/{$nicename}";
    }
}
