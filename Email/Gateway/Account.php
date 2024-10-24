<?php

namespace SEVEN_TECH\Communications\Email\Gateway;

use SEVEN_TECH\Communications\Email\Email;
use SEVEN_TECH\Communications\Exception\DestructuredException;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class Account
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

            if (
                !$smtp_auth ||
                !$smtp_host ||
                !$smtp_secure ||
                !$smtp_port ||
                !$smtp_username ||
                !$smtp_password ||
                !$from_email ||
                !$from_name
            ) {
                throw new Exception("There one or more parameters missing in order to send this email.", 500);
            }

            $template = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailGateway.php';

            $body = (new Email)->body($template, $content);
            $altBody = '<pre>' . $message . '</pre>';

            (new Email())->send($user, $smtp_auth, $smtp_host, $smtp_secure, $smtp_port, $smtp_username, $smtp_password, $from_email, $from_name, $subject, $body, $altBody);

            return true;
        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (DestructuredException $e) {
            throw new DestructuredException($e);
        } catch (Exception $e) {
            throw new DestructuredException($e);
        }
    }

    public function sendSignUpEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = 'Signup Email';
            $message = "Thanks for joining {$this->email->site_name}  {$user->first_name}";

            $content = [
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => "",
                "{BUTTON_NAME}" => ""
            ];

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (DestructuredException $e) {
            throw new DestructuredException($e);
        } catch (Exception $e) {
            throw new DestructuredException($e);
        }
    }

    public function sendActivateAccountEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = 'Signup Email';
            $message = "Thanks for joining {$this->email->site_name}  {$user->first_name}";

            $content = [
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => "",
                "{BUTTON_NAME}" => ""
            ];

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (DestructuredException $e) {
            throw new DestructuredException($e);
        } catch (Exception $e) {
            throw new DestructuredException($e);
        }
    }

    public function sendAccountLockedEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = 'Signup Email';
            $message = "Thanks for joining {$this->email->site_name}  {$user->first_name}";

            $content = [
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => "",
                "{BUTTON_NAME}" => ""
            ];

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (DestructuredException $e) {
            throw new DestructuredException($e);
        } catch (Exception $e) {
            throw new DestructuredException($e);
        }
    }

    public function sendAccountUnlockedEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = 'Signup Email';
            $message = "Thanks for joining {$this->email->site_name}  {$user->first_name}";

            $content = [
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => "",
                "{BUTTON_NAME}" => ""
            ];

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (DestructuredException $e) {
            throw new DestructuredException($e);
        } catch (Exception $e) {
            throw new DestructuredException($e);
        }
    }

    public function sendAccountRecoveredEmail(int $user_id)
    {
        try {
            $user = new WP_User($user_id);
            $subject = 'Signup Email';
            $message = "Thanks for joining {$this->email->site_name}  {$user->first_name}";

            $content = [
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => "",
                "{BUTTON_NAME}" => ""
            ];

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (DestructuredException $e) {
            throw new DestructuredException($e);
        } catch (Exception $e) {
            throw new DestructuredException($e);
        }
    }
}
