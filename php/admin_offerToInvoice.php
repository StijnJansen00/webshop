<?php
include 'db.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        $offerID = $_POST['offerID'];
        $idealLink = $_POST['idealLink'];

        $getSignature = $conn->prepare("SELECT signature FROM login WHERE loginID = ?");
        $getSignature->execute([$_SESSION['loginID']]);
        $signature = $getSignature->fetch();

        $setInvoiceNumber = $conn->prepare("SELECT orderNumber FROM `order` ORDER BY orderID DESC LIMIT 1");
        $setInvoiceNumber->execute();
        $resultInvoice = $setInvoiceNumber->fetch();
        $invoiceNr = (int)$resultInvoice['orderNumber'];
        $invoiceNr++;

        $getOfferInfo = $conn->prepare("SELECT * FROM offer WHERE offerID = ?");
        $getOfferInfo->execute([$offerID]);
        $resultInfo = $getOfferInfo->fetch();

        $selectOfferproducts = $conn->prepare("SELECT productID, amount FROM offer_product WHERE offerID = ?");
        $selectOfferproducts->execute([$offerID]);

        $date = date("d-m-Y");
        $untilDate = date('d-m-Y', strtotime($date . ' + 30 days'));

        $name = $resultInfo['offerName'] . ' ' . $resultInfo['offerSurname'];
        $surname = $resultInfo['offerSurname'];
        $companyName = $resultInfo['offerCompany'];
        $street = $resultInfo['offerStreet'];
        $number = $resultInfo['offerStrNumber'];
        $zipcode = $resultInfo['offerZipcode'];
        $city = $resultInfo['offerCity'];
        $email = $resultInfo['offerEmail'];
        $emailMessage = $_POST['emailMessage'];
        $phone = '-';
        $kvk = '-';

        include 'admin_offerToInvoicePDF.php';
        include 'sendOfferToInvoiceMail.php';

        $_SESSION['message'] = 'Offerte is nu een fuctuur';
        header("Location: ../admin_offer_overview?offerNr=$offerID");

    }
}