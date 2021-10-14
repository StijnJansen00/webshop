<?php
namespace _PhpScoperfa6a84cfa6c2;
use Mollie\Api\Exceptions\ApiException;

try {

    require "initialize.php";
    include "db.php";

    $payment = $mollie->payments->get($_POST["id"]);
    $orderID = $payment->metadata->order_id;
    $date = date("Y-m-d");

    database_write($orderID, $payment->status);

    if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
        $execute = [$orderID, $date, $payment->status, "Betaald", $payment->id];
    } else if ($payment->isOpen()) {
        $execute = [$orderID, $date, $payment->status, "Open", $payment->id];
    } else if ($payment->isPending()) {
        $execute = [$orderID, $date, $payment->status, "Wordt verwerkt", $payment->id];
    } else if ($payment->isFailed()) {
        $execute = [$orderID, $date, $payment->status, "Mislukt", $payment->id];
    } else if ($payment->isExpired()) {
        $execute = [$orderID, $date, $payment->status, "Verlopen", $payment->id];
    } else if ($payment->isCanceled()) {
        $execute = [$orderID, $date, $payment->status, "Geannuleerd", $payment->id];
    } else if ($payment->hasRefunds()) {
        $execute = [$orderID, $date, $payment->status, "Terug betaald", $payment->id];
    } else if ($payment->hasChargebacks()) {
        $execute = [$orderID, $date, $payment->status, "Terug boeking", $payment->id];
    }

    $updateStatus = $conn->prepare("INSERT INTO `order` SET orderNumber = ?, orderDate = ?, paymentStatus = ?, orderStatus = ?, paymentID = ?");
    $updateStatus->execute($execute);

} catch (ApiException $e) {
    echo "API call failed: " . \htmlspecialchars($e->getMessage());
}
