<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Executives\Executives as PT_Executives;

use WP_REST_Request;

class Executives
{
    private $pt_executive;

    public function __construct()
    {
        $this->pt_executive = new PT_Executives;
    }

    function get_executives_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $executives = $this->pt_executive->getExecutivesWithTerm($taxonomy, $term);

            if (empty($executives)) {
                throw new Exception('There are no executives to show.', 404);
            }

            return rest_ensure_response(['executives' => $executives]);
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

    function get_executive(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $executive = $this->pt_executive->getExecutive($slug);

            return rest_ensure_response($executive);
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

    function get_executives()
    {
        try {
            $executives = $this->pt_executive->getExecutives();

            if (empty($executives)) {
                throw new Exception('There are no executives to show.', 404);
            }

            return rest_ensure_response(['executives' => $executives]);
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
