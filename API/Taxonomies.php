<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use SEVEN_TECH\Communications\Taxonomies\Taxonomies as Tax;
use SEVEN_TECH\Communications\Taxonomies\Skills;
use SEVEN_TECH\Communications\Taxonomies\Frameworks;
use SEVEN_TECH\Communications\Taxonomies\Technologies;

class Taxonomies
{
    private $post_type;
    private $tax;
    private $skills;
    private $frameworks;
    private $technologies;

    public function __construct()
    {
        $this->post_type = 'founders';
        $this->tax = new Tax;
        $this->skills = new Skills;
        $this->frameworks = new Frameworks;
        $this->technologies = new Technologies;
    }

    public function get_project_types()
    {
        try {
            $project_types = $this->tax->getPostTypeTaxonomies($this->post_type, 'project_types');

            if (empty($project_types)) {
                throw new Exception('No Project Types found.', 404);
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
            $skills = $this->skills->getSkills($this->post_type);

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

    public function get_frameworks()
    {
        try {
            $frameworks = $this->frameworks->getFrameworks($this->post_type);

            if (empty($frameworks)) {
                throw new Exception('No Frameworks found.', 404);
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
            $technologies = $this->technologies->getTechnologies($this->post_type);

            if (empty($technologies)) {
                throw new Exception('No Technologies found.', 404);
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

            return rest_ensure_response($project_type);
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
            $skill = $this->skills->getSkill($slug);

            if (empty($skill)) {
                throw new Exception('Skill could not be found.', 404);
            }

            return rest_ensure_response($skill);
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
            $framework = $this->frameworks->getFramework($slug);

            if (empty($framework)) {
                throw new Exception('Framework could not be found.', 404);
            }

            return rest_ensure_response($framework);
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
            $technology = $this->technologies->getTechnology($slug);

            if (empty($technology)) {
                throw new Exception('Technology could not be found.', 404);
            }

            return rest_ensure_response($technology);
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
