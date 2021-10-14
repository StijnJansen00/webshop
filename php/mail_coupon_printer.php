<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$filePath = 'uploads/';
$coupon = 'cp-' . $orderInvoice . '.pdf';

$from = 'contact@4youoffice.nl';
$subject = 'CP 4YouOffice';

$printCoupon = new PHPMailer();

try {
    $printCoupon->isSMTP();
    $printCoupon->Host = "mail.mijndomein.nl";
    $printCoupon->SMTPAuth = true;
    $printCoupon->Username = "contact@4youoffice.nl";
    $printCoupon->Password = "z&$8BdF8V!TRGRe";
    $printCoupon->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $printCoupon->Port = 587;

    $printCoupon->addAttachment($filePath . $coupon);
    $printCoupon->AllowEmpty = true;
    $printCoupon->setFrom($from);
//    $printCoupon->addAddress('stijnjansen00@gmail.com');
    $printCoupon->addAddress('45c36x@hpeprint.com');
    $printCoupon->Subject = $subject;

    $printCoupon->send();

} catch (Exception $e) {
    $to = 'stijnjansen00@gmail.com';
    $subjectError = 'Pakbon printen mislukt';
    $messageError = 'Let op! Het printen van de pakbon is mislukt.';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "From: contact@4youoffice.nl";

    mail($to, $subjectError, $messageError, $headers);
}

