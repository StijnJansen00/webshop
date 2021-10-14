<?php

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "From: contact@stijn-jansen.nl";

$subject = 'Uw bestelling is verzonden!';

$text = "<p>Beste " . $user['name'] . ' ' . $user['surname'] . ", </p>";
$text .= "<br><p>Uw bestelling is verzonden!</p>";

if ($sender === 'PostNL'){
    $text .= "<br><p>U kunt uw pakket via <a class='tracking' href='http://postnl.nl/tracktrace/?B=" . $barcode . "&P=" . $user['zipcode'] . "&D=NL&T=C'>hier</a> volgen.</p>";
} else if ($sender === 'Office4You') {
    $text .= "<br><p>Wij komen uw bestelling zelf bezorgen.</p>";
    $text .= "<br><p>Wij nemen contact met u op om te kijken wanneer het beste uitkomt.</p>";
}

$text .= "<br><p>Indien er iets niet klopt, horen wij dat graag.</p>";
$text .= "<br><p> Met vriendelijke groet, </p>";
$text .= "<p>Klantenservice Office4You</p>";

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

                                    a.tracking {
                                        color: black !important;
                                    }

                                </style>
                            </head>

                            <body>
                                <div class="container">
                                    <img src="https://office4you.stijn-jansen.nl/img/logoo4y.png" alt="Logo office4you">
                                    <h1>Alles voor op kantoor</h1>
                                    ' . $text . ' 
                                </div>
                                <div class="footer">
                                    <table style="width: 100%">
                                        <tr>
                                            <td>
                                                <h2>Office4You | Schumanpark 115 | 7336 AS Apeldoorn | <br> 055 2040808 </h2>
                                            </td>
                                            <td style="text-align: right">
                                                <h3><a href="https://www.office4you.stijn-jansen.nl">Office4You.nl</a></h3>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </body>
                            </html>';
//mail("bart@hr4you.nl", $_POST['type'], $text2, $headers);

mail('stijnjansen00@gmail.com', $subject, $message, $headers);
//mail($user['email'], $subject, $message, $headers);
