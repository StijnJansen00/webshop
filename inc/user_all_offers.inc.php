<?php
include "php/db.php";

if (isset($_SESSION['login']) && $_SESSION['role'] === 'user') {
    ?>
    <title>Mijn Offertes</title>
    <div class="container p-3">

        <a class="text-decoration-none text-main" href="user_acc">Terug</a>

        <h3 class="text-main text-center mb-3">Alle Offertes</h3>

        <div class="row row-cols-1">
            <?php
            $getUserOffers = $conn->prepare("
            SELECT * 
            FROM offer f 
            INNER JOIN orderNumbers orN ON orN.orderNumbersID = f.offerNumber 
            WHERE f.userID = ? 
            ORDER BY orN.numb DESC
        ");
            $getUserOffers->execute([$_POST['user']]);

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
                    $card = '<div class="card offers border-2 border-danger">';
                    $text = 'Goedgekeurd';
                } else if ($offer['offerAccepted']) {
                    $card = '<div class="card offers border-2 border-main">';
                    $text = 'Goedgekeurd';
                } else {
                    $card = '<div class="card offers border-2 border-second">';
                    $text = 'Open';
                }
                ?>
                <div class="col">
                    <form class="mb-3" action="user_offer_overview" method="post">
                        <input type="hidden" name="all_offers" value="true">
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
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php

} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}
