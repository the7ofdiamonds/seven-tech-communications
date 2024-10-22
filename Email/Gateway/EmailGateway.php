<?php

namespace SEVEN_TECH\Communications\Email\Gateway;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class EmailGateway
{
    public $site_name;
    private string $deletionTime;
    private string $confirmationCodeExpiration;

    public function __construct()
    {
        $this->site_name = get_bloginfo('name');
        $this->deletionTime = '90 Days';
        $this->confirmationCodeExpiration = '15 minutes';
    }

    public function send(WP_User $user, string $subject, string $message, array $content): bool
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

            $template = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailGateway.php';

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

    public function sendSignUpEmail(int $user_id)
    {
        try {

            $user = new WP_User($user_id);

            $subject = 'Signup Email';

            $message = "Thanks for joining {$this->site_name}  {$user->first_name}";

            $content = [
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => "",
                "{BUTTON_NAME}" => ""
            ];

            $this->send($user, $subject, $message, $content);

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendActivateAccountEmail(int $user_id) {}

    public function sendAccountLockedEmail(int $user_id) {}

    public function sendAccountUnlockedEmail(int $user_id) {}

    public function sendAccountRecoveredEmail(int $user_id) {}
}
