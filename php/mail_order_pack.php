<?php

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "From: contact@4youoffice.nl";

$subject = 'Uw bestelling is ingepakt en klaar voor verzending!';

$text = "<p>Beste " . $user['name'] . ' ' . $user['surname'] . ", </p>";
$text .= "<br><p>Uw bestelling is ingepakt</p>";
$text .= "<br><p>U krijgt een mail zodra uw bestelling wordt verzonden.</p>";
$text .= "<br><p>Indien er iets niet klopt of als u vragen heeft, horen wij dat graag.</p>";
$text .= "<br><p> Met vriendelijke groet, </p>";
$text .= "<p>Klantenservice 4YouOffice</p>";

$message = '<html>
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

                                    a {
                                        color: white !important;
                                        text-decoration: none;
                                    }

                                </style>
                            </head>

                            <body>
                                <div class="container">
                                    <img src="https://4youoffice.nl/img/logo4YouOffice.png" alt="Logo 4YouOffice">
                                    <h1>Alles voor op kantoor</h1>
                                    ' . $text . ' 
                                </div>
                                <div class="footer">
                                    <table style="width: 100%">
                                        <tr>
                                            <td>
                                                <h2>4YouOffice | Schumanpark 115 | 7336 AS Apeldoorn | <br> 055 2040808 </h2>
                                            </td>
                                            <td style="text-align: right">
                                                <h3><a href="https://4youoffice.nl">4YouOffice.nl</a></h3>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </body>
                            </html>';

mail($user['email'], $subject, $message, $headers);
