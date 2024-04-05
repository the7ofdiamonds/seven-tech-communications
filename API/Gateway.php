<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use PHPMailer\PHPMailer\PHPMailer;

class Gateway
{
    private $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function signup(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function verifyAccount(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function verifiedAccount(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function lockedAccount(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function removedAccount(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function deletedAccount(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function forgotPassword(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function updatePassword(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedPassword(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedName(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedPhone(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedUsername(WP_REST_Request $request)
    {
        try {


            return rest_ensure_response("");
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }
}
