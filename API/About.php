<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

class About
{
    function get_mission_statement(WP_REST_Request $request)
    {
        try {
            $missionStatement = get_option('mission-statement');

            if ($missionStatement == false) {
                $missionStatement = '';
            }

            $missionStatementResponse = [
                'statusCode' => 200,
                'missionStatement' => $missionStatement,
            ];

            return rest_ensure_response($missionStatementResponse);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'statusCode' => $statusCode,
                'error' => $e,
                'errorMessage' => $e->getMessage(),
                'missionStatement' => ''
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }
}
