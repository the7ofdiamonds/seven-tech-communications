<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use SEVEN_TECH\Communications\Taxonomies\Taxonomies as Tax;

class Taxonomies
{
    private $post_type;
    private $tax;

    public function __construct()
    {
        $this->post_type = 'portfolio';
        $this->tax = new Tax;
    }

    public function get_project_types()
    {
        try {
            $project_types = $this->tax->getPostTypeTaxonomies($this->post_type, 'project_type');

            if (empty($project_types)) {
                throw new Exception('No projects found with a Project Type.', 404);
            }

            return rest_ensure_response(['projectTypes' => $project_types]);
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

    public function get_skills()
    {
        try {
            $skills = $this->tax->getPostTypeTaxonomies($this->post_type, 'Skills');

            if (empty($skills)) {
                throw new Exception('No projects found with a Skill.', 404);
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

    public function get_frameworks()
    {
        try {
            $frameworks = $this->tax->getPostTypeTaxonomies($this->post_type, 'frameworks');

            if (empty($frameworks)) {
                throw new Exception('No projects found with a Framework.', 404);
            }

            return rest_ensure_response(['frameworks' => $frameworks]);
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

    public function get_technologies()
    {
        try {
            $technologies = $this->tax->getPostTypeTaxonomies($this->post_type, 'technologies');

            if (empty($technologies)) {
                throw new Exception('No projects found with a Technology.', 404);
            }

            return rest_ensure_response(['technologies' => $technologies]);
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

    public function get_project_type(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');
            $project_type = $this->tax->getTaxonomyTerm($slug, 'project_type');

            if (empty($project_type)) {
                throw new Exception('Project Type could not be found.', 404);
            }

            return rest_ensure_response(['projectType' => $project_type]);
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
            $skill = $this->tax->getTaxonomyTerm($slug, 'Skills');

            if (empty($skill)) {
                throw new Exception('Skill could not be found.', 404);
            }

            return rest_ensure_response(['skill' => $skill]);
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

    public function get_framework(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');
            $framework = $this->tax->getTaxonomyTerm($slug, 'frameworks');

            if (empty($framework)) {
                throw new Exception('Framework could not be found.', 404);
            }

            return rest_ensure_response(['framework' => $framework]);
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

    public function get_technology(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');
            $technology = $this->tax->getTaxonomyTerm($slug, 'technologies');

            if (empty($technology)) {
                throw new Exception('Technology could not be found.', 404);
            }

            return rest_ensure_response(['technology' => $technology]);
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
