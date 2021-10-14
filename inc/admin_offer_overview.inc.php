<?php
include 'php/db.php';

if (isset($_SESSION['login'], $_GET['offerNr'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $getOfferInfo = $conn->prepare("
            SELECT * 
            FROM offer f 
            INNER JOIN `user` u ON u.userID = f.userID
            INNER JOIN orderNumbers AS `on` ON on.orderNumbersID = f.offerNumber
            WHERE f.offerID = ?");
        $getOfferInfo->execute([$_GET['offerNr']]);
        $offer = $getOfferInfo->fetch();
        ?>
        <title>Offerte #<?= $offer['offerNumber'] ?></title>
        <div class="container p-3">

            <a class="text-main text-decoration-none mb-5" href="admin_dashboard?adminPage=offers">Terug</a>

            <h2 class="text-center text-second mb-3">Offerte #<?= $offer['offerNumber'] ?></h2>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <h5 class="text-main mb-3">Gegevens</h5>
                    <div class="card border-second mb-3 p-3" style="max-width: 25rem;">
                        <p>
                            <span class="fw-bold">Datum:</span> <?= $offer['offerDate'] ?>
                        </p>
                        <p>
                            <span class="fw-bold">Bedrijf:</span> <?= $offer['company'] ?>
                        </p>
                        <p>
                            <span class="fw-bold">Email:</span> <?= $offer['email'] ?>
                        </p>
                        <p>
                            <span class="fw-bold">Naam:</span> <?= $offer['name'] ?> <?= $offer['surname'] ?>
                        </p>
                        <p>
                            <span class="fw-bold">Adres:</span>
                            <br>
                            <?= $offer['street'] ?> <?= $offer['number'] ?>
                            <br>
                            <?= $offer['zipcode'] ?> <?= $offer['city'] ?>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <h5 class="text-main mb-3">Goedkeuring</h5>
                    <?php
                    if ($offer['offerAccepted']) {
                        $getOrderID = $conn->prepare("SELECT orderID FROM `order` WHERE offerID = ?");
                        $getOrderID->execute([$offer['offerID']]);
                        $orderID = $getOrderID->fetch();
                        ?>
                        <p>
                            Offerte is goedgekeurd door de klant
                        </p>
                        <p>
                            Klik<a class="text-main text-decoration-none" href="admin_order_overview?orderID=<?= $orderID['orderID'] ?>"> hier </a>om de order te bekijken
                        </p>
                        <?php
                    } else {
                        ?>
                        <p>
                            Offerte is nog niet goedgekeurd door de klant
                        </p>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <h5 class="text-main mb-3">Producten</h5>
            <div class="row row-cols-1">
                <?php
                $selectOfferProducts = $conn->prepare("SELECT * FROM offer_product fp INNER JOIN product p ON p.productID = fp.productID WHERE fp.offerID = ?");
                $selectOfferProducts->execute([$offer['offerID']]);
                foreach ($selectOfferProducts as $product) {
                    $prijsExcl = $product['amount'] * $product['priceExcl'];
                    $prijsIncl = $prijsExcl * 1.21;
                    ?>
                    <div class="card border border-main m-1" style="min-height: 12rem">
                        <div class="row my-auto g-0">
                            <div class="col-md-2 p-3">
                                <img loading="lazy" class="img-fluid rounded-start"
                                     src="data:image/png;base64,<?= base64_encode($product['img']) ?>"
                                     alt="">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <p class="card-text">
                                        <span class="fs-5 fw-bold"><?= $product['brand'] . ' ' . $product['productName'] ?></span>
                                        <br>
                                        <?= $product['description'] ?>
                                    </p>
                                    <p class="card-text">
                                        <span class="fs-5 text-main">&euro;<?= number_format((float)$product['priceExcl'], 2, ',', '.'); ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?= $product['amount'] ?> x
                                    </p>
                                    <p class="card-text">
                                        EAN: <?= $product['ean'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $totaalExcl += $prijsExcl;
                    $totaalIncl += $prijsIncl;

                }
                ?>

            </div>

        </div>

        <script>
            let email = document.getElementById("emailMessage")
            email.addEventListener("keypress", function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault()
                    email.value += '\r\n<br>\r\n'
                }
            });
        </script>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}

