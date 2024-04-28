<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use SEVEN_TECH\Communications\Taxonomies\Skills;

class Taxonomies{
    private $skills;

    public function __construct()
    {
        $this->skills = new Skills;
    }

    public function get_skills(WP_REST_Request $request)
    {
        try {
            $skills = $this->skills->getSkills();

            if (empty($skills)) {
                throw new Exception('No Skills found.', 404);
            }

            return rest_ensure_response(['skills' => $skills]);
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

    public function get_skill(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $skills = $this->skills->getPostSkillsBySlug($slug);

            if (empty($skills)) {
                throw new Exception('No Skills found.', 404);
            }

            return rest_ensure_response($skills);
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