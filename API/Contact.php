<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use SEVEN_TECH\Communications\Email\Contact\EmailContact;

use PHPMailer\PHPMailer\PHPMailer;

class Contact
{
    private $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send_contact_email(WP_REST_Request $request)
    {
        try {
            $from_email = $request['email'];
            $first_name = $request['firstname'];
            $last_name = $request['lastname'];
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

            $contact_email = new EmailContact($this->mailer);
            $contactEmail = $contact_email->sendContactEmail($firstName, $lastName, $fromEmail, $subject, $message);

            return rest_ensure_response($contactEmail);
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
