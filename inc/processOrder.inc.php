<?php
include 'php/db.php';
require 'fpdf/fpdf.php';

// Declaration of Info
$setInvoiceNumber = $conn->prepare("SELECT orderNumber FROM `order` ORDER BY orderID DESC LIMIT 1");
$setInvoiceNumber->execute();

$resultInvoice = $setInvoiceNumber->fetch();
$invoiceNr = (int)$resultInvoice['orderNumber'];
$invoiceNr++;

if (isset($_POST['checked']) && $_POST['checked'] === 'true') {
    $name = $_POST['invoiceName'];
    $surname = $_POST['invoiceSurname'];
    $phone = $_POST['invoicePhone'];
    $street = $_POST['invoiceStreet'];
    $number = $_POST['invoiceNumber'];
    $city = $_POST['invoiceCity'];
    $zipcode = $_POST['invoiceZipcode'];

    $nameSend = $_POST['name'];
    $surnameSend = $_POST['surname'];
    $phoneSend = $_POST['phone'];
    $streetSend = $_POST['street'];
    $numberSend = $_POST['number'];
    $citySend = $_POST['city'];
    $zipcodeSend = $_POST['zipcode'];
} else {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];

    $nameSend = $name;
    $surnameSend = $surname;
    $phoneSend = $phone;
    $streetSend = $street;
    $numberSend = $number;
    $citySend = $city;
    $zipcodeSend = $zipcode;
}

if (!empty($_POST['companyName'])) {
    $companyName = $_POST['$companyName'];
} else {
    $companyName = '-';
}

if (!empty($_POST['kvk'])) {
    $kvk = $_POST['kvk'];
} else {
    $kvk = '-';
}

$email = $_POST['email'];
$totalIncl = $_POST['totalIncl'];
$date = date("d-m-Y");
$untilDate = date('d-m-Y', strtotime($date . ' + 30 days'));

$_SESSION['orderInfo'] = [
    "name" => $name,
    "surname" => $surname,
    "companyName" => $companyName,
    "nameSend" => $nameSend . " " . $surnameSend,
    "streetSend" => $streetSend,
    "numberSend" => $numberSend,
    "zipcodeSend" => $zipcodeSend,
    "citySend" => $citySend,
    "email" => $email,
    "phoneSend" => $phoneSend,
    "invoiceNr" => $invoiceNr,
    "untilDate" => $untilDate,
    "kvk" => $kvk
];

include 'php/createInvoice.php';

include 'php/createPackageLabel.php';

include 'php/createPayment.php';
