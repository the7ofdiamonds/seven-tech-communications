<?php

namespace SEVEN_TECH\Communications\Email\Gateway;

use Exception;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EmailGatewayLink
{
    private $email;
    private $mailer;
    private $smtp_host;
    private $smtp_port;
    private $smtp_secure;
    private $smtp_auth;
    private $smtp_username;
    private $smtp_password;
    private $from_email;
    private $from_name;
    private $body;

    public function __construct(PHPMailer $mailer)
    {
        $this->smtp_host = get_option('quote_smtp_host');
        $this->smtp_port = get_option('quote_smtp_port');
        $this->smtp_secure = get_option('quote_smtp_secure');
        $this->smtp_auth = get_option('quote_smtp_auth');
        $this->smtp_username = get_option('quote_smtp_username');
        $this->smtp_password = get_option('quote_smtp_password');
        $this->from_email = get_option('quote_email');
        $this->from_name = get_option('quote_name');

        $this->email = new Email();
        $this->mailer = $mailer;
        $this->body = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailGatewayLink.php';
    }

    function gatewayBody($message, $link, $buttonName)
    {
        try {
            $swap_var = array(
                "{MESSAGE}" => $message,
                "{GATEWAY_URL}" => $link,
                "{BUTTON_NAME}" => $buttonName
            );

            if (!file_exists($this->body)) {
                throw new Exception('Could not find gateway body template.');
            }

            $body = file_get_contents($this->body);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($swap_var[$key] != '') {
                        $body = str_replace($key, $swap_var[$key], $body);
                    } else {
                        $body = str_replace($key, '', $body);
                    }
                }
            }

            return $body;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function gatewayEmailBody($message, $link, $buttonName)
    {
        try {
            $header = $this->email->emailHeader();
            $body = $this->gatewayBody($message, $link, $buttonName);
            $footer = $this->email->emailFooter();

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendGatewayEmail($user, $subject, $message, $link, $buttonName)
    {
        $to_email = $user->email;
        $name =  $user->name;
        $to_name = $name;

        try {
            $this->mailer->isSMTP();
            $this->mailer->SMTPAuth = $this->smtp_auth;
            $this->mailer->Host = $this->smtp_host;
            $this->mailer->SMTPSecure = $this->smtp_secure;
            $this->mailer->Port = $this->smtp_port;

            $this->mailer->Username = $this->smtp_username;
            $this->mailer->Password = $this->smtp_password;

            $this->mailer->setFrom($this->from_email, $this->from_name);
            $this->mailer->addAddress($to_email, $to_name);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $this->gatewayEmailBody($message, $link, $buttonName);
            $this->mailer->AltBody = '<pre>' . $message . '</pre>';

            $this->mailer->send();

            if ($this->mailer->ErrorInfo) {
                throw new PHPMailerException("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            }

            return 'Message has been sent';
        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
