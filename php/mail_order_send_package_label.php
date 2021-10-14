<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION['orderInfo'])) {
    $orderInvoice = $_SESSION['orderInfo']['invoiceNr'];
} else {
    $orderInvoice = $order['numb'];
}

$filePath = 'uploads/';
$packageLabel = 'pakbon-' . $orderInvoice . '.pdf';

$from = 'contact@4youoffice.nl';
$subject = 'PB 4YouOffice';

$printPackageLabel = new PHPMailer();

try {
    $printPackageLabel->isSMTP();
    $printPackageLabel->Host = "mail.mijndomein.nl";
    $printPackageLabel->SMTPAuth = true;
    $printPackageLabel->Username = "contact@4youoffice.nl";
    $printPackageLabel->Password = "z&$8BdF8V!TRGRe";
    $printPackageLabel->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $printPackageLabel->Port = 587;

    $printPackageLabel->setFrom($from);
//    $printPackageLabel->addAddress('stijnjansen00@gmail.com');
    $printPackageLabel->addAddress('45c36x@hpeprint.com');
    $printPackageLabel->Subject = $subject;

    $printPackageLabel->AllowEmpty = true;
    $printPackageLabel->addAttachment($filePath . $packageLabel);

    $printPackageLabel->send();

} catch (Exception $e) {
    $to = 'stijnjansen00@gmail.com';
    $subjectError = 'Pakbon printen mislukt';
    $messageError = 'Let op! Het printen van de pakbon is mislukt.';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "From: contact@4youoffice.nl";

    mail($to, $subjectError, $messageError, $headers);
}

