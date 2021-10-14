<?php
include 'db.php';
require '../fpdf/fpdf.php';
session_start();
$info = explode(',', htmlspecialchars($_POST['info']));

$coupon = htmlspecialchars($info[20]);
$totalE = htmlspecialchars($_POST['price']);
$date = date("d-m-Y");

if (!empty($coupon)) {
    $checkCoupon = $conn->prepare("SELECT * FROM coupon WHERE coupon = ?");
    $checkCoupon->execute([$coupon]);
    if ($checkCoupon->rowCount() > 0) {
        $cop = $checkCoupon->fetch();
        if ($date <= strtotime($cop['endDate'])) {
            if ($cop['eur'] === '1') {
                $totalE = $totalE - $cop['value'];
                $eur = true;
                $cp = '€' . $cop['value'];
            } else {
                $totalE = $totalE - (($totalE / 100) * $cop['value']);
                $eur = false;
                $cp = $cop['value'] . '%';
            }
            $couponValue = $cop['value'];
        } else {
            $_SESSION['message'] = 'Kortingscode is ongeldig';
            header('Location: ../cart');
            die();
        }
    } else {
        $_SESSION['message'] = 'Kortingscode is ongeldig';
        header('Location: ../cart');
        die();
    }
} else {
    $coupon = '';
    $couponValue = '';
    $cp = '';
}

$setInvoiceNumber = $conn->prepare("SELECT numb FROM orderNumbers ORDER BY orderNumbersID DESC LIMIT 1");
$setInvoiceNumber->execute();
$resultInvoice = $setInvoiceNumber->fetch();
$invoiceNr = (int)$resultInvoice['numb'];
$invoiceNr++;

$saveOrderNumb = $conn->prepare("INSERT INTO orderNumbers SET numb = ?");
$saveOrderNumb->execute([$invoiceNr]);
$numbID = $conn->lastInsertId();

if (isset($info[0]) && $info[0] === 'true') {
    $name = htmlspecialchars($info[12]);
    $surname = htmlspecialchars($info[13]);
    $phone = htmlspecialchars($info[14]);
    $street = htmlspecialchars($info[15]);
    $number = htmlspecialchars($info[16]);
    $city = htmlspecialchars($info[17]);
    $zipcode = htmlspecialchars($info[18]);

    $nameSend = htmlspecialchars($info[3]);
    $surnameSend = htmlspecialchars($info[4]);
    $phoneSend = htmlspecialchars($info[6]);
    $streetSend = htmlspecialchars($info[7]);
    $numberSend = htmlspecialchars($info[8]);
    $citySend = htmlspecialchars($info[9]);
    $zipcodeSend = htmlspecialchars($info[10]);
} else {
    $name = htmlspecialchars($info[3]);
    $surname = htmlspecialchars($info[4]);
    $phone = htmlspecialchars($info[6]);
    $street = htmlspecialchars($info[7]);
    $number = htmlspecialchars($info[8]);
    $city = htmlspecialchars($info[9]);
    $zipcode = htmlspecialchars($info[10]);

    $nameSend = $name;
    $surnameSend = $surname;
    $phoneSend = $phone;
    $streetSend = $street;
    $numberSend = $number;
    $citySend = $city;
    $zipcodeSend = $zipcode;
}

if (!empty($info[1])) {
    $companyName = htmlspecialchars($info[1]);
} else {
    $companyName = '';
}

if (!empty($info[2])) {
    $kvk = htmlspecialchars($info[2]);
} else {
    $kvk = '';
}

$reference = htmlspecialchars($info[19]);
$email = htmlspecialchars($info[5]);
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
    "kvk" => $kvk,
    "reference" => $reference,
    "coupon" => $coupon,
    "couponValue" => $cp
];

$couponDate = date('Y-m-d', strtotime($date . ' + 1 year'));

function random_chars_generate($chars)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($data), 0, $chars);
}

$couponCode = random_chars_generate(10);

$addCoupon = $conn->prepare("INSERT INTO coupon SET coupon = ?, oneTime = ?, endDate = ?, `value` = ?, eur = ?");
$addCoupon->execute([$couponCode, '1', $couponDate, '5', '1']);

include 'create_invoice.php';

include 'create_package_label.php';

include 'create_coupon_pdf.php';

include 'create_order_payment.php';

$link = $link . '/true/303';
echo $link;
