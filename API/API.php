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
        $employees = new Employees;
        $executives = new Executives;
        $founders = new Founders;
        $freelancers = new Freelancers;
        $gateway = new Gateway($mailer);
        $investors = new Investors;
        $portfolio = new Portfolio($mailer);
        $schedule = new Schedule($mailer);
        $support = new Support($mailer);
        $taxonomies = new Taxonomies;
        $team = new Team;

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

        register_rest_route('seven-tech/v1', '/content/(?P<slug>[a-zA-Z0-9-_\/]+)', array(
            'methods' => 'GET',
            'callback' => array($content, 'get_content'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/employees/taxonomies/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($employees, 'get_employees_with_term'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/employees/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($employees, 'get_employee'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/employees', array(
            'methods' => 'GET',
            'callback' => array($employees, 'get_employees'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/executives/taxonomies/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($executives, 'get_executives_with_term'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/executives/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($executives, 'get_executive'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/executives', array(
            'methods' => 'GET',
            'callback' => array($executives, 'get_executives'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/founders/taxonomies/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($founders, 'get_founders_with_term'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/founders/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($founders, 'get_founder'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/founders', array(
            'methods' => 'GET',
            'callback' => array($founders, 'get_founders'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/freelancers/taxonomies/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($freelancers, 'get_freelancers_with_term'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/freelancers/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($freelancers, 'get_freelancer'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/freelancers', array(
            'methods' => 'GET',
            'callback' => array($freelancers, 'get_foreelancer'),
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

        register_rest_route('seven-tech/v1', '/investors/taxonomies/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($investors, 'get_investors_with_term'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/investors/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($investors, 'get_investor'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/investors', array(
            'methods' => 'GET',
            'callback' => array($investors, 'get_investors'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/email/onboarding/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($portfolio, 'send_onboarding_email'),
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

        register_rest_route('seven-tech/v1', '/team/taxonomies/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'POST',
            'callback' => array($team, 'get_team_with_term'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/team/(?P<slug>[a-zA-Z0-9-_]+)', array(
            'methods' => 'GET',
            'callback' => array($team, 'get_team_member'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/v1', '/team', array(
            'methods' => 'GET',
            'callback' => array($team, 'get_team'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('seven-tech/communications/v1', '/taxonomies/project-types', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_project_types'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/skills', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_skills'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/frameworks', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_frameworks'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/technologies', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_technologies'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/project-types/(?P<slug>[a-zA-Z0-9-_]+)', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_project_type'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/skills/(?P<slug>[a-zA-Z0-9-_]+)', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_skill'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/frameworks/(?P<slug>[a-zA-Z0-9-_]+)', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_framework'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('seven-tech/communications/v1', '/taxonomies/technologies/(?P<slug>[a-zA-Z0-9-_]+)', [
            'methods' => 'GET',
            'callback' => [$taxonomies, 'get_technology'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function allow_cors_headers()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }
}
