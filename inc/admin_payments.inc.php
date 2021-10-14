<?php

namespace _PhpScoperfa6a84cfa6c2;

use Mollie\Api\Exceptions\ApiException;

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        try {
            require "php/initialize.php";
            $payments = $mollie->payments->page();
        } catch (ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }

        include 'php/db.php';
        ?>
        <title>Betalingen</title>
        <div class="container p-3" id="paymentsOverview">

            <h4 class="my-2">Betaling Overzicht</h4>

            <div class="my-3">
                <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 my-2">
                    <?php
                    foreach ($payments as $paid) {
                        $id = $paid->id;
                        $desc = $paid->description;
                        $method = $paid->method;

                        $getOrder = $conn->prepare("SELECT * FROM `order` WHERE paymentID = ?");
                        $getOrder->execute([$id]);
                        $res = $getOrder->fetch();
                        ?>
                        <div class="col my-2">
                            <div class="card border border-main">
                                <div class="card-body">
                                    <p>
                                        <a class="text-decoration-none text-main"
                                           href="admin_order_overview?orderID=<?= $res['orderID'] ?>">
                                            #<?= $res['orderNumber'] ?>
                                        </a>
                                    </p>
                                    <p>Besteldatum: <?= $res['orderDate'] ?></p>
                                    <p>Beschrijving:
                                        <br>
                                        <?= $desc ?></p>
                                    <p>Betaald met: <?= $method ?></p>
                                    <p>Betaal ID: <?= $id ?></p>
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                    ?>
                </div>
            </div>

        </div>
        <?php
    }
} else {
    header('Location: 404');
}