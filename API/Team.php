<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Team\Team as PT_Team;

use WP_REST_Request;

class Team
{
    private $pt_team;

    public function __construct()
    {
        $this->pt_team = new PT_Team;
    }

    function get_team_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $team = $this->pt_team->getTeamWithTerm($taxonomy, $term);

            if (empty($team)) {
                throw new Exception('There are no investors to show.', 404);
            }

            return rest_ensure_response(['team' => $team]);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'errorMessage' => $e->getMessage(),
                'statusCode' => $statusCode
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }

    function get_team_member(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $team_member = $this->pt_team->getTeamMember($slug);

            return rest_ensure_response($team_member);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'errorMessage' => $e->getMessage(),
                'statusCode' => $statusCode
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }

    function get_team()
    {
        try {
            $team = $this->pt_team->getTeam();

            if (!is_array($team)) {
                throw new Exception('There are no Team Members to show.', 404);
            }

            return rest_ensure_response(['team' => $team]);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'team' => '',
                'errorMessage' => $e->getMessage(),
                'statusCode' => $statusCode
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }
}
