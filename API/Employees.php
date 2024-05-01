<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Employees\Employees as PT_Employees;

use WP_REST_Request;

class Employees
{
    private $pt_employee;

    public function __construct()
    {
        $this->pt_employee = new PT_Employees;
    }

    function get_employees_with_term(WP_REST_Request $request)
    {
        try {
            $taxonomy = $request->get_param('slug');
            $term = $request['term'];

            $employees = $this->pt_employee->getEmployeesWithTerm($taxonomy, $term);

            if (empty($employees)) {
                throw new Exception('There are no employees to show.', 404);
            }

            return rest_ensure_response(['employees' => $employees]);
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

    function get_employee(WP_REST_Request $request)
    {
        try {
            $slug = $request->get_param('slug');

            $employee = $this->pt_employee->getEmployee($slug);

            return rest_ensure_response($employee);
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

    function get_employees()
    {
        try {
            $employees = $this->pt_employee->getEmployees();

            if (empty($employees)) {
                throw new Exception('There are no employees to show.', 404);
            }

            return rest_ensure_response(['employees' => $employees]);
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
