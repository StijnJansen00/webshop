<?php
include 'php/db.php';

if (isset($_SESSION['login'], $_POST['offer'])) {
    if ($_SESSION['role'] === 'user') {

        $getOfferInfo = $conn->prepare("
            SELECT * 
            FROM offer f 
            INNER JOIN `user` u ON u.userID = f.userID
            INNER JOIN orderNumbers `on` ON on.orderNumbersID = f.offerNumber
            WHERE f.offerID = ?");
        $getOfferInfo->execute([$_POST['offer']]);
        $offer = $getOfferInfo->fetch();

        $priceExcl = $offer['offerPriceTotal'];
        $priceIncl = $priceExcl * 1.21;

        if (isset($_POST['all_offers']) && $_POST['all_offers']){
            $link = 'user_all_offers';
        } else {
            $link = 'user_acc';
        }
        ?>
        <title>Offerte #<?= $offer['numb'] ?></title>
        <div class="container p-3">

            <form action="<?= $link ?>" method="post">
                <input type="hidden" name="user" value="<?= $offer['userID'] ?>">
                <button class="btn text-main">Terug</button>
            </form>

            <h2 class="text-center text-second mb-3">Offerte #<?= $offer['numb'] ?></h2>

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
                        <p>
                            <span class="fw-bold">Prijs Excl:</span>
                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?>
                            <br>
                            <span class="fw-bold">Prijs Incl:</span>
                            &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <h5 class="text-main mb-3">Offerte Status</h5>
                    <?php
                    if (!$offer['offerAccepted']) {
                        ?>
                        <p class="text-second mb-1">Offerte Goedkeuren</p>
                        <form class="mb-3" action="php/user_offer_accept.php" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="offerID" value="<?= $offer['offerID'] ?>">
                            <button class="btn btn-second" type="submit" name="submit">
                                Offerte goedkeuren en betalen
                            </button>
                        </form>
                        <p class="text-second mb-1">Offerte Weigeren</p>
                        <form class="mb-3" action="php/user_offer_decline.php" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="offerID" value="<?= $offer['offerID'] ?>">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" value="price" id="reason1" checked>
                                <label class="form-check-label" for="reason1">
                                    Te duur
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" value="wrong" id="reason2">
                                <label class="form-check-label" for="reason2">
                                    Klopt niet
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" value="other" id="reason3" checked>
                                <label class="form-check-label" for="reason3">
                                    Anders,
                                </label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="otherReason" id="otherReason" placeholder="namelijk">
                                <label for="otherReason">namelijk</label>
                            </div>

                            <button class="btn btn-danger" type="submit" name="submit">
                                Offerte weigeren
                            </button>
                        </form>
                        <?php
                    } else if ($offer['offerAccepted'] === '-1') {
                        ?>
                        <p>Offerte is geweigerd</p>
                        <p>
                            <small>Reden:</small> <?= $offer['offerDecline'] ?>
                        </p>
                        <?php
                    } else {
                        $selectOrderID = $conn->prepare("SELECT orderID FROM `order` WHERE offerID = ?");
                        $selectOrderID->execute([$offer['offerID']]);
                        $orderID = $selectOrderID->fetch();
                        ?>
                        <p>Offerte is geaccepteerd</p>
                        <p>
                            Kijk
                            <a class="text-main text-decoration-none"
                               href="user_order_overview?order=<?= $orderID['orderID'] ?>">
                                hier
                            </a>
                            voor uw bestel status en overzicht
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
                                        <span class="fs-5 text-main">&euro;<?= number_format((float)$product['offerProductPrice'], 2, ',', '.'); ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?= $product['amount'] ?> x
                                    </p>
                                    <p class="card-text">
                                        EAN: <?= $product['ean'] ?>
                                    </p>
                                    <p class="card-text">
                                        <a class="text-decoration-none text-main"
                                           href="productSpecs?product=<?= $product['productID'] ?>&offer=<?= $offer['offerID'] ?>">
                                            Bekijk Product
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>

        </div>

        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}

