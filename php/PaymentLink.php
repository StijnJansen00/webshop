<?php

class PaymentLinks
{

    public function createPaymentLink($amount, $desc)
    {
        try {
            require "initialize.php";

            $paymentLink = $mollie->paymentLinks->create(
                [
                    "amount" => [
                        "currency" => "EUR",
                        "value" => $amount,
                    ],
                    "description" => $desc,
                    "redirectUrl" => "https://www.4youoffice.nl/paymentLink",
                ]
            );

            return $paymentLink->getCheckoutUrl();

        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            return "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }

}
