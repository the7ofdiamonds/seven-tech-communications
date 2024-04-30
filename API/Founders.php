<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Founders\Founders as PT_Founders;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;

use WP_REST_Request;

class Founders
{
    private $pt_founder;
    private $post_type;
    private $tax;

    public function __construct()
    {
        $this->pt_founder = new PT_Founders;
        $this->post_type = 'founders';
        $this->tax = new Taxonomies;
    }

    function get_founders()
    {
        try {
            $founders = $this->pt_founder->getFounders();

            if (empty($founders)) {
                throw new Exception('There are no founders to show.', 404);
            }

            return rest_ensure_response(['founders' => $founders]);
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

    function get_founders_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $founders = $this->pt_founder->getFoundersWithTerm($taxonomy, $term);

            if (empty($founders)) {
                throw new Exception('There are no founders to show.', 404);
            }

            return rest_ensure_response(['founders' => $founders]);
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

    function get_founder(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $founder = $this->pt_founder->getFounder($slug);

            return rest_ensure_response($founder);
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
