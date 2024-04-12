<?php

namespace SEVEN_TECH\Communications\API;

use PHPMailer\PHPMailer\PHPMailer;

class API
{
    public function __construct()
    {
        $mailer = new PHPMailer();
        $about = new About;
        $accounts = new Accounts($mailer);
        $contact = new Contact($mailer);
        $content = new Content;
        $gateway = new Gateway($mailer);
        $portfolio = new Portfolio($mailer);
        $schedule = new Schedule($mailer);
        $support = new Support($mailer);

        register_rest_route('seven-tech/v1', '/about/mission-statement', array(
            'methods' => 'GET',
            'callback' => array($about, 'get_mission_statement'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/quote/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($accounts, 'send_quote_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/invoice/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($accounts, 'send_invoice_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/receipt/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($accounts, 'send_receipt_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/contact', array(
            'methods' => 'POST',
            'callback' => array($contact, 'send_contact_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/content/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($content, 'get_content'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/onboarding/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($portfolio, 'send_onboarding_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/signup', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'signup'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/verify-account', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'verifyAccount'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/verified-account', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'verifiedAccount'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/locked-account', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'lockedAccount'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/removed-account', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'removedAccount'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/deleted-account', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'deletedAccount'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/forgot-password', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'forgotPassword'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/update-password', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'updatePassword'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/changed-password', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'changedPassword'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/changed-name', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'changedName'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/changed-phone', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'changedPhone'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/gateway/changed-username', array(
            'methods' => 'POST',
            'callback' => array($gateway, 'changedUsername'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/schedule', array(
            'methods' => 'POST',
            'callback' => array($schedule, 'send_schedule_email'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/support', array(
            'methods' => 'POST',
            'callback' => array($support, 'send_support_email'),
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
