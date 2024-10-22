<?php

namespace SEVEN_TECH\Communications\Email\Accounts;

use PHPMailer\PHPMailer\PHPMailer;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class EmailReceipt
{

    public function receiptEmailBody($billingNumber, $receipt, $customer)
    {
        try {
            $billing = new EmailBilling();
            $billingType = 'RECEIPT';
            $billingNumberPrefix = 'RT';

            $header = $billing->billingHeader($billingType, $billingNumber, $receipt, $customer);
            $body = $billing->billingBody($receipt->lines);
            $footer = $billing->billingFooter($receipt);

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function send(WP_User $user, string $subject, string $message, array $content)
    {
        try {    
            $smtp_host = get_option('receipt_smtp_host');
            $smtp_port = get_option('receipt_smtp_port');
            $smtp_secure = get_option('receipt_smtp_secure');
            $smtp_auth = get_option('receipt_smtp_auth');
            $smtp_username = get_option('receipt_smtp_username');
            $smtp_password = get_option('receipt_smtp_password');
            $from_email = get_option('receipt_email');
            $from_name = get_option('receipt_name');

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

    public function sendReceiptEmail($customer, $receipt)
    {
        try {

        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
