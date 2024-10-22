<?php

namespace SEVEN_TECH\Communications\Email\Accounts;

use PHPMailer\PHPMailer\PHPMailer;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class EmailInvoice
{

    function invoiceEmailBody($billingNumber, $invoice, $customer)
    {
        try {
            $billing = new EmailBilling();
            $billingType = 'INVOICE';
            $billingNumberPrefix = 'IN';

            $header = $billing->billingHeader($billingType, $billingNumber, $invoice, $customer);
            $body = $billing->billingBody($invoice->lines);
            $footer = $billing->billingFooter($invoice);

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function send(WP_User $user, string $subject, string $message, array $content)
    {
        try {    
            $smtp_host = get_option('invoice_smtp_host');
            $smtp_port = get_option('invoice_smtp_port');
            $smtp_secure = get_option('invoice_smtp_secure');
            $smtp_auth = get_option('invoice_smtp_auth');
            $smtp_username = get_option('invoice_smtp_username');
            $smtp_password = get_option('invoice_smtp_password');
            $from_email = get_option('invoice_email');
            $from_name = get_option('invoice_name');

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

    function sendInvoiceEmail($customer, $invoice)
    {
        try {
            $to_email = $customer->email;
            $billingNumberPrefix = 'IN';
            $billingNumber = $billingNumberPrefix . $invoice->id;
            $name =  $customer->name;
            $to_name = $name;
            $user = new WP_User();
            $subject = $billingNumber . ' for ' . $name;
            $message = "";
            $content = array();

            $this->send($user, $subject, $message, $content);
        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
