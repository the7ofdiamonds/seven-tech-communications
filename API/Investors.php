<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Investors\Investors as PT_Investors;

use WP_REST_Request;

class Investors
{
    private $pt_investor;

    public function __construct()
    {
        $this->pt_investor = new PT_Investors;
    }

    function get_investors_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $investors = $this->pt_investor->getInvestorsWithTerm($taxonomy, $term);

            if (empty($investors)) {
                throw new Exception('There are no investors to show.', 404);
            }

            return rest_ensure_response(['investors' => $investors]);
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

    function get_investor(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $investor = $this->pt_investor->getInvestor($slug);

            return rest_ensure_response($investor);
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

    function get_investors()
    {
        try {
            $investors = $this->pt_investor->getInvestors();

            if (empty($investors)) {
                throw new Exception('There are no investors to show.', 404);
            }

            return rest_ensure_response(['investors' => $investors]);
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
