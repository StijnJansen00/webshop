<?php
include 'db.php';
require '../fpdf/fpdf.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';
session_start();

$getSignature = $conn->prepare("SELECT signature FROM login WHERE loginID = ?");
$getSignature->execute([$_SESSION['loginID']]);
$signature = $getSignature->fetch();

$getOfferNuber = $conn->prepare("SELECT offerNumber FROM `offer` ORDER BY offerID DESC LIMIT 1");
$getOfferNuber->execute();

$resultOffer = $getOfferNuber->fetch();
$offerNr = (int)$resultOffer['offerNumber'];
$offerNr++;

$date = date("Y-m-d");
$untilDate = date('Y-m-d', strtotime($date . ' + 30 days'));
$x = count($_POST['products']['productID']);

$priceExcl = 0;
$priceIncl = 0;
define('EURO', chr(128));

$createOffer = $conn->prepare("INSERT INTO offer
    SET offerNumber = ?,
        offerDate = ?,
        offerCompany = ?,
        offerEmail = ?,
        offerName = ?,
        offerSurname = ?,
        offerStreet = ?,
        offerStrNumber = ?,
        offerZipcode = ?,
        offerCity = ?");
$createOffer->execute([
    $offerNr,
    $date,
    $_POST['companyName'],
    $_POST['email'],
    $_POST['name'],
    $_POST['surname'],
    $_POST['street'],
    $_POST['number'],
    $_POST['zipcode'],
    $_POST['city'],
]);
$offerID = $conn->lastInsertId();

for ($i = 0; $i < $x; $i++){
    $addProductToOffer = $conn->prepare("INSERT INTO offer_product SET offerID = ?, productID = ?, amount = ?");
    $addProductToOffer->execute([
        $offerID,
        $_POST['products']['productID'][$i],
        $_POST['products']['amount'][$i]
    ]);
}

if ($_POST['customEmail']){
    $message = "<p>" .$_POST['emailMessage'] . "</p>";
} else {
    $message = "<p>Geachte heer/mevrouw " . $_POST['surname'] . "</p>";
    $message .= "<br><p>";
    $message .= "Hartelijk dank voor uw offerte aanvraag. ";
    $message .= "Met genoegen bieden wij u vrijblijvend onze prijsopgave aan.<br>";
    $message .= "Deze treft u in de bijlage aan.<br>";
    $message .= "Heeft u vragen of opmerkingen naar aanleiding van deze offerte, neem dan gerust contact met mij op.";
    $message .= "</p>";
    $message .= "<br><br><p> Met vriendelijke groeten,</p>";
    $message .= "<p>" . $signature['signature'] . "</p>";
}

include 'createOffer.php';

include 'sendOfferMail.php';

$_SESSION['message'] = 'Offerte is aangemaakt en verzonden naar de ontvanger';
header("Location: ../admin_dashboard?adminPage=offers");
