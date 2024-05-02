<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Managing_Members\Managing_Members as PT_ManagingMembers;

use WP_REST_Request;

class Managing_Members
{
    private $pt_managing_members;

    public function __construct()
    {
        $this->pt_managing_members = new PT_ManagingMembers;
    }

    function get_managing_members_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $managing_members = $this->pt_managing_members->getManagingMembersWithTerm($taxonomy, $term);

            if (empty($managing_members)) {
                throw new Exception('There are no managing members to show.', 404);
            }

            return rest_ensure_response(['managing_members' => $managing_members]);
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

    function get_managing_member(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $managing_members = $this->pt_managing_members->getManagingMember($slug);

            return rest_ensure_response($managing_members);
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

    function get_managing_members()
    {
        try {
            $managing_members = $this->pt_managing_members->getManagingMembers();

            if (empty($managing_members)) {
                throw new Exception('There are no managing members to show.', 404);
            }

            return rest_ensure_response(['managing_members' => $managing_members]);
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
}
