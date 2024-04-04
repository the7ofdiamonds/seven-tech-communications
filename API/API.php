<?php

namespace SEVEN\Communications\API;

use PHPMailer\PHPMailer\PHPMailer;

use SEVEN_TECH\Communications\Email\EmailInvoice;
use SEVEN_TECH\Communications\Email\EmailQuote;
use SEVEN_TECH\Communications\Email\EmailReceipt;
use SEVEN_TECH\Communications\Email\EmailOnboarding;

class API
{
    public function __construct()
    {
        $mailer = new PHPMailer();

        $email = new Email($mailer);
        new EmailQuote($mailer);
        new EmailInvoice($mailer);
        new EmailReceipt($mailer);
        new EmailOnboarding($mailer);

        register_rest_route('seven-tech/v1', '/email/quote/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($email, 'send_quote_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/invoice/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($email, 'send_invoice_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/receipt/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($email, 'send_receipt_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/onboarding/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($email, 'send_onboarding_email'),
            'permission_callback' => '__return_true',
        ));
    }

    public function allow_cors_headers()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }
}
