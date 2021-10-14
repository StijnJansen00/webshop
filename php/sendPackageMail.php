<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if (!empty($_SESSION['orderInfo'])) {

    $orderInvoice = $_SESSION['orderInfo']['invoiceNr'];

    $filePath = 'uploads/';
    $filename = 'pakbon-' . $orderInvoice;
    $file = md5($filename).'.pdf';

    $from = 'contact@stijn-jansen.nl';
    $subject = 'Pakbon Office4You';

    $mailPackageLabel = new PHPMailer();

    try {
        $mailPackageLabel->isSMTP();
        $mailPackageLabel->Host = 'smtp.transip.email;';
        $mailPackageLabel->SMTPAuth = true;
        $mailPackageLabel->Username = 'contact@stijn-jansen.nl';
        $mailPackageLabel->Password = '7ZVDy$PwCJ-5LyR';
        $mailPackageLabel->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailPackageLabel->Port = 465;

//        $mailPackageLabel->isHTML(true);
//        $mailPackageLabel->Body = "Pakbon Verzonden";

        $mailPackageLabel->addAttachment($filePath . $file);
        $mailPackageLabel->AllowEmpty = true;

        $mailPackageLabel->setFrom($from);
        $mailPackageLabel->addAddress('stijnjansen00@gmail.com');
//        $mailPackageLabel->addAddress('45c36x@hpeprint.com');
        $mailPackageLabel->Subject = $subject;

        $mailPackageLabel->send();

//        unlink($orderInvoice);

    } catch (Exception $e) {
//        unlink($orderInvoice);
    }

}