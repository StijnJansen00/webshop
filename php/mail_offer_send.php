<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$filePath = '../uploads/';
$filename = 'offerte-' . $offerNr;
$file = $filename . '.pdf';

$from = 'contact@4youoffice.nl';
$fromName = '4YouOffice';
$subject = 'Offerte 4YouOffice';

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
                                    }

                                    img {
                                        width: 20rem;
                                    }

                                    .footer {
                                        margin-bottom: 0;
                                        background: #64BB9A;
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
                                        font-size: 1rem;
                                        margin: 0;
                                    }
                                    
                                    a.login {
                                        color: black !important;
                                        text-decoration: none;
                                    }

                                    a {
                                        color: white !important;
                                        text-decoration: none;
                                    }

                                </style>
                            </head>

                            <body>
                                <div class="container">
                                    <img src="https://4youoffice.nl/img/logo4YouOffice.png" alt="Logo 4YouOffice">
                                    <h1>Alles voor uw kantoor</h1>
                                    ' . $message . '
                                </div>
                                <div class="footer">
                                    <table style="width: 100%">
                                        <tr>
                                            <td>
                                                <h2>4YouOffice | Schumanpark 115 | 7336 AS Apeldoorn | <br> 055 2040808 </h2>
                                            </td>
                                            <td style="text-align: right">
                                                <h3><a href="https://4YouOffice.nl">4YouOffice.nl</a></h3>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </body>
                            </html>';

$mailOffer = new PHPMailer();

try {
    $mailOffer->isSMTP();
    $mailOffer->Host = "mail.mijndomein.nl";
    $mailOffer->SMTPAuth = true;
    $mailOffer->Username = "contact@4youoffice.nl";
    $mailOffer->Password = "z&$8BdF8V!TRGRe";
    $mailOffer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailOffer->Port = 587;

    $mailOffer->setFrom($from);
    $mailOffer->addAddress($userInfo['email'], $userInfo['name'] . " " . $userInfo['surname']);
    $mailOffer->addReplyTo($from, "Klantenservice 4YouOffice");

    $mailOffer->addAttachment($filePath . $file);

    $mailOffer->isHTML(true);
    $mailOffer->Subject = $subject;
    $mailOffer->Body = $htmlContent;

    $mailOffer->send();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error: ' . $e;
}

