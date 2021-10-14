<?php
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        include 'db.php';
        require '../fpdf/fpdf.php';
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/SMTP.php';
        session_start();

        $getSignature = $conn->prepare("SELECT signature FROM login WHERE loginID = ?");
        $getSignature->execute([$_SESSION['loginID']]);
        $signature = $getSignature->fetch();

        $getOfferNuber = $conn->prepare("SELECT numb FROM orderNumbers ORDER BY orderNumbersID DESC LIMIT 1");
        $getOfferNuber->execute();
        $resultOffer = $getOfferNuber->fetch();
        $offerNr = (int)$resultOffer['numb'];
        $offerNr++;

        $addNewOfferNumb = $conn->prepare("INSERT INTO orderNumbers SET numb = ?");
        $addNewOfferNumb->execute([$offerNr]);
        $numbID = $conn->lastInsertId();

        $date = date("Y-m-d");
        $untilDate = date('Y-m-d', strtotime($date . ' + 30 days'));
        $x = count($_POST['products']['productID']);

        $priceE = 0;
        $priceExcl = 0;
        $priceIncl = 0;
        define('EURO', chr(128));

        function random_chars_generate($chars)
        {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($data), 0, $chars);
        }

        function number_generate($chars)
        {
            $data = '1234567890';
            return substr(str_shuffle($data), 0, $chars);
        }

        if (empty($_POST['user'])) {
            $number = number_generate(5);
            $username = htmlspecialchars($_POST['name']) . htmlspecialchars($_POST['companyName']) . $number;
            $username = str_replace(' ', '', $username);
            $password = random_chars_generate(10);

            $addUserRegister = $conn->prepare("INSERT INTO login SET username = ?, password = ?, `role` = ?");
            $addUserRegister->execute([
                $username,
                password_hash($password, PASSWORD_DEFAULT),
                'user'
            ]);
            $loginID = $conn->lastInsertId();

            $addUser = $conn->prepare("INSERT INTO `user` SET loginID = ?, `name` = ?, surname = ?, email = ?, street = ?, `number` = ?, zipcode = ?, city = ?,phone = ?, company = ?, kvk = ?");
            $addUser->execute([
                $loginID,
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['surname']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($_POST['street']),
                htmlspecialchars($_POST['number']),
                htmlspecialchars($_POST['zipcode']),
                htmlspecialchars($_POST['city']),
                htmlspecialchars($_POST['phone']),
                htmlspecialchars($_POST['companyName']),
                htmlspecialchars($_POST['kvk'])
            ]);
            $userID = $conn->lastInsertId();

            $loginInfoMail = "<p>U kunt uw offerte ook bekijken in uw account. Hieronder staan uw gegevens:</p>";
            $loginInfoMail .= "<br><p>Gebruikersnaam: $username";
            $loginInfoMail .= "<br>Wachtwoord: $password</p>";
            $loginInfoMail .= "<p>Klik<a class='login' href='https://4youoffice.nl/login' target='_blank'> hier </a>om te inloggen.</p>";

            $user = $userID;
        } else {
            $user = $_POST['user'];
        }

        $createOffer = $conn->prepare("INSERT INTO offer SET userID = ?, offerNumber = ?, offerDate = ?");
        $createOffer->execute([$user, $numbID, $date]);
        $offerID = $conn->lastInsertId();

        for ($i = 0; $i < $x; $i++) {
            if (!empty($_POST['products']['price'][$i])) {
                $price = $_POST['products']['price'][$i];
            } else {
                $getPrice = $conn->prepare("SELECT priceExcl FROM product WHERE productID = ?");
                $getPrice->execute([$_POST['products']['productID'][$i]]);
                $price = $getPrice->fetch();
                $price = $price['priceExcl'];
            }

            $addProductToOffer = $conn->prepare("INSERT INTO offer_product SET offerID = ?, productID = ?, amount = ?, offerProductPrice = ?");
            $addProductToOffer->execute([
                $offerID,
                $_POST['products']['productID'][$i],
                $_POST['products']['amount'][$i],
                $price
            ]);

            $productTotalPrice = $price * $_POST['products']['amount'][$i];
            $priceExcl += $productTotalPrice;
        }

        $addTotal = $conn->prepare("UPDATE offer SET offerPriceTotal = ? WHERE offerID = ?");
        if (!empty($_POST['priceTotal'])) {
            $addTotal->execute([htmlspecialchars($_POST['priceTotal']), $offerID]);
        } else {
            $addTotal->execute([$priceExcl, $offerID]);
        }

        $selectAllFromUser = $conn->prepare("SELECT * FROM `user` WHERE userID = ?");
        $selectAllFromUser->execute([$user]);
        $userInfo = $selectAllFromUser->fetch();

        $selectOfferProducts = $conn->prepare("SELECT * FROM offer_product WHERE offerID = ?");
        $selectOfferProducts->execute([$offerID]);

        if (htmlspecialchars($_POST['customEmail'])) {
            $emailMessage = str_replace(PHP_EOL, '<br>', $_POST['emailMessage']);
            $message = "<p>Geachte heer/mevrouw " . $userInfo['surname'] . "</p><br>";
            $message .= "<p>" . $emailMessage . "</p>";
            $message .= "<br><br><p> Met vriendelijke groeten,</p>";
            $message .= "<p>" . $signature['signature'] . "</p>";
        } else {
            $message = "<p>Geachte heer/mevrouw " . $userInfo['surname'] . "</p>";
            $message .= "<br><p>";
            $message .= "Hartelijk dank voor uw offerte aanvraag. ";
            $message .= "Met genoegen bieden wij u vrijblijvend onze prijsopgave aan.<br>";
            $message .= "Deze treft u in de bijlage aan.<br>";
            $message .= "Heeft u vragen of opmerkingen naar aanleiding van deze offerte, neem dan gerust contact met mij op.";
            $message .= "</p>";
            if (!empty($loginInfoMail)) {
                $message .= $loginInfoMail;
            }
            $message .= "<br><br><p> Met vriendelijke groeten,</p>";
            $message .= "<p>" . $signature['signature'] . "</p>";
        }

        include 'create_offer.php';

        include 'mail_offer_send.php';

        $_SESSION['message'] = 'Offerte is aangemaakt en verzonden naar de ontvanger';
        header("Location: ../admin_dashboard?adminPage=offers");

    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}