<?php

namespace SEVEN_TECH\Communications\API;

use SEVEN_TECH\Communications\Email\EmailQuote;
use SEVEN_TECH\Communications\Email\EmailInvoice;
use SEVEN_TECH\Communications\Email\EmailOnboarding;
use SEVEN_TECH\Communications\Email\EmailReceipt;

use WP_REST_Request;

class Email
{
    private $stripeClient;
    private $mailer;

    public function __construct($stripeClient, $mailer)
    {
        $this->stripeClient = $stripeClient;
        $this->mailer = $mailer;
    }

    public function send_quote_email(WP_REST_Request $request)
    {
        $quote_email = new EmailQuote($this->stripeClient, $this->mailer);
        $stripe_quote_id = $request->get_param('slug');

        if (empty($stripe_quote_id)) {
            $msg = 'Quote ID is required';
        }

        if (isset($msg)) {
            $message = array(
                'message' => $msg,
            );
            $response = rest_ensure_response($message);
            $response->set_status(400);
            return $response;
        }

        $quoteEmail = $quote_email->sendQuoteEmail($stripe_quote_id);

        return rest_ensure_response($quoteEmail);
    }

    public function send_invoice_email(WP_REST_Request $request)
    {
        $invoice_email = new EmailInvoice($this->stripeClient, $this->mailer);
        $stripe_invoice_id = $request->get_param('slug');

        if (empty($stripe_invoice_id)) {
            $msg = 'Invoice ID is required';
        }

        if (isset($msg)) {
            $message = array(
                'message' => $msg,
            );
            $response = rest_ensure_response($message);
            $response->set_status(400);
            return $response;
        }

        $invoiceEmail = $invoice_email->sendInvoiceEmail($stripe_invoice_id);

        return rest_ensure_response($invoiceEmail);
    }

    public function send_receipt_email(WP_REST_Request $request)
    {
        $receipt_email = new EmailReceipt($this->stripeClient, $this->mailer);

        $stripe_invoice_id = $request->get_param('slug');

        if (empty($stripe_invoice_id)) {
            $msg = 'Invoice ID is required';
        }

        if (isset($msg)) {
            $message = array(
                'message' => $msg,
            );
            $response = rest_ensure_response($message);
            $response->set_status(400);
            return $response;
        }

        $receiptEmail = $receipt_email->sendReceiptEmail($stripe_invoice_id);

        return rest_ensure_response($receiptEmail);
    }

    public function send_onboarding_email(WP_REST_Request $request)
    {
        $onboarding_email = new EmailOnboarding($this->stripeClient, $this->mailer);

        $stripe_invoice_id = $request->get_param('slug');

        $project_name = $request['project_name'];

        if (empty($stripe_invoice_id)) {
            $msg = 'Stripe Invoice ID is required';
        }

        if (empty($project_name)) {
            $msg = 'Project name is required';
        }

        if (isset($msg)) {
            $message = array(
                'message' => $msg,
            );
            $response = rest_ensure_response($message);
            $response->set_status(400);
            return $response;
        }

        $onboardingEmail = $onboarding_email->sendOnboardingEmail($stripe_invoice_id, $project_name);

        return rest_ensure_response($onboardingEmail);
    }
}
