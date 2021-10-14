<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$filePath = 'uploads/';
$filename = 'factuur-' . $order['numb'];
$file = $filename . '.pdf';

$from = 'contact@4youoffice.nl';
$fromName = '4YouOffice';
$subject = 'Bestelling 4YouOffice';
$name = $user['name'] . ' ' . $user['surname'];

// Email body content
$text = "<p>Beste " . $name . ",</p>";
$text .= "<br><p>Bedankt voor uw bestelling bij 4YouOffice.nl</p>";
$text .= "<br><p>In de bijlage vind u uw factuur.</p>";
$text .= "<br><p>Wij gaan aan de slag met uw bestelling!</p>";
$text .= "<br><br><p> Met vriendelijke groeten,</p>";
$text .= "<p>Klantenservice 4YouOffice</p>";

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

                                    a.companyName {
                                        color: white !important;
                                        text-decoration: none;
                                    }

                                </style>
                            </head> 

                            <body>
                                <div class="container">
                                    <img src="https://4youoffice.nl/img/logo4YouOffice.png" alt="Logo 4YouOffice">
                                    <h1>Alles voor uw kantoor</h1>
                                    ' . $text . '
                                </div>
                                <div class="footer">
                                    <table style="width: 100%">
                                        <tr>
                                            <td>
                                                <h2>4YouOffice | Schumanpark 115 | 7336 AS Apeldoorn | <br> 055 2040808 </h2>
                                            </td>
                                            <td style="text-align: right">
                                                <h3><a class="companyName" href="https://4YouOffice.nl">4YouOffice.nl</a></h3>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </body>
                            </html>';

$mailInvoice = new PHPMailer();

try {
    $mailInvoice->isSMTP();
    $mailInvoice->Host = "mail.mijndomein.nl";
    $mailInvoice->SMTPAuth = true;
    $mailInvoice->Username = "contact@4youoffice.nl";
    $mailInvoice->Password = "z&$8BdF8V!TRGRe";
    $mailInvoice->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailInvoice->Port = 587;

    $mailInvoice->setFrom($from);
    $mailInvoice->addAddress($user['email'], $name);
    $mailInvoice->addReplyTo($from, "Klantenservice 4YouOffice");

    $mailInvoice->addAttachment($filePath . $file);

    $mailInvoice->isHTML(true);
    $mailInvoice->Subject = $subject;
    $mailInvoice->Body = $htmlContent;

    $mailInvoice->send();

//        unlink($invoiceNr);

} catch (Exception $e) {
//        unlink($invoiceNr);
}
