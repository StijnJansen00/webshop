<?php

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "From: contact@4youoffice.nl";

$subject = 'Uw bestelling is verzonden!';

$text = "<p>Beste " . $result['name'] . ' ' . $result['surname'] . ", </p>";

if ($result['sender'] === 'PostNL'){
    $text .= '<p>Uw bestelling is meegegeven aan de bezorgdienst.</p>';
    $text .= "<br><p>U kunt uw pakket via<a class='tracking' href='http://postnl.nl/tracktrace/?B=" . $result['tracking'] . "&P=" . $result['zipcode'] . "&D=NL&T=C'> hier </a>volgen.</p>";
} else if ($result['sender'] === '4YouOffice') {
    $text .= "<br><p>Uw bestelling is klaar voor bezorging!</p>";
    $text .= "<br><p>Wij komen uw bestelling zelf bezorgen.</p>";
    $text .= "<br><p>Wij nemen contact met u op om te kijken wanneer het beste uitkomt.</p>";
}

$text .= "<br><p>Indien er iets niet klopt, horen wij dat graag.</p>";
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

                                    a.tracking {
                                        color: black !important;
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

mail($result['email'], $subject, $message, $headers);
