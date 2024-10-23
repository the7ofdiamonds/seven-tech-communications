<?php

namespace SEVEN_TECH\Communications\Email\Gateway;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class Change
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

    public function sendUsernameChangedEmail(int $user_id, string $username)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Your username has been changed at {$this->email->site_name}";
            $message = "Your username has been changed to {$username}.";

            $content = array(
                "{MESSAGE}" => $message,
                "{URL}" => home_url() . "/login",
                "{BUTTON_NAME}" => 'LOGIN'
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendNameChangedEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Your name has been changed at {$this->email->site_name}";
            $message = "Your name has been changed to {$user->first_name} {$user->last_name}.";

            $content = array(
                "{MESSAGE}" => $message,
                "{URL}" => home_url() . "/login",
                "{BUTTON_NAME}" => 'LOGIN'
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendNicknameChangedEmail(int $user_id, string $nickname)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Your nickname has been changed at {$this->email->site_name}";
            $message = "Your nickname has been changed to {$nickname}.";

            $content = array(
                "{MESSAGE}" => $message,
                "{URL}" => home_url() . "/login",
                "{BUTTON_NAME}" => 'LOGIN'
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendNicenameChangedEmail(int $user_id, string $nicename)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Your nicename has been changed at {$this->email->site_name}";
            $message = "Your nicename has been changed to {$nicename}.";

            $content = array(
                "{MESSAGE}" => $message,
                "{URL}" => home_url() . "/login",
                "{BUTTON_NAME}" => 'LOGIN'
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendPhoneChangedEmail(int $user_id, string $phone)
    {
        try {
            $user = new WP_User($user_id);
            $subject = "Your phone number has been changed at {$this->email->site_name}";
            $message = "Your phone number has been changed to {$phone}.";

            $content = array(
                "{MESSAGE}" => $message,
                "{URL}" => home_url() . "/login",
                "{BUTTON_NAME}" => 'LOGIN'
            );

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
