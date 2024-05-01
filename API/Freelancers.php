<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Freelancers\Freelancers as PT_Freelancers;

use WP_REST_Request;

class Freelancers
{
    private $pt_freelancer;

    public function __construct()
    {
        $this->pt_freelancer = new PT_Freelancers;
    }

    function get_freelancers_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $freelancers = $this->pt_freelancer->getFreelancersWithTerm($taxonomy, $term);

            if (empty($freelancers)) {
                throw new Exception('There are no freelancers to show.', 404);
            }

            return rest_ensure_response(['freelancers' => $freelancers]);
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

    function get_freelancer(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $freelancer = $this->pt_freelancer->getFreelancer($slug);

            return rest_ensure_response($freelancer);
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

    function get_freelancers()
    {
        try {
            $freelancers = $this->pt_freelancer->getFreelancers();

            if (empty($freelancers)) {
                throw new Exception('There are no freelancers to show.', 404);
            }

            return rest_ensure_response(['freelancers' => $freelancers]);
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
