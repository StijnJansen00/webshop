<?php
include "php/db.php";
include "fpdf/fpdf.php";
session_start();

$getOrderID = $conn->prepare("SELECT * FROM `order` o INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber WHERE o.orderNumber = ?");
$getOrderID->execute([$_GET['order']]);
$order = $getOrderID->fetch();

if ($order['paymentStatus'] === 'paid') {
    $getUserInfo = $conn->prepare("SELECT * FROM `user` WHERE userID = ?");
    $getUserInfo->execute([$_SESSION['userID']]);
    $user = $getUserInfo->fetch();

    $date = date("d-m-Y");
    $untilDate = date('d-m-Y', strtotime($date . ' + 30 days'));

    $offerAccepted = $conn->prepare("UPDATE offer SET offerAccepted = ? WHERE offerID = ?");
    $offerAccepted->execute([true, $_GET['offer']]);

    $offerInvoice = $conn->prepare("SELECT * FROM offer f INNER JOIN offer_product fp ON fp.offerID = f.offerID WHERE f.offerID = ?");
    $offerInvoice->execute([$_GET['offer']]);
    include 'php/create_offer_to_invoice.php';

    $offerPackageLabel = $conn->prepare("SELECT * FROM offer f INNER JOIN offer_product fp ON fp.offerID = f.offerID WHERE f.offerID = ?");
    $offerPackageLabel->execute([$_GET['offer']]);
    include 'php/create_offer_package_label.php';

    $invoiceName = "factuur-" . $_GET['order'] . ".pdf";
    $packageLabelName = "pakbon-" . $_GET['order'] . ".pdf";

    $updateOrder = $conn->prepare("UPDATE `order` SET userID = ?, offerID = ?, invoicePDF = ?, packageLabelPDF = ?, streetSend = ?, numberSend = ?, zipcodeSend = ?, citySend = ? WHERE orderID = ?");
    $updateOrder->execute([
        $user['userID'],
        $_GET['offer'],
        $invoiceName,
        $packageLabelName,
        $user['street'],
        $user['number'],
        $user['zipcode'],
        $user['city'],
        $order['orderID']
    ]);

    $selectOfferProduct = $conn->prepare("SELECT * FROM offer f INNER JOIN offer_product fp ON fp.offerID = f.offerID WHERE f.offerID = ?");
    $selectOfferProduct->execute([$_GET['offer']]);

    foreach ($selectOfferProduct as $res) {
        $insertOrderProduct = $conn->prepare("INSERT INTO order_product SET orderID = ?, productID = ?, amount = ?");
        $insertOrderProduct->execute([
            $order['orderID'],
            $res['productID'],
            $res['amount']
        ]);
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
                Indien u niet wordt doorgestuurd na 10 seconden, klik dan
                <a class="text-decoration-none text-main" href="home">hier</a>
            </p>
        </div>
    </div>
    <?php
    include 'php/mail_order_send_package_label.php';
    include 'php/mail_offer_send_invoice.php';

} else {
    $deleteOrder = $conn->prepare("DELETE FROM `order` WHERE orderNumber = ?");
    $deleteOrder->execute([$invoiceNr]);
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
            Indien u niet wordt doorgestuurd na 10 seconden, klik dan
            <a class="text-decoration-none text-main" href="home">hier</a>
        </p>

    </div>
    <?php
}
?>
<script>
    setTimeout(function () {
        window.location.href = 'https://4YouOffice.4youoffice.nl/user_acc';
    }, 10000);
</script>
