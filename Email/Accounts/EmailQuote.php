<?php

namespace SEVEN_TECH\Communications\Email\Accounts;

use PHPMailer\PHPMailer\PHPMailer;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class EmailQuote
{

    function body($billingNumber, $quote, $customer)
    {
        try {
            $billing = new EmailBilling();
            $billingType = 'QUOTE';
            $billingNumberPrefix = 'QT';

            $header = $billing->billingHeader($billingType, $billingNumber, $quote, $customer);
            $body = $billing->billingBody($quote->line_items);
            $footer = $billing->billingFooter($quote);

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function send(WP_User $user, string $subject, string $message, array $content)
    {
        try {    
            $smtp_host = get_option('quote_smtp_host');
            $smtp_port = get_option('quote_smtp_port');
            $smtp_secure = get_option('quote_smtp_secure');
            $smtp_auth = get_option('quote_smtp_auth');
            $smtp_username = get_option('quote_smtp_username');
            $smtp_password = get_option('quote_smtp_password');
            $from_email = get_option('quote_email');
            $from_name = get_option('quote_name');

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


    function sendQuoteEmail($customer, $quote)
    {
    }
}
