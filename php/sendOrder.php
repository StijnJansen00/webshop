<?php
include "db.php";
require 'PostNL.class.php';
session_start();

$orderID = $_POST['orderID'];
$orderNumber = $_POST['orderNumber'];
$userID = $_POST['userID'];
$sender = $_POST['sender'];

$selectUserInfoSend = $conn->prepare("SELECT * FROM `user` WHERE userID = ?");
$selectUserInfoSend->execute([$userID]);
$user = $selectUserInfoSend->fetch();

if ($sender === 'PostNL'){
    $barcodeObj = new PostNL();
    $barcodeRaw = $barcodeObj->createBarcode();
    $barcodeRaw1 = str_replace('{"Barcode":"', '', $barcodeRaw);
    $barcode = str_replace('"}', '', $barcodeRaw1);

    $labelObj = new PostNL();
    $labelRaw = $labelObj->createSendLabel($barcode, $user['city'], $user['name'], $user['number'], $user['surname'], $user['street'], $user['zipcode'], $user['email'], $user['phone']);

    $labelRaw1 = str_replace('{"MergedLabels":[],"ResponseShipments":[{"Barcode":"' . $barcode . '","Errors":[],"Warnings":[],"Labels":[{"Content":"', '', $labelRaw);
    $label = str_replace('","Labeltype":"Label","OutputType":"PDF"}],"ProductCodeDelivery":"3085"}]}', '', $labelRaw1);

    $decode = base64_decode($label);
    file_put_contents('../labelsToPrint/' . $barcode . '.pdf', $decode);

    $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ?, sender = ?, tracking = ? WHERE orderID = ?");
    $updateOrder->execute(['Verzonden', $sender, $barcode, $orderID]);

} else if ($sender === 'Office4You') {
    $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ?, sender = ? WHERE orderID = ?");
    $updateOrder->execute(['Verzonden', $sender, $orderID]);
}

include "sendOrderMail.php";

$_SESSION['message'] = 'Bestelling verzonden';
header("Location: ../admin_order_overview?orderID=$orderID");