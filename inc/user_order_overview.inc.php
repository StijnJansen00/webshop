<?php
include 'php/db.php';

if (isset($_SESSION['login']) && $_SESSION['role'] === 'user' && $_POST['order']) {

    $getOrder = $conn->prepare("SELECT * FROM `order` o INNER JOIN orderNumbers `on` ON on.orderNumbersID = o.orderNumber WHERE o.orderID = ?");
    $getOrder->execute([$_POST['order']]);
    $order = $getOrder->fetch();

    $userOrder = $conn->prepare("
        SELECT *
        FROM order_product op 
        INNER JOIN product p ON p.productID = op.productID
        INNER JOIN `order` o ON o.orderID = op.orderID
        INNER JOIN `user` u ON u.userID = o.userID
        INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber
        WHERE o.orderID = ?
    ");
    $userOrder->execute([$order['orderID']]);

    if (isset($_POST['all_orders']) && $_POST['all_orders']){
        $link = 'user_all_orders';
    } else {
        $link = 'user_acc';
    }
    ?>
    <title>Bestelling Overzicht</title>
    <div class="container p-3">

        <form action="<?= $link ?>" method="post">
            <input type="hidden" name="user" value="<?= $order['userID'] ?>">
            <button class="btn text-main">Terug</button>
        </form>

        <div class="fs-2 mb-2">
            Bestelnummer #<?= $order['numb'] ?>
        </div>
        <div class="mb-2">
            Bestel op: <?= $order['orderDate'] ?>
        </div>
        <?php
        if (!empty($order['sender'])) {
            ?>
            <div class="mb-2">
                Status: <?= $order['orderStatus'] ?>
            </div>
            <div class="row mb-2">
                <div class="col">
                    Verzending via: <?= $order['sender'] ?>
                </div>
                <div class="col">
                    <?php
                    if ($order['sender'] === 'PostNL' && $order['orderStatus'] === 'Verzonden') {
                        ?>
                        Track & Trace:
                        <a class="text-decoration-none text-main"
                           href="http://postnl.nl/tracktrace/?B=<?= $order['tracking'] ?>&P=<?= $order['zipcode'] ?>&D=NL&T=C"
                           target="_blank">
                            <?= $order['tracking'] ?>
                        </a>
                        <?php
                    } else if ($order['sender'] === '4YouOffice' && $order['orderStatus'] === 'verzonden') {
                        ?>
                        Tracking: <?= $order['tracking'] ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="mb-2">
                Status: <?= $order['orderStatus'] ?>
            </div>
            <?php
        }
        ?>
        <div class="row row-cols-1">
            <?php
            $totaalExcl = 0;
            $totaalIncl = 0;

            foreach ($userOrder as $productInfo) {
                $prijsExcl = $productInfo['amount'] * $productInfo['priceExcl'];
                $prijsIncl = $prijsExcl * 1.21;
                ?>
                <div class="card border border-main m-1" style="min-height: 12rem">
                    <div class="row my-auto g-0">
                        <div class="col-md-2 p-3">
                            <img loading="lazy" class="img-fluid rounded-start"
                                 src="data:image/png;base64,<?= base64_encode($productInfo['img']) ?>"
                                 alt="">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <p class="card-text">
                                    <span class="fs-5 fw-bold"><?= $productInfo['brand'] . ' ' . $productInfo['productName'] ?></span>
                                    <br>
                                    <?= $productInfo['description'] ?>
                                </p>
                                <p class="card-text">
                                    <span class="fs-5 text-main">&euro;<?= number_format((float)$productInfo['priceExcl'], 2, ',', '.'); ?></span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <?= $productInfo['amount'] ?> stuks
                                </p>
                                <p class="card-text">
                                    EAN: <?= $productInfo['ean'] ?>
                                </p>
                                <p class="card-text">
                                    <a class="text-decoration-none text-main"
                                       href="productSpecs?product=<?= $productInfo['productID'] ?>&order=<?= $order['orderID'] ?>">
                                        Bekijk Product
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $totaalExcl += $prijsExcl;

                $name = $productInfo['name'] . ' ' . $productInfo['surname'];
            }
            if (!empty($order['coupon'])) {
                if (str_contains($order['coupon'], '%')) {
                    $sale = str_replace('%', '', $order['coupon']);
                    $excl = $totaalExcl - (($totaalExcl / 100) * $sale);
                } else if (str_contains($order['coupon'], '€')) {
                    $sale = str_replace('€', '', $order['coupon']);
                    $excl = $totaalExcl - $sale;
                }
                echo '<p class="m-0 px-2">Kortingscode van ' . $order['coupon'] . ' toegepast</p>';
            } else {
                $excl = $totaalExcl;
            }

            $incl = $excl * 1.21;

            if ($excl < 65) {
                $incl += 6.95;
            }
            ?>
        </div>

        <div class="row row-cols-1 row-cols-md-3">
            <div class="col my-2">
                Prijs excl. BTW:
                <span class="fs-3 text-main">&euro;<?= number_format((float)$excl, 2, ',', '.') ?></span>
                <?php
                if ($excl < 65) {
                    ?>
                    <br>
                    Verzendkosten:
                    <span class="">&euro;6,95</span>
                    <?php
                }
                ?>
                <br>
                Prijs incl. BTW:
                <span class="">&euro;<?= number_format((float)$incl, 2, ',', '.') ?></span>
            </div>
            <div class="col mt-3">
                Verzenden Naar:
                <br>
                <?= $name ?>
                <br>
                <?= $order['streetSend'] . ' ' . $order['numberSend'] ?>
                <br>
                <?= $order['zipcodeSend'] . ' ' . $order['citySend'] ?>
            </div>
        </div>

    </div>
    <?php
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}
