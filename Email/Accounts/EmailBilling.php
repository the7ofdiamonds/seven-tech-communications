<?php

namespace SEVEN_TECH\Communications\Email\Accounts;

use Exception;

class EmailBilling
{
    public $header;
    private $body;
    public $footer;

    public function __construct()
    {
        $this->header = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailBillingHeader.php';
        $this->body = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailBillingBody.php';
        $this->footer = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailBillingFooter.php';
    }

    function billingHeader($billingType, $billingNumber, $billing, $customer)
    {
        try {
            $swap_var = array(
                "{BILLING_TYPE}" => $billingType,
                "{BILLING_NUMBER}" => $billingNumber,
                "{CUSTOMER_NAME}" => $customer->name,
                "{CUSTOMER_EMAIL}" => $customer->email,
                "{CUSTOMER_PHONE}" => $customer->phone,
                "{TAX_TYPE}" => $customer->tax_ids->data[0]->type,
                "{TAX_ID}" => $customer->tax_ids->data[0]->value,
                "{ADDRESS_LINE_1}" => $customer->address->line1,
                "{ADDRESS_LINE_2}" => $customer->address->line2,
                "{CITY}" => $customer->address->city,
                "{STATE}" => $customer->address->state,
                "{POSTAL_CODE}" => $customer->address->postal_code,
                "{DUE_DATE}" => (isset($billing->expires_at)) ? $billing->expires_at : $billing->due_date,
                "{AMOUNT_DUE}" => (isset($billing->amount_due)) ? $billing->amount_due : 0,
            );

            if (!file_exists($this->header)) {
                throw new Exception('Could not find billing header template.');
            }

            $bodyHeader = file_get_contents($this->header);

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

    function billingBody($lines)
    {
        try {
            $lineItems = [];

            foreach ($lines as $line) {
                $quantity = $line->quantity;
                $unit_price = $line->price->unit_amount / 100;

                $lineItem = [
                    "Product" => $line->price->product,
                    "Description" => $line->description,
                    "Quantity" => $quantity,
                    "Unit Price" => $unit_price,
                    "Total" => $quantity * $unit_price,
                ];

                $lineItems[] = $lineItem;
            }

            $swap_var = array(
                "{LINES}" => $lineItems,
            );

            if (!file_exists($this->body)) {
                throw new Exception('Could not find billing body template.');
            }

            $lines = file_get_contents($this->body);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($key === "{LINES}") {
                        $linesHtml = '';

                        foreach ($lineItems as $lineItem) {
                            $linesHtml .= '<tr>';
                            foreach ($lineItem as $value) {
                                $linesHtml .= '<td>' . $value . '</td>';
                            }
                            $linesHtml .= '</tr>';
                        }

                        $lines = str_replace($key, $linesHtml, $lines);
                    } else {
                        $lines = str_replace($key, $swap_var[$key], $lines);
                    }
                }
            }

            return $lines;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function billingFooter($billing)
    {
        try {
            $swap_var = array(
                "{SUBTOTAL}" => (isset($billing->amount_subtotal)) ? $billing->amount_subtotal : $billing->subtotal,
                "{TAX}" => (isset($billing->tax)) ? $billing->tax : 0,
                "{TOTAL}" => (isset($billing->amount_total)) ? $billing->amount_total : $billing->total,
            );

            if (!file_exists($this->footer)) {
                throw new Exception('Unable to find billing footer template.');
            }

            $bodyFooter = file_get_contents($this->footer);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($swap_var[$key] != '') {
                        $bodyFooter = str_replace($key, $swap_var[$key], $bodyFooter);
                    } else {
                        $bodyFooter = str_replace($key, '', $bodyFooter);
                    }
                }
            }

            return $bodyFooter;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
