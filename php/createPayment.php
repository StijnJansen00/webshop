<?php
namespace _PhpScoperfa6a84cfa6c2;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\PaymentMethod;

try {
    require "initialize.php";

    $orderID = $invoiceNr;

    $protocol = isset($_SERVER['HTTPS']) && \strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
    $hostname = $_SERVER['HTTP_HOST'];

    $payment = $mollie->payments->create(
        [
            "amount" => [
                "currency" => "EUR",
                "value" => $totalIncl
            ],
            "metadata" => [
                "order_id" => $orderID
            ],
            "method" => PaymentMethod::IDEAL,
            "description" => "Order #{$orderID}",
            "redirectUrl" => "{$protocol}://{$hostname}/orderResult?id=$invoiceNr",
            "webhookUrl" => "{$protocol}://{$hostname}/php/payment_webhook.php",
            "issuer" => !empty($_POST["issuer"]) ? $_POST["issuer"] : null
        ]
    );

    database_write($orderID, $payment->status);
    header("Location: " . $payment->getCheckoutUrl(), \true, 303);

} catch (ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}
