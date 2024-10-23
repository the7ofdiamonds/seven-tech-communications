<?php

namespace SEVEN_TECH\Communications\Email\Gateway;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class Password
{
    private $email;

    public function __construct()
    {
        $this->email = new Email;
    }

    public function send(WP_User $user, string $subject, string $message, array $content): bool
    {
        try {
            $smtp_host = get_option('gateway_smtp_host');
            $smtp_port = get_option('gateway_smtp_port');
            $smtp_secure = get_option('gateway_smtp_secure');
            $smtp_auth = get_option('gateway_smtp_auth');
            $smtp_username = get_option('gateway_smtp_username');
            $smtp_password = get_option('gateway_smtp_password');
            $from_email = get_option('gateway_email');
            $from_name = get_option('gateway_name');

            $template = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailGateway.php';

            $body = (new Email)->body($template, $content);
            $altBody = '<pre>' . $message . '</pre>';

            (new Email())->send($user, $smtp_auth, $smtp_host, $smtp_secure, $smtp_port, $smtp_username, $smtp_password, $from_email, $from_name, $subject, $body, $altBody);

            return true;
        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function sendRecoverEmail(int $user_id, string $url)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Password Recovery Instructions for {$this->email->site_name}";
            $message = "Follow the link below to recover your password."; 

            $content = array(
                "{NAME}" => "{$user->first_name} {$user->last_name}",
                "{MESSAGE}" => $message,
                "{URL}" => $url,
                "{BUTTON_NAME}" => 'RECOVER',
                "{SUPPORT_EMAIL}" => $this->email->support_email,
                "{COMPANY_NAME}" => $this->email->company_name,
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function sendChangedEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Password Changed at {$this->email->site_name}";
            $message = "Your password has been changed.";

            $content = array(
                "{NAME}" => "{$user->first_name} {$user->last_name}",
                "{MESSAGE}" => $message,
                "{URL}" => home_url() . "/login",
                "{BUTTON_NAME}" => 'LOGIN',
                "{SUPPORT_EMAIL}" => $this->email->support_email,
                "{COMPANY_NAME}" => $this->email->company_name,
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function sendUpdateEmail(int $user_id, string $url)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Your password needs to be updated at {$this->email->site_name}";
            $message = "Below is a link to update your password."; 

            $content = array(
                "{NAME}" => "{$user->first_name} {$user->last_name}",
                "{MESSAGE}" => $message,
                "{URL}" => $url,
                "{BUTTON_NAME}" => 'UPDATE',
                "{SUPPORT_EMAIL}" => $this->email->support_email,
                "{COMPANY_NAME}" => $this->email->company_name,
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
