<?php
include "php/db.php";

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $getOrder = $conn->prepare("
            SELECT *
            FROM `order` o 
            INNER JOIN `user` u ON u.userID = o.userID
            INNER JOIN orderNumbers AS `on` ON on.orderNumbersID = o.orderNumber
            WHERE o.orderID = ?");
        $getOrder->execute([$_GET['orderID']]);

        $result = $getOrder->fetch();
        ?>
        <title>Order Info</title>
        <div class="container p-3">

            <a class="text-main text-decoration-none mb-5" href="admin_dashboard?adminPage=orders">Terug</a>

            <h2 class="text-center text-main">#<?= $result['numb'] ?></h2>

            <p>
                Besteld op: <?= $result['orderDate'] ?>
            </p>

            <h6>Producten:</h6>
            <div class="row row-cols-1 row-cols-lg-4 row-cols-md-4 row-cols-sm-2 mb-3">
                <?php
                $products = $conn->prepare("
                    SELECT *
                    FROM order_product op 
                    INNER JOIN product p ON p.productID = op.productID
                    WHERE op.orderID = ?
        ");
                $products->execute([$_GET['orderID']]);

                foreach ($products as $product) {
                    ?>
                    <div class="col mb-1">
                        <div class="card border border-main">
                            <div class="card-body">
                                <p><img loading="lazy" style="height: 4rem;"
                                        src="data:image/png;base64,<?= base64_encode($product['img']) ?>" alt="">
                                </p>
                                <p>#<?= $product['productNumber'] ?></p>
                                <p><?= $product['productName'] ?></p>
                                <p>EAN: <?= $product['ean'] ?></p>
                                <p>Merk: <?= $product['brand'] ?></p>
                                <p>Aantal: <?= $product['amount'] ?> x</p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
            if ($result['orderStatus'] === 'Betaald') {
                ?>
                <div class="card border border-main mx-auto mb-2" style="max-width: 30rem">
                    <h5 class="card-header border-bottom border-main text-center text-main p-3"
                        style="background-color: white !important;">
                        Bestelling Inpakken
                    </h5>
                    <div class="card-body">
                        <form action="php/admin_order_pack.php" method="post">
                            <input type="hidden" name="orderID" value="<?= $result['orderID'] ?>">
                            <input type="hidden" name="userID" value="<?= $result['userID'] ?>">
                            <div class="row mx-auto mb-3">
                                <div class="form-check col-5">
                                    <input class="form-check-input" type="radio" name="sender" value="PostNL"
                                           id="senderPostNL" checked>
                                    <label class="form-check-label" for="senderPostNL">
                                        PostNL
                                    </label>
                                </div>
                                <div class="form-check col-5">
                                    <input class="form-check-input" type="radio" name="sender" value="4YouOffice"
                                           id="sender4YouOffice">
                                    <label class="form-check-label" for="sender4YouOffice">
                                        Zelf
                                    </label>
                                </div>
                            </div>
                            <p>
                                Voor:
                                <br>
                                <?= $result['name'] . ' ' . $result['surname'] ?>
                                <br>
                                <?= $result['street'] . ' ' . $result['number'] ?>
                                <br>
                                <?= $result['zipcode'] . ' ' . $result['city'] ?>
                            </p>
                            <button class="btn btn-main" type="submit" name="submit" value="submit">
                                Inpakken
                            </button>
                        </form>
                    </div>
                </div>
                <?php
            } else if ($result['orderStatus'] === 'Ingepakt') {
                ?>
                <div class="card border border-main mx-auto mb-2" style="max-width: 30rem">
                    <h5 class="card-header border-bottom border-main text-center text-main p-3"
                        style="background-color: white !important;">
                        Bestelling Verzenden
                    </h5>
                    <div class="card-body">
                        <form action="php/admin_order_send.php" method="post">
                            <input type="hidden" name="orderID" value="<?= $result['orderID'] ?>">
                            <div class="row mx-auto mb-3">
                                Verzending via:
                                <br>
                                <?= $result['sender'] ?>
                            </div>
                            <p>
                                Aan:
                                <br>
                                <?= $result['name'] . ' ' . $result['surname'] ?>
                                <br>
                                <?= $result['street'] . ' ' . $result['number'] ?>
                                <br>
                                <?= $result['zipcode'] . ' ' . $result['city'] ?>
                            </p>
                            <button class="btn btn-main" type="submit" name="submit" value="submit">
                                Bestelling Verzenden
                            </button>
                        </form>
                    </div>
                </div>
                <?php
            } else if ($result['orderStatus'] === 'Verzonden') {
                ?>
                <div class="card border border-main mx-auto mb-2" style="max-width: 30rem">
                    <h5 class="card-header border-bottom border-main text-center text-main p-3"
                        style="background-color: white !important;">
                        Bestelling is verzonden
                    </h5>
                    <div class="card-body">
                        <p>
                            Aan:
                            <br>
                            <?= $result['name'] . ' ' . $result['surname'] ?>
                            <br>
                            <?= $result['street'] . ' ' . $result['number'] ?>
                            <br>
                            <?= $result['zipcode'] . ' ' . $result['city'] ?>
                        </p>
                        <?php
                        if ($result['sender'] === 'PostNL') {
                            ?>
                            <p>
                                Volg
                                <a target="_blank"
                                   href='http://postnl.nl/tracktrace/?B="<?= $result['tracking'] ?>"&P="<?= $result['zipcode'] ?>"&D=NL&T=C'>
                                    hier
                                </a>
                                de zending
                            </p>
                            <?php
                        } else {
                            echo '<p>Bestelling wordt verstuurd door ons zelf</p>';
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="card border border-main mx-auto mb-2" style="max-width: 30rem">
                    <h5 class="card-header border-bottom border-main text-center text-main p-3"
                        style="background-color: white !important;">
                        Bestelling staat nog open
                    </h5>
                    <div class="card-body">
                        <p>
                            Voor:
                            <br>
                            <?= $result['name'] . ' ' . $result['surname'] ?>
                            <br>
                            <?= $result['street'] . ' ' . $result['number'] ?>
                            <br>
                            <?= $result['zipcode'] . ' ' . $result['city'] ?>
                        </p>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}