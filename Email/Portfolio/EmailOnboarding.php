<?php

namespace SEVEN_TECH\Communications\Email\Portfolio;

use Exception;

use SEVEN_TECH\Communications\Email\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EmailOnboarding
{
    private $message;
    private $body;
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
        $this->email = new Email();
        $this->message = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailOnboardingMessage.php';
        $this->body = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailOnboarding.php';
        $this->mailer = $mailer;

        $this->smtp_host = get_option('support_smtp_host');
        $this->smtp_port = get_option('support_smtp_port');
        $this->smtp_secure = get_option('support_smtp_secure');
        $this->smtp_auth = get_option('support_smtp_auth');
        $this->smtp_username = get_option('support_smtp_username');
        $this->smtp_password = get_option('support_smtp_password');
        $this->from_email = get_option('support_email');
        $this->from_name = get_option('support_name');
    }

    function onboardingEmailMessage($customer, $receipt, $subject)
    {
        try {
            $swap_var = array(
                "{YOUR_NAME}" => $customer->first_name . ' ' . $customer->last_name,
                "{PAYMENT_AMOUNT}" => $receipt->amount_paid,
                "{YOUR_COMPANY_NAME}" => $customer->company_name,
                "{SUBJECT}" => $subject,
            );

            if (!file_exists($this->message)) {
                throw new Exception('Unable to find billing header template.');
            }

            $bodyMessage = file_get_contents($this->message);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($swap_var[$key] != '') {
                        $bodyMessage = str_replace($key, $swap_var[$key], $bodyMessage);
                    } else {
                        $bodyMessage = str_replace($key, '', $bodyMessage);
                    }
                }
            }

            return $bodyMessage;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function onboardingEmailBody($customer, $receipt, $subject)
    {
        try {
            $swap_var = array(
                "{YOUR_NAME}" => $customer->first_name . ' ' . $customer->last_name,
                "{PAYMENT_AMOUNT}" => $receipt->amount_paid,
                "{YOUR_COMPANY_NAME}" => $customer->company_name,
                "{SUBJECT}" => $subject,
                "{ONBOARDING_URL}" => $receipt->onboarding_link
            );

            if (!file_exists($this->body)) {
                throw new Exception('Unable to find billing header template.');
            }

            $bodyHeader = file_get_contents($this->body);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($swap_var[$key] != '') {
                        $bodyHeader = str_replace($key, $swap_var[$key], $bodyHeader);
                    } else {
                        $bodyHeader = str_replace($key, '', $bodyHeader);
                    }
                }
            }

            return $bodyHeader;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function emailBody($receipt, $customer, $subject)
    {
        try {
            $header = $this->email->emailHeader();
            $body = $this->onboardingEmailBody($customer, $receipt, $subject);
            $footer = $this->email->emailFooter();

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function sendOnboardingEmail($customer, $receipt)
    {
        try {
            $to_email = $customer->email;
            $name = $customer->name;
            $to_name = $name;

            $subject = 'Onboarding for ' . $receipt->project_name;

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
            $this->mailer->Body = $this->emailBody($customer, $receipt, $subject);
            $this->mailer->AltBody = $this->onboardingEmailMessage($customer, $receipt, $subject);

            // Make the body the pdf
            // if ($stripeInvoice->status === 'paid' || $stripeInvoice->status === 'open') {
            //     $path = $stripeInvoice->invoice_pdf;
            //     $attachment_name = $invoice_number . '.pdf';
            // }

            // if (isset($path) && isset($attachment_name)) {
            //     $this->mailer->addAttachment($path, $attachment_name, 'base64', 'application/pdf');
            // }

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
