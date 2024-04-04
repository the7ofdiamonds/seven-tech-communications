<?php

namespace SEVEN_TECH\Communications\Email;

use Exception;

use SEVEN_TECH\Communications\Database\DatabaseReceipt;
use SEVEN_TECH\Communications\API\Stripe\StripeInvoice;

use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EmailOnboarding
{
    private $database_receipt;
    private $stripe_invoice;
    private $message;
    private $onboarding_link;
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

    public function __construct($stripeClient, $mailer)
    {
        $this->database_receipt = new DatabaseReceipt();
        $this->stripe_invoice = new StripeInvoice($stripeClient);
        $this->email = new Email();
        $this->message = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailOnboardingMessage.php';
        $this->onboarding_link = esc_url(home_url()) . '/services/service/on-boarding/';
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

    function onboardingEmailMessage($databaseReceipt, $stripeInvoice, $subject)
    {
        $swap_var = array(
            "{YOUR_NAME}" => $databaseReceipt['first_name'] . ' ' . $databaseReceipt['last_name'],
            "{PAYMENT_AMOUNT}" => $stripeInvoice->amount_paid,
            "{YOUR_COMPANY_NAME}" => $stripeInvoice->customer_name,
            "{SUBJECT}" => $subject,
        );

        if (file_exists($this->message)) {
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
        } else {
            throw new Exception('Unable to find billing header template.');
        }

        return $bodyMessage;
    }

    function onboardingEmailBody($databaseReceipt, $stripeInvoice, $subject, $onboarding_link)
    {
        $swap_var = array(
            "{YOUR_NAME}" => $databaseReceipt['first_name'] . ' ' . $databaseReceipt['last_name'],
            "{PAYMENT_AMOUNT}" => $stripeInvoice->amount_paid,
            "{YOUR_COMPANY_NAME}" => $stripeInvoice->customer_name,
            "{SUBJECT}" => $subject,
            "{ONBOARDING_URL}" => $onboarding_link
        );

        if (file_exists($this->body)) {
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
        } else {
            throw new Exception('Unable to find billing header template.');
        }

        return $bodyHeader;
    }

    function emailBody($databaseReceipt, $stripeInvoice, $subject, $onboarding_link)
    {
        $header = $this->email->emailHeader();
        $body = $this->onboardingEmailBody($databaseReceipt, $stripeInvoice, $subject, $onboarding_link);
        $footer = $this->email->emailFooter();

        $fullEmailBody = $header . $body . $footer;

        return $fullEmailBody;
    }

    function sendOnboardingEmail($stripe_invoice_id, $stripe_customer_id)
    {
        try {
            $databaseReceipt = $this->database_receipt->getReceipt($stripe_invoice_id, $stripe_customer_id);
            $stripeInvoice = $this->stripe_invoice->getStripeInvoice($databaseReceipt['stripe_invoice_id']);

            $onboarding_link = $databaseReceipt['onboarding_link'];

            $to_email = $stripeInvoice->customer_email;
            $name = $stripeInvoice->customer_name;
            $to_name = $name;

            $subject = 'Onboarding for Receipt# ' . $databaseReceipt['id'];

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
            $this->mailer->Body = $this->emailBody($databaseReceipt, $stripeInvoice, $subject, $onboarding_link);
            $this->mailer->AltBody = $this->onboardingEmailMessage($databaseReceipt, $stripeInvoice, $subject);

            // Make the body the pdf
            // if ($stripeInvoice->status === 'paid' || $stripeInvoice->status === 'open') {
            //     $path = $stripeInvoice->invoice_pdf;
            //     $attachment_name = $invoice_number . '.pdf';
            // }

            // if (isset($path) && isset($attachment_name)) {
            //     $this->mailer->addAttachment($path, $attachment_name, 'base64', 'application/pdf');
            // }

            if ($this->mailer->send()) {
                return ['message' => 'Message has been sent'];
            } else {
                throw new PHPMailerException("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }
}
