<?php

namespace SEVEN_TECH\Communications\API;

use SEVEN_TECH\Communications\Email\Support\EmailSupport;

use Exception;

use WP_REST_Request;
use WP_User;

class Support
{

    public function send_support_email(WP_REST_Request $request)
    {
        try {
            $from_email = $request['email'];
            $first_name = $request['firstname'];
            $last_name = $request['firstname'];
            $subject = $request['subject'];
            $message = $request['message'];

            if (empty($from_email)) {
                throw new Exception('Email is required', 400);
            }

            if (empty($first_name)) {
                throw new Exception('First name is required', 400);
            }

            if (empty($last_name)) {
                throw new Exception('Last name is required', 400);
            }

            if (empty($subject)) {
                throw new Exception('Subject is required', 400);
            }

            if (empty($message)) {
                throw new Exception('Message is required', 400);
            }

            $fromEmail = sanitize_email($from_email);
            $firstName = sanitize_text_field($first_name);
            $lastName = sanitize_text_field($last_name);
            $subject = sanitize_text_field($subject);
            $message = sanitize_textarea_field($message);

            // Add User
            $user = new WP_User();

            $supportEmail = (new EmailSupport)->sendSupportEmail($firstName, $lastName, $fromEmail, $subject, $message);

            return rest_ensure_response($supportEmail);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'statusCode' => $statusCode,
                'errorMessage' => $e->getMessage()
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }
}
