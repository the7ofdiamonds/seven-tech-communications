<?php

namespace SEVEN_TECH\Communications\Email;

use Exception;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EmailSchedule
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

    public function __construct(PHPMailer $mailer)
    {
        $this->smtp_host = get_option('schedule_smtp_host');
        $this->smtp_port = get_option('schedule_smtp_port');
        $this->smtp_secure = get_option('schedule_smtp_secure');
        $this->smtp_auth = get_option('schedule_smtp_auth');
        $this->smtp_username = get_option('schedule_smtp_username');
        $this->smtp_password = get_option('schedule_smtp_password');
        $this->from_name = get_option('schedule_email');
        $this->from_name = get_option('schedule_name');

        $this->email = new Email();
        $this->mailer = $mailer;
    }

    public function scheduleEmailBody($first_name, $last_name, $email, $subject, $message)
    {
        try {
            $scheduleEmailBodyTemplate = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailBodySchedule.php';

            $swap_var = array(
                "{EMAIL}" => $email,
                "{FIRST_NAME}" => $first_name,
                "{LAST_NAME}" => $last_name,
                "{SUBJECT}" => $subject,
                "{MESSAGE}" => $message
            );

            if (file_exists($scheduleEmailBodyTemplate)) {
                throw new Exception('Unable to locate schedule email template.');
            }

            $body = file_get_contents($scheduleEmailBodyTemplate);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    $body = str_replace($key, $swap_var[$key], $body);
                }
            }

            $header = $this->email->emailHeader();
            $footer = $this->email->emailFooter();

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendScheduleEmail($first_name, $last_name, $email, $subject, $message)
    {
        try {
            $this->mailer->isSMTP();
            $this->mailer->SMTPAuth = $this->smtp_auth;
            $this->mailer->Host = $this->smtp_host;
            $this->mailer->SMTPSecure = $this->smtp_secure;
            $this->mailer->Port = $this->smtp_port;

            $this->mailer->Username = $this->smtp_username;
            $this->mailer->Password = $this->smtp_password;

            $this->mailer->setFrom($this->from_email, $this->from_name);
            $this->mailer->addAddress($email, $first_name . ' ' . $last_name); //Add more addresses
            $this->mailer->addReplyTo($this->from_email, $this->from_name);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $this->scheduleEmailBody($first_name, $last_name, $email, $subject, $message);
            $this->mailer->AltBody = $message;

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
