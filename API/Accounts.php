<?php

namespace SEVEN_TECH\Communications\API;

use SEVEN_TECH\Communications\Email\Accounts\EmailQuote;
use SEVEN_TECH\Communications\Email\Accounts\EmailInvoice;
use SEVEN_TECH\Communications\Email\Accounts\EmailReceipt;

use Exception;

use WP_REST_Request;

use PHPMailer\PHPMailer\PHPMailer;

class Accounts
{
    private $mailer;
    private $quoteEmail;
    private $invoiceEmail;
    private $receiptEmail;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->quoteEmail = new EmailQuote($this->mailer);
        $this->invoiceEmail = new EmailInvoice($this->mailer);
        $this->receiptEmail = new EmailReceipt($this->mailer);
    }

    public function send_quote_email(WP_REST_Request $request)
    {
        try {
            $customer = $request['customer'];
            $quote = $request['quote'];

            if (empty($customer)) {
                $statusCode = 400;
                throw new Exception('Customer is required to send quote email.', $statusCode);
            }

            if (empty($quote)) {
                $statusCode = 400;
                throw new Exception('Quote is required to send quote email.', $statusCode);
            }

            $quoteEmail = $this->quoteEmail->sendQuoteEmail($customer, $quote);

            return rest_ensure_response($quoteEmail);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function send_invoice_email(WP_REST_Request $request)
    {
        try {
            $customer = $request['customer'];
            $invoice = $request['invoice'];

            if (empty($customer)) {
                $statusCode = 400;
                throw new Exception('Customer is required to send invoice email.', $statusCode);
            }

            if (empty($invoice)) {
                $statusCode = 400;
                throw new Exception('Invoice is required to send invoice email.', $statusCode);
            }

            $invoiceEmail = $this->invoiceEmail->sendInvoiceEmail($customer, $invoice);

            return rest_ensure_response($invoiceEmail);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function send_receipt_email(WP_REST_Request $request)
    {
        try {
            $customer = $request['customer'];
            $receipt = $request['receipt'];

            if (empty($customer)) {
                $statusCode = 400;
                throw new Exception('Customer is required to send receipt email.', $statusCode);
            }

            if (empty($receipt)) {
                $statusCode = 400;
                throw new Exception('Receipt is required to send receipt email.', $statusCode);
            }

            $receiptEmail = $this->receiptEmail->sendReceiptEmail($customer, $receipt);

            return rest_ensure_response($receiptEmail);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }
}
