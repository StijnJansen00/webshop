<?php
include "php/db.php";
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
session_start();

$getOrder = $conn->prepare("
    SELECT * 
    FROM `order` o
    INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber
    WHERE o.orderNumber = ?");
$getOrder->execute([$_GET['id']]);
$order = $getOrder->fetch();

if ($order['paymentStatus'] === 'paid') {

    if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {

        $name = $_SESSION['orderInfo']['name'];
        $surname = $_SESSION['orderInfo']['surname'];
        $email = $_SESSION['orderInfo']['email'];
        $street = $_SESSION['orderInfo']['streetSend'];
        $number = $_SESSION['orderInfo']['numberSend'];
        $zipcode = $_SESSION['orderInfo']['zipcodeSend'];
        $city = $_SESSION['orderInfo']['citySend'];
        $phone = $_SESSION['orderInfo']['phoneSend'];
        $company = $_SESSION['orderInfo']['companyName'];
        $kvk = $_SESSION['orderInfo']['kvk'];

        $addTemporaryUser = $conn->prepare("INSERT INTO `user` SET `name` = ?, surname = ?, email = ?, street = ?, `number` = ?, zipcode = ?, city = ?, phone = ?, company = ?, kvk = ?");
        $addTemporaryUser->execute([
            $name,
            $surname,
            $email,
            $street,
            $number,
            $zipcode,
            $city,
            $phone,
            $company,
            $kvk
        ]);
        $userID = $conn->lastInsertId();

    } else {
        $userID = $_SESSION['userID'];
    }

    $invoiceName = "factuur-" . $order['numb'] . ".pdf";
    $packageLabelName = "pakbon-" . $order['numb'] . ".pdf";

    $updateOrder = $conn->prepare("UPDATE `order` SET userID = ?, invoicePDF = ?, packageLabelPDF = ?, streetSend = ?, numberSend = ?, zipcodeSend = ?, citySend = ?, reference = ?, coupon = ? WHERE orderNumber = ?");
    $updateOrder->execute([
        $userID,
        $invoiceName,
        $packageLabelName,
        $_SESSION['orderInfo']['streetSend'],
        $_SESSION['orderInfo']['numberSend'],
        $_SESSION['orderInfo']['zipcodeSend'],
        $_SESSION['orderInfo']['citySend'],
        $_SESSION['orderInfo']['reference'],
        $_SESSION['orderInfo']['couponValue'],
        $_GET['id']
    ]);

    if (isset($_SESSION['package'])) {
        foreach ($_SESSION['cart'] as $id => $res) {
            $amount = $res['quantity'];

            $insertOrderProduct = $conn->prepare("INSERT INTO order_product SET orderID = ?, productID = ?, packageNumber = ?, amount = ?");
            $insertOrderProduct->execute([
                $order['orderID'],
                $id,
                $_SESSION['package'],
                $amount
            ]);
        }
    } else {
        foreach ($_SESSION['cart'] as $id => $res) {
            $amount = $res['quantity'];

            $insertOrderProduct = $conn->prepare("INSERT INTO order_product SET orderID = ?, productID = ?, amount = ?");
            $insertOrderProduct->execute([$order['orderID'], $id, $amount]);

            $updateProductSupply = $conn->prepare("UPDATE product SET supply = (supply - ?) WHERE productID = ?");
            $updateProductSupply->execute([$amount, $id]);
        }
    }

    if (!empty($_SESSION['orderInfo']['coupon'])) {
        $selectCoupon = $conn->prepare("SELECT * FROM coupon WHERE coupon = ?");
        $selectCoupon->execute([$_SESSION['orderInfo']['coupon']]);
        $coupon = $selectCoupon->fetch();
        if ($coupon['oneTime'] === '1') {
            $deleteCoupon = $conn->prepare("DELETE FROM coupon WHERE couponID = ?");
            $deleteCoupon->execute([$coupon['couponID']]);
        }
    }
    ?>
    <title>Bestelling</title>
    <div class="container p-3">
        <div class="text-center">
            <h3 class="text-main">Uw bestelling is geplaatst!</h3>
            <p class="my-4">
                Bedankt voor uw bestelling! Wij gaan voor u aan de slag.
            </p>
            <p class="my-4">
                U krijgt een mail met daarin de factuur. Klopt er iets niet?
                Neem dan contact met ons op <i class="text-main bi bi-arrow-down"></i>
            </p>
            <div class="row my-4 mx-auto" style="max-width: 40rem">
                <div class="col">
                    <a class="text-decoration-none text-main"
                       href="mailto: contact@4YouOffice.nl">Contact@4YouOffice.nl</a>
                </div>
                <div class="col">
                    <a class="text-decoration-none text-main" href="tel: +310552040808">+31 055 204 0808</a>
                </div>
            </div>
            <p class="my-4">
                Indien u niet wordt doorgestuurd na 5 seconden, klik dan
                <a class="text-decoration-none text-main" href="home"> hier </a>
            </p>
        </div>
    </div>
    <?php
    include 'php/mail_order_send_package_label.php';
    include 'php/mail_invoice_send.php';
    include 'php/mail_coupon_printer.php';

    unset($_SESSION['cart'], $_SESSION['orderInfo']);

    if (isset($_SESSION['login'])) {
        $orderID = $order['orderID'];
        ?>
        <script>
            setTimeout(function () {
                window.location.href = 'https://www.4youoffice.nl/user_acc';
            }, 5000);
        </script>
        <?php
    } else {
        ?>
        <script>
            setTimeout(function () {
                window.location.href = 'https://www.4youoffice.nl/home';
            }, 5000);
        </script>
        <?php
    }
} else {
    $deleteOrder = $conn->prepare("DELETE FROM `order` WHERE orderNumber = ?");
    $deleteOrder->execute([$_GET['id']]);
    ?>
    <div class="container text-center p-3">
        <h3 class="text-main">Er is iets mis gegaan met de betaling of het verwerken van uw bestelling.</h3>
        <p class="my-4">
            Probeer het opnieuw of neem contact met ons op <i class="text-main bi bi-arrow-down"></i>
        </p>
        <div class="row my-4 mx-auto" style="max-width: 40rem">
            <div class="col">
                <a class="text-decoration-none text-main" href="mailto: contact@4YouOffice.nl">Contact@4YouOffice.nl</a>
            </div>
            <div class="col">
                <a class="text-decoration-none text-main" href="tel: +310552040808">+31 055 204 0808</a>
            </div>
        </div>
        <p class="my-4">
            Indien u niet wordt doorgestuurd na 5 seconden, klik dan
            <a class="text-decoration-none text-main" href="home">hier</a>
        </p>
    </div>
    <?php
    unset($_SESSION['orderInfo']);
    ?>
        <script>
            setTimeout(function () {
                window.location.href = 'https://www.4youoffice.nl/cart';
            }, 5000);
        </script>
    <?php
}
?>
