<?php

namespace SEVEN_TECH\Communications\Post_Types\Team;

use SEVEN_TECH\Communications\Role\Role;
use SEVEN_TECH\Communications\User\User;

class Team
{
    private $roleNames;
    private $post_type;
    private $user;

    public function __construct()
    {
        $this->roleNames = (new Role)->getRoleNames();
        $this->post_type = 'team';
        $this->user = new User;
    }

    function getTeam()
    {
        $args = [
            'role__in' => $this->roleNames
        ];

        $team = $this->user->getUsers($args);

        if (!is_array($team)) {
            return '';
        }

        return $team;
    }

    function getTeamMember($slug)
    {
        $teamMember = $this->user->getUser($slug, $this->post_type);

        if (!is_array($teamMember)) {
            return '';
        }

        return $teamMember;
    }
}
