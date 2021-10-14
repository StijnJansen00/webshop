<?php

class PaymentLinks
{

    public function createPaymentLink($amount, $desc)
    {
        try {
            require "../php/initialize.php";

            $paymentLink = $mollie->paymentLinks->create(
                [
                    "amount" => [
                        "currency" => "EUR",
                        "value" => $amount,
                    ],
                    "description" => $desc,
                    "redirectUrl" => "https://4YouOffice.4youoffice.nl/paymentLink",
                ]
            );

            return $paymentLink->getCheckoutUrl();

        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            return "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }

}

//include "class/PaymentLink.class.php";
//
//$amount = '35.99';
//$desc = 'Test 123';
//$expiresAt = '2021-08-13T00:00:00+00:00';
//
//$paymentObj = new PaymentLinks();
//$payment = $paymentObj->createPaymentLink($amount, $desc);
//
//
//echo $payment;
