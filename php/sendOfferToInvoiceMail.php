<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


$filePath = '../uploads/';
$filename = 'factuur-' . $invoiceNr;
$file = md5($filename) . '.pdf';

$from = 'contact@stijn-jansen.nl';
$fromName = 'Office4You';
$subject = 'Bestelling Office4You';

// Email body content
$text = "<p>Beste " . $name . "</p><br>";
$text .= "<p>" . $emailMessage . "</p><br>";
$text .= "<p>U kunt het bedrag betalen via onderstaande link.</p>";
$text .= "<p>". $idealLink ."</p>";
$text .= "<br><br><p> Met vriendelijke groeten,</p>";
$text .= "<p>" . $signature['signature'] . "</p>";

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
                                        font-size: 1rem;
                                        margin: 0;
                                    }

                                    a.companyName {
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
                                                <h3><a class="companyName" href="https://www.office4you.nl">office4you.nl</a></h3>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </body>
                            </html>';

$mailInvoice = new PHPMailer();

try {
    $mailInvoice->isSMTP();
    $mailInvoice->Host = 'smtp.transip.email;';
    $mailInvoice->SMTPAuth = true;
    $mailInvoice->Username = 'contact@stijn-jansen.nl';
    $mailInvoice->Password = '7ZVDy$PwCJ-5LyR';
    $mailInvoice->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mailInvoice->Port = 465;

    $mailInvoice->setFrom($from);
    $mailInvoice->addAddress($email, $name);
    $mailInvoice->addReplyTo($from, "Klantenservice Office4You");

    $mailInvoice->addAttachment($filePath . $file);

    $mailInvoice->isHTML(true);
    $mailInvoice->Subject = $subject;
    $mailInvoice->Body = $htmlContent;

    $mailInvoice->send();

//        unlink($invoiceNr);

} catch (Exception $e) {
//        unlink($invoiceNr);
}
