<?php

namespace SEVEN_TECH\Communications\API;

use SEVEN_TECH\Communications\Email\Portfolio\EmailOnboarding;

use Exception;

use WP_REST_Request;
use WP_REST_Response;
use WP_User;

class Portfolio
{

    public function send_onboarding_email(WP_REST_Request $request)
    {
        try {
            $customer = $request['customer'];
            $receipt = $request['receipt'];

            if (empty($customer)) {
                throw new Exception('Customer is required to send receipt email.', 400);
            }

            if (empty($receipt)) {
                throw new Exception('Receipt is required to send receipt email.', 400);
            }

            $user = new WP_User($customer);
            $subject = $subject = 'Onboarding for ' . $receipt->project_name;
            $message = (new EmailOnboarding())->message($customer, $receipt);
            $content = array(
                "{SUBJECT}" => $subject,
                "{MESSAGE}" => $message,
                "{ONBOARDING_URL}" => $receipt->onboarding_link
            );

            (new EmailOnboarding())->send($user, $subject, $message, $content);

            $onboardingEmailResponse = array(
                'successMessage' => $message,
                'statusCode' => 200,
            );

            $response = new WP_REST_Response($onboardingEmailResponse);
            $response->set_status(200);

            return rest_ensure_response($response);
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
