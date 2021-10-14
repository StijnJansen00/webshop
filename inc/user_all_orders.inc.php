<?php
include "php/db.php";

if (isset($_SESSION['login']) && $_SESSION['role'] === 'user') {
    ?>
    <title>Mijn Bestellingen</title>
    <div class="container p-3">

        <a class="text-decoration-none text-main" href="user_acc">Terug</a>

        <h3 class="text-main text-center mb-3">Alle Bestellingen</h3>

        <div class="row row-cols-1 mb-3">
            <?php
            $getUserOrders = $conn->prepare("SELECT * FROM `order` o INNER JOIN orderNumbers orN ON orN.orderNumbersID = o.orderNumber WHERE o.userID = ? ORDER BY orN.numb DESC");
            $getUserOrders->execute([$_POST['user']]);

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
                        <input type="hidden" name="all_orders" value="true">
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
                                                        &euro;<?= $orderInfo['priceExcl'] ?> <span class="">per stuk</span>
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
            } else {
                echo '<div class="text-second text-center w-100 fs-5">Je hebt nog geen bestelling gedaan</div>';
            }
            ?>
        </div>

    </div>
    <?php

} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}
