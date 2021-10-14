<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if (!empty($_SESSION['orderInfo'])) {

    $orderInvoice = $_SESSION['orderInfo']['invoiceNr'];

    $filePath = 'uploads/';
    $filename = 'factuur-' . $orderInvoice;
    $file = md5($filename) . '.pdf';

    $from = 'contact@stijn-jansen.nl';
    $fromName = 'Office4You';
    $subject = 'Bestelling Office4You';

    if ($_SESSION['orderInfo']['companyName'] !== '-') {
        $name = $_SESSION['orderInfo']['name'] . " van " . $_SESSION['orderInfo']['companyName'] . ",";
    } else {
        $name = $_SESSION['orderInfo']['name'] . ",";
    }

// Email body content
    $text = "<p>Beste " . $name . "</p>";
    $text .= "<br><p>Bedankt voor uw bestelling bij Office4You.nl</p>";
    $text .= "<br><p>In de bijlage vind u uw factuur.</p>";
    $text .= "<br><p>Wij gaan aan de slag met uw bestelling!</p>";
    $text .= "<br><br><p> Met vriendelijke groeten,</p>";
    $text .= "<p>Klantenservice Office4You</p>";

    $text2 = "<p>Aanvraag van " . $name . "</p>";
    $text2 .= "<p>Verzenden naar:</p>";
    $text2 .= "<p>Adres: " . $_SESSION['orderInfo']['streetSend'] . " " . $_SESSION['orderInfo']['numberSend'] . " " . $_SESSION['orderInfo']['zipcodeSend'] . " " . $_SESSION['orderInfo']['citySend'] . "</p>";
    $text2 .= "<p>Email: " . $_SESSION['orderInfo']['email'] . "</p>";
    $text2 .= "<p>Mobiel: " . $_SESSION['orderInfo']['phoneSend'] . "</p>";
    $text2 .= "<p>Factuur van de bestelling in de bijlage</p>";

    $htmlContent = '<!DOCTYPE html>
                        <html>
                            <head>
                                <style>
                                    .container {
                                        margin: 1rem;
                                    }

                                    body {
                                        margin: 0;
                                    }

                                    h1 {
                                        color: #32A582;
                                        font-size: 2rem;
                                        font-weight: normal;
                                        margin-left: 1rem;
                                        margin: -1rem;
                                    }

                                    img {
                                        width: 20rem;
                                    }

                                    .footer {
                                        margin-bottom: 0;
                                        background: #32A582;
                                        width: 100%;
                                    }

                                    h2 {
                                        color: white;
                                        font-weight: normal;
                                        font-size: 1.5rem;
                                        margin: 0;
                                    }

                                    h3 {
                                        color: white;
                                        font-weight: bold;
                                        font-size: 2.5rem;
                                        margin: 0 1rem 0 auto;
                                    }

                                    td {
                                        padding: 1rem;
                                    }

                                    p {
                                        font-size: 1.25rem;
                                        margin: 0;
                                    }

                                    a {
                                        color: white !important;
                                        text-decoration: none;
                                    }

                                </style>
                            </head>

                            <body>
                                <div class="container">
                                    <img src="https://office4you.stijn-jansen.nl/img/logoo4y.png" alt="Logo office4you">
                                    <h1>Alles voor uw kantoor</h1>
                                    ' . $text . '
                                </div>
                                <div class="footer">
                                    <table style="width: 100%">
                                        <tr>
                                            <td>
                                                <h2>Office4You | Schumanpark 115 | 7336 AS Apeldoorn | <br> 055 2040808 </h2>
                                            </td>
                                            <td style="text-align: right">
                                                <h3><a href="https://www.office4you.nl">office4you.nl</a></h3>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </body>
                            </html>';

    $mailInvoice = new PHPMailer();
    $ownMailInvoice = new PHPMailer();

    try {
        $mailInvoice->isSMTP();
        $mailInvoice->Host = 'smtp.transip.email;';
        $mailInvoice->SMTPAuth = true;
        $mailInvoice->Username = 'contact@stijn-jansen.nl';
        $mailInvoice->Password = '7ZVDy$PwCJ-5LyR';
        $mailInvoice->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailInvoice->Port = 465;

        $mailInvoice->setFrom($from);
        $mailInvoice->addAddress($_SESSION['orderInfo']['email'], $_SESSION['orderInfo']['name'] . " " . $_SESSION['orderInfo']['surname']);
        $mailInvoice->addReplyTo($from, "Klantenservice Office4You");

        $mailInvoice->addAttachment($filePath . $file);

        $mailInvoice->isHTML(true);
        $mailInvoice->Subject = $subject;
        $mailInvoice->Body = $htmlContent;

        $ownMailInvoice->isSMTP();
        $ownMailInvoice->Host = 'smtp.transip.email;';
        $ownMailInvoice->SMTPAuth = true;
        $ownMailInvoice->Username = 'contact@stijn-jansen.nl';
        $ownMailInvoice->Password = '7ZVDy$PwCJ-5LyR';
        $ownMailInvoice->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $ownMailInvoice->Port = 465;

        $ownMailInvoice->setFrom($from);
        $ownMailInvoice->addAddress("stijnjansen00@gmail.com");

        $ownMailInvoice->addAttachment($filePath . $file);

        $ownMailInvoice->isHTML(true);
        $ownMailInvoice->Subject = $subject;
        $ownMailInvoice->Body = $text2;

        $mailInvoice->send();
        $ownMailInvoice->send();

//        unlink($orderInvoice);

    } catch (Exception $e) {
//        unlink($orderInvoice);
    }

}