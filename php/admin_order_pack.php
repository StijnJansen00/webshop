<?php
include "db.php";
require '../class/PostNL.class.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $orderID = htmlspecialchars($_POST['orderID']);
            $userID = htmlspecialchars($_POST['userID']);
            $sender = htmlspecialchars($_POST['sender']);

            $selectUserInfoSend = $conn->prepare("SELECT * FROM `user` WHERE userID = ?");
            $selectUserInfoSend->execute([$userID]);
            $user = $selectUserInfoSend->fetch();

            if ($sender === 'PostNL') {
                $barcodeObj = new PostNL();
                $barcodeRaw = $barcodeObj->createBarcode();
                $barcodeRaw1 = str_replace('{"Barcode":"', '', $barcodeRaw);
                $barcode = str_replace('"}', '', $barcodeRaw1);

                $labelObj = new PostNL();
                $labelRaw = $labelObj->createSendLabel($barcode, $user['city'], $user['name'], $user['number'], $user['surname'], $user['street'], $user['zipcode'], $user['email'], $user['phone']);

                $labelRaw1 = str_replace('{"MergedLabels":[],"ResponseShipments":[{"Barcode":"' . $barcode . '","Errors":[],"Warnings":[],"Labels":[{"Content":"', '', $labelRaw);
                $label = str_replace('","Labeltype":"Label","OutputType":"PDF"}],"ProductCodeDelivery":"3085"}]}', '', $labelRaw1);

                $decode = base64_decode($label);
                file_put_contents('../labelsToPrint/' . $barcode . '.jpg', $decode);

                $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ?, sender = ?, tracking = ? WHERE orderID = ?");
                $updateOrder->execute(['Ingepakt', $sender, $barcode, $orderID]);

            } else if ($sender === '4YouOffice') {
                $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ?, sender = ? WHERE orderID = ?");
                $updateOrder->execute(['Ingepakt', $sender, $orderID]);
            }

            include "mail_order_pack.php";

            $_SESSION['message'] = 'Bestelling ingepakt';
            header("Location: ../admin_order_overview?orderID=$orderID");

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}