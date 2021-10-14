<?php

namespace _PhpScoper49d996c9b91b;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\PaymentMethod;

try {
    require "initialize.php";

    if (!strpos($totalIncl, '.')) {
        $totalIncl .= '.00';
    }

    $protocol = isset($_SERVER['HTTPS']) && \strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
    $hostname = $_SERVER['HTTP_HOST'];

    $payment = $mollie->payments->create(
        [
            "amount" => [
                "currency" => "EUR",
                "value" => $totalIncl
            ],
            "method" => PaymentMethod::IDEAL,
            "description" => "Order #$invoiceNr",
            "redirectUrl" => "{$protocol}://{$hostname}/offerToOrder?order=$numbID&offer=$offerID",
            "webhookUrl" => "{$protocol}://{$hostname}/php/payment_webhook.php",
            "metadata" => [
                "order_id" => $invoiceNr
            ],
            "issuer" => !empty($_POST["issuer"]) ? $_POST["issuer"] : null
        ]
    );

    database_write($invoiceNr, $payment->status);

    header("Location: " . $payment->getCheckoutUrl(), \true, 303);

} catch (ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}

