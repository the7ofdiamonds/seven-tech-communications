<?php

namespace SEVEN_TECH\Communications\API;

use SEVEN_TECH\Communications\Email\Portfolio\EmailOnboarding;

use Exception;

use WP_REST_Request;

use PHPMailer\PHPMailer\PHPMailer;

class Portfolio
{
    private $mailer;
    private $onboardingEmail;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->onboardingEmail = new EmailOnboarding($this->mailer);
    }

    public function send_onboarding_email(WP_REST_Request $request)
    {
        try {
            $customer = $request['customer'];
            $receipt = $request['receipt'];

            if (empty($customer)) {
                $statusCode = 400;
                throw new Exception('Customer is required to send receipt email.', $statusCode);
            }

            if (empty($receipt)) {
                $statusCode = 400;
                throw new Exception('Receipt is required to send receipt email.', $statusCode);
            }

            $onboardingEmail = $this->onboardingEmail->sendOnboardingEmail($customer, $receipt);

            return rest_ensure_response($onboardingEmail);
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
