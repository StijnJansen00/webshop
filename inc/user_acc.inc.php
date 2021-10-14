<?php
include 'php/db.php';

if (isset($_SESSION['login']) && $_SESSION['role'] === 'user') {

    $getUserInfo = $conn->prepare("SELECT * FROM `user` WHERE loginID = ?");
    $getUserInfo->execute([$_SESSION['loginID']]);
    $userResult = $getUserInfo->fetch();

    $_SESSION['userID'] = $userResult['userID'];
    ?>
    <title>Mijn Account</title>
    <!--Header-->
    <div class="container-fluid p-0">
        <div class="header mb-3" style="background: url('img/header-acc.webp') no-repeat right 85% top 45%;">
            <div class="text align-middle">
                <div class="container">
                    <h1 class="text-center">Welkom <?= $userResult['name'] ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-3">

        <h3 class="text-main mb-3">Je laatste Bestellingen</h3>

        <div class="row row-cols-1 mb-3">
            <?php
            $getUserOrders = $conn->prepare("
                    SELECT * 
                    FROM `order` o 
                    INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber 
                    WHERE o.userID = ? 
                    ORDER BY o.orderNumber DESC 
                    LIMIT 2");
            $getUserOrders->execute([$userResult['userID']]);

            if ($getUserOrders->rowCount() > 0) {
                foreach ($getUserOrders as $orders) {
                    $getOrderInfo = $conn->prepare("
                        SELECT	o.orderID,
                                o.orderNumber,
                                o.orderDate,
                                o.orderStatus AS orderStatus,
                                p.productNumber AS productNumber,
                                p.ean AS ean,
                                p.brand AS brand,
                                p.description AS description,
                                p.img AS img,
                                p.priceExcl,
                                op.amount,
                                orN.numb AS numb
                        FROM `order` o
                        INNER JOIN order_product op ON op.orderID = o.orderID
                        INNER JOIN product p ON p.productID = op.productID
                        INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber
                        WHERE o.orderID = ?");
                    $getOrderInfo->execute([$orders['orderID']]);
                    ?>
                    <form class="mb-3" action="user_order_overview" method="post">
                        <input type="hidden" name="order" value="<?= $orders['orderID'] ?>">
                        <button class="btn w-100 p-0 m-0" type="submit" style="text-align: left !important;">
                            <p class="fw-light card-title">Bestelnummer: #<?= $orders['numb'] ?></p>
                            <div class="card orders border border-second">
                                <?php
                                foreach ($getOrderInfo as $orderInfo) {
                                    ?>
                                    <div class="row my-auto g-0">
                                        <div class="col-md-3 text-center p-3">
                                            <img loading="lazy" class="img-fluid rounded-start"
                                                 style="max-height: 7rem"
                                                 src="data:image/png;base64,<?= base64_encode($orderInfo['img']) ?>"
                                                 alt="">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <?= $orderInfo['brand'] . ' ' . $orderInfo['productName'] ?>
                                                    <br>
                                                    <?= $orderInfo['description'] ?>
                                                </p>
                                                <div class="row">
                                                    <div class="col">
                                                        EAN: <?= $orderInfo['ean'] ?>
                                                    </div>
                                                    <div class="col">
                                                        <?= $orderInfo['amount'] ?> <span class="">stuks</span>
                                                    </div>
                                                    <div class="col">
                                                        &euro;<?= $orderInfo['priceExcl'] ?> <span
                                                                class="">per stuk</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="text-main mb-0">
                                    <?php
                                }
                                ?>
                            </div>
                        </button>
                    </form>
                    <?php
                }
                ?>
                <div class="col text-end">
                    <form action="user_all_orders" method="post">
                        <input type="hidden" name="user" value="<?= $userResult['userID'] ?>">
                        <button class="btn text-main fs-5 mb-3">Bekijk alle Bestellingen</button>
                    </form>
                </div>
                <?php
            } else {
                echo '<div class="text-second text-center w-100 fs-5">Je hebt nog geen bestelling gedaan</div>';
            }
            ?>
        </div>

        <div class="row row-cols-1">
            <?php
            $getUserOffers = $conn->prepare("
                    SELECT * 
                    FROM offer f 
                    INNER JOIN orderNumbers orN ON orN.orderNumbersID = f.offerNumber 
                    WHERE f.userID = ? 
                    ORDER BY orN.numb DESC
                    LIMIT 2");
            $getUserOffers->execute([$userResult['userID']]);

            if ($getUserOffers->rowCount() > 0) {
                ?>
                <div class="col">
                    <h3 class="text-main mb-3">Laatste Offertes</h3>
                    <?php
                    foreach ($getUserOffers as $offer) {
                        $getOfferInfo = $conn->prepare("
                            SELECT	*
                            FROM offer f
                            INNER JOIN offer_product op ON op.offerID = f.offerID
                            INNER JOIN product p ON p.productID = op.productID
                            INNER JOIN orderNumbers orN ON orN.orderNumbersID = f.offerNumber
                            WHERE f.offerID = ?");
                        $getOfferInfo->execute([$offer['offerID']]);

                        if ($offer['offerAccepted'] === '-1') {
                            $card = '<div class="card offers border border-danger">';
                            $text = 'Goedgekeurd';
                        } else if ($offer['offerAccepted']) {
                            $card = '<div class="card offers border border-main">';
                            $text = 'Goedgekeurd';
                        } else {
                            $card = '<div class="card offers border border-second">';
                            $text = 'Open';
                        }
                        ?>
                        <form class="mb-3" action="user_offer_overview" method="post">
                            <input type="hidden" name="offer" value="<?= $offer['offerID'] ?>">
                            <button class="btn w-100 p-0 m-0" type="submit" style="text-align: left !important;">

                                <div class="row mb-0">
                                    <div class="col text-second">
                                        Offerte: #<?= $offer['numb'] ?>
                                    </div>
                                    <div class="col text-center text-second">
                                        Totaal: &euro;<?= $offer['offerPriceTotal'] ?>
                                    </div>
                                    <div class="col text-end text-second">
                                        <?= $text ?>
                                    </div>
                                </div>
                                <?php
                                echo $card;

                                foreach ($getOfferInfo as $offerInfo) {
                                    ?>
                                    <div class="row my-auto g-0">
                                        <div class="col-md-3 text-center p-3">
                                            <img loading="lazy" class="img-fluid rounded-start"
                                                 style="max-height: 7rem"
                                                 src="data:image/png;base64,<?= base64_encode($offerInfo['img']) ?>"
                                                 alt="">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <?= $offerInfo['brand'] . ' ' . $offerInfo['productName'] ?>
                                                    <br>
                                                    <?= $offerInfo['description'] ?>
                                                </p>
                                                <div class="row">
                                                    <div class="col">
                                                        EAN: <?= $offerInfo['ean'] ?>
                                                    </div>
                                                    <div class="col">
                                                        <?= $offerInfo['amount'] ?> <span class="">stuks</span>
                                                    </div>
                                                    <div class="col">
                                                        &euro;<?= $offerInfo['priceExcl'] ?> <span
                                                                class="">per stuk</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="text-main mb-0">
                                    <?php
                                }
                                ?>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
                    <div class="col text-end">
                        <form action="user_all_offers" method="post">
                            <input type="hidden" name="user" value="<?= $userResult['userID'] ?>">
                            <button class="btn text-main fs-5 mb-3">Bekijk alle Offertes</button>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="col">
                <h3 class="text-main mb-3">Gegevens</h3>
                <div class="card border border-second my-2 p-3" style="max-width: 20rem">
                    <div class="card-body">
                        <div class="mb-3">
                            <?= $userResult['name'] ?> <?= $userResult['surname'] ?>
                            <br>
                            <?= $userResult['email'] ?>
                        </div>
                        <div class="mb-3">
                            <?= $userResult['street'] ?> <?= $userResult['number'] ?>
                            <br>
                            <?= $userResult['zipcode'] ?> <?= $userResult['city'] ?>
                            <br>
                            <?= $userResult['phone'] ?>
                        </div>
                        <?php
                        if (isset($userResult['company'])) {
                            ?>
                            <div class="mb-3">
                                <?= $userResult['company'] ?>
                                <br>
                                <?= $userResult['kvk'] ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="my-2">
                            <form action="user_edit_acc" method="post">
                                <input type="hidden" name="userID" value="<?= $userResult['userID'] ?>">
                                <button class="btn btn-second" type="submit" name="submit" value="submit">
                                    Wijzig gegevens
                                </button>
                            </form>
                        </div>
                        <div class="my-2">
                            <form action="edit_password" method="post">
                                <input type="hidden" name="loginID" value="<?= $userResult['loginID'] ?>">
                                <button class="btn btn-second" type="submit" name="submit" value="submit">
                                    Wijzig Wachtwoord
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}