<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'user') {
        if (isset($_POST["submit"])) {
            $offerID = htmlspecialchars($_POST['offerID']);

            $getOfferInfo = $conn->prepare("SELECT * FROM offer f INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber WHERE f.offerID = ?");
            $getOfferInfo->execute([$offerID]);
            $offerInfo = $getOfferInfo->fetch();
            $totalIncl = $offerInfo['offerPriceTotal'];
            $invoiceNr = $offerInfo['numb'];
            $numbID = $offerInfo['offerNumber'];

            include 'create_offer_payment.php';

        } else {
            header('Location: ../404');
        }
    } else {
        header('Location: ../404');
    }
} else {
    header('Location: ../404');
}