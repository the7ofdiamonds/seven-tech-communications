<?php

namespace SEVEN_TECH\Communications\Email;

use Exception;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EmailInvoice
{
    private $email;
    private $billing;
    private $billingType;
    private $billingNumberPrefix;
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
        $this->smtp_host = get_option('invoice_smtp_host');
        $this->smtp_port = get_option('invoice_smtp_port');
        $this->smtp_secure = get_option('invoice_smtp_secure');
        $this->smtp_auth = get_option('invoice_smtp_auth');
        $this->smtp_username = get_option('invoice_smtp_username');
        $this->smtp_password = get_option('invoice_smtp_password');
        $this->from_email = get_option('invoice_email');
        $this->from_name = get_option('invoice_name');

        $this->email = new Email();
        $this->billing = new EmailBilling();
        $this->billingType = 'INVOICE';
        $this->billingNumberPrefix = 'IN';
        $this->mailer = $mailer;
        // $this->pdf = $pdf;
    }

    function invoiceEmailBody($billingNumber, $invoice, $customer)
    {
        try {
            $header = $this->email->emailHeader();
            $bodyHeader = $this->billing->billingHeader($this->billingType, $billingNumber, $invoice, $customer);
            $bodyBody = $this->billing->billingBody($invoice->lines);
            $bodyFooter = $this->billing->billingFooter($invoice);
            $footer = $this->email->emailFooter();

            $fullEmailBody = $header . $bodyHeader . $bodyBody . $bodyFooter . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function sendInvoiceEmail($customer, $invoice)
    {
        try {
            $to_email = $customer->email;
            $billingNumber = $this->billingNumberPrefix . $invoice->id;
            $name =  $customer->name;
            $to_name = $name;

            $subject = $billingNumber . ' for ' . $name;

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
            $this->mailer->Body = $this->invoiceEmailBody($billingNumber, $invoice, $customer);
            $this->mailer->AltBody = '<pre>' . $invoice . '</pre>';

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
