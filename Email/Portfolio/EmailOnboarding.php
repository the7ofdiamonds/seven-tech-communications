<?php

namespace SEVEN_TECH\Communications\Email\Portfolio;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class EmailOnboarding
{

    function message($customer, $receipt)
    {
        try {
            $message = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailOnboardingMessage.php';

            if (!file_exists($message)) {
                throw new Exception('Unable to find email onboarding message.');
            }

            $swap_var = array(
                "{YOUR_NAME}" => $customer->first_name . ' ' . $customer->last_name,
                "{PAYMENT_AMOUNT}" => $receipt->amount_paid,
                "{YOUR_COMPANY_NAME}" => $customer->company_name
            );

            $bodyMessage = file_get_contents($message);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($swap_var[$key] != '') {
                        $bodyMessage = str_replace($key, $swap_var[$key], $bodyMessage);
                    } else {
                        $bodyMessage = str_replace($key, '', $bodyMessage);
                    }
                }
            }

            return $bodyMessage;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function send(WP_User $user, string $subject, string $message, array $content)
    {
        try {    
            $smtp_host = get_option('support_smtp_host');
            $smtp_port = get_option('support_smtp_port');
            $smtp_secure = get_option('support_smtp_secure');
            $smtp_auth = get_option('support_smtp_auth');
            $smtp_username = get_option('support_smtp_username');
            $smtp_password = get_option('support_smtp_password');
            $from_email = get_option('support_email');
            $from_name = get_option('support_name');

            $template = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailOnboarding.php';

            $body = (new Email)->emailBody($template, $content);
            $altBody = '<pre>' . $message . '</pre>';

            (new Email())->sendEmail($user, $smtp_auth, $smtp_host, $smtp_secure, $smtp_port, $smtp_username, $smtp_password, $from_email, $from_name, $subject, $body, $altBody);

            return true;
        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendSupportEmail($user, $subject, $message)
    {
        $content = array();
        $this->send($user, $subject, $message, $content);
    }
}
