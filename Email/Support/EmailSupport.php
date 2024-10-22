<?php

namespace SEVEN_TECH\Communications\Email\Support;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;

use WP_User;

class EmailSupport
{

    public function message(WP_User $user)
    {
        return "Thank You, {$user->first_name}. Your message has been sent, and a reply will be sent to {$user->user_email}";
    }

    function send(WP_User $user, string $subject, string $message, array $content)
    {
        try {
            $smtp_host = get_option('support_smtp_host');
            $smtp_port = get_option('support_smtp_port');
            $smtp_secure = get_option('support_smtp_secure');
            $smtp_auth = get_option('support_smtp_auth');
            $smtp_username = get_option('support_smtp_username');
            $smtp_password = get_option('support_smtp_password');
            $from_email = get_option('support_email');
            $from_name = get_option('support_name');

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

    public function sendSupportEmail($user, $subject, $message)
    {
        $content = array();
        $this->send($user, $subject, $message, $content);
    }
}
