<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


$filePath = '../uploads/';
$filename = 'offerte-' . $offerNr;
$file = md5($filename) . '.pdf';

$from = 'contact@stijn-jansen.nl';
$fromName = 'Office4You';
$subject = 'Offerte Office4You';

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
                                    ' . $message . '
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

$mailOffer = new PHPMailer();
$mailOwnOffer = new PHPMailer();

try {
    $mailOffer->isSMTP();
    $mailOffer->Host = 'smtp.transip.email;';
    $mailOffer->SMTPAuth = true;
    $mailOffer->Username = 'contact@stijn-jansen.nl';
    $mailOffer->Password = '7ZVDy$PwCJ-5LyR';
    $mailOffer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mailOffer->Port = 465;

    $mailOffer->setFrom($from);
    $mailOffer->addAddress($_POST['email'], $_POST['name'] . " " . $_POST['surname']);
    $mailOffer->addReplyTo($from, "Klantenservice Office4You");

    $mailOffer->addAttachment($filePath . $file);

    $mailOffer->isHTML(true);
    $mailOffer->Subject = $subject;
    $mailOffer->Body = $htmlContent;

    $mailOwnOffer->isSMTP();
    $mailOwnOffer->Host = 'smtp.transip.email;';
    $mailOwnOffer->SMTPAuth = true;
    $mailOwnOffer->Username = 'contact@stijn-jansen.nl';
    $mailOwnOffer->Password = '7ZVDy$PwCJ-5LyR';
    $mailOwnOffer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mailOwnOffer->Port = 465;
    $mailOwnOffer->addAttachment($filePath . $file);
    $mailOwnOffer->AllowEmpty = true;
    $mailOwnOffer->setFrom($from);
    $mailOwnOffer->addAddress('stijnjansen00@gmail.com');
    $mailOwnOffer->Subject = $subject;

    $mailOffer->send();
    $mailOwnOffer->send();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error: ' . $e;
}

