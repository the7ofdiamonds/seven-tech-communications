<?php

namespace SEVEN_TECH\Communications\Email;

use Exception;

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

class EmailReceipt
{
    private $email;
    private $billing;
    private $pdf;
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
        $this->billing = new EmailBilling();
        $this->mailer = $mailer;
        // $this->pdf = $pdf;

        $this->smtp_host = get_option('receipt_smtp_host');
        $this->smtp_port = get_option('receipt_smtp_port');
        $this->smtp_secure = get_option('receipt_smtp_secure');
        $this->smtp_auth = get_option('receipt_smtp_auth');
        $this->smtp_username = get_option('receipt_smtp_username');
        $this->smtp_password = get_option('receipt_smtp_password');
        $this->from_email = get_option('receipt_email');
        $this->from_name = get_option('receipt_name');
    }

    function receiptEmailBodyHeader($invoice, $customer)
    {
        try {
            $swap_var = array(
                "{BILLING_TYPE}" => 'RECEIPT',
                "{BILLING_NUMBER}" => 'RE' . $invoice->id,
                "{CUSTOMER_NAME}" => $customer->name,
                "{CUSTOMER_EMAIL}" => $customer->email,
                "{TAX_TYPE}" => $customer->tax_ids[0]->type,
                "{TAX_ID}" => $customer->tax_ids[0]->value,
                "{ADDRESS_LINE_1}" => $customer->address->line1,
                "{ADDRESS_LINE_2}" => $customer->address->line2,
                "{CITY}" => $customer->address->city,
                "{STATE}" => $customer->address->state,
                "{POSTAL_CODE}" => $customer->address->postal_code,
                "{CUSTOMER_PHONE}" => $customer->phone,
                "{DUE_DATE}" => $invoice->due_date,
                "{AMOUNT_DUE}" => $invoice->amount_due,
            );

            if (!file_exists($this->billing->header)) {
                throw new Exception('Unable to find billing header template.');
            }

            $bodyHeader = file_get_contents($this->billing->header);

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

    public function receiptEmailBody($receipt, $customer)
    {
        try {
            $header = $this->email->emailHeader();
            $bodyHeader = $this->receiptEmailBodyHeader($receipt, $customer);
            $bodyBody = $this->billing->billingBody($receipt->lines);
            $bodyFooter = $this->billing->billingFooter($receipt);
            $footer = $this->email->emailFooter();

            $fullEmailBody = $header . $bodyHeader . $bodyBody . $bodyFooter . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendReceiptEmail($customer, $receipt)
    {
        $to_email = $customer->email;
        $receipt_number = 'Receipt #' . $receipt['id'];
        $name =  $customer->name;
        $to_name = $name;

        $subject = $receipt_number . ' for ' . $name;

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
            $this->mailer->Body = $this->receiptEmailBody($receipt, $customer);
            $this->mailer->AltBody = '<pre>' . $receipt . '</pre>';

            // Make the body the pdf
            // if ($stripeInvoice->status === 'paid' || $stripeInvoice->status === 'open') {
            //     $path = $stripeInvoice->receipt_pdf;
            //     $attachment_name = $receipt_number . '.pdf';
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
