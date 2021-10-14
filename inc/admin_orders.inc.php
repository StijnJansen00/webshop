<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $selectAllOrders = $conn->prepare("
        SELECT 	*, SUM(op.amount) AS amount
        FROM `order` AS o
        INNER JOIN order_product AS op ON o.orderID = op.orderID
        INNER JOIN product AS p ON p.productID = op.productID
        INNER JOIN `user` AS u ON o.userID = u.userID
        INNER JOIN orderNumbers AS `on` ON on.orderNumbersID = o.orderNumber
        GROUP BY o.orderNumber
        ORDER BY o.orderNumber DESC");
        $selectAllOrders->execute();
        ?>
        <div class="hide container-fluid border border-main mb-3 px-5" id="orderOverview" style="max-width: 90rem">

            <h4 class="my-2">Orders Overzicht</h4>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <input type="search" class="form-control" id="orderSearch" placeholder="Zoek Order"
                           aria-label="Search">
                </div>
            </div>

            <div class="table-scroll" style="height: 30rem">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Order Nummer</th>
                        <th>Datum</th>
                        <th>Bedrijf</th>
                        <th>Contact</th>
                        <th>#</th>
                        <th>Betaal status</th>
                        <th>Verzend status</th>
                    </tr>
                    </thead>
                    <tbody id="orderTable">
                    <?php
                    foreach ($selectAllOrders as $orders) {
                        ?>
                        <tr class="align-middle">
                            <td class="py-3">
                                <form action="admin_order_overview" method="get">
                                    <input type="hidden" name="orderID" value="<?= $orders['orderID'] ?>">
                                    <button class="btn p-0 m-0" type="submit">
                                        <?= $orders['numb'] ?>
                                    </button>
                                </form>
                            </td>
                            <td><?= $orders['orderDate'] ?></td>
                            <td><?= $orders['company'] ?></td>
                            <td><?= $orders['name'] . ' ' . $orders['surname'] ?></td>
                            <td><?= $orders['amount'] ?></td>
                            <td><?= $orders['paymentStatus'] ?></td>
                            <td><?= $orders['orderStatus'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            $(document).ready(function () {
                $("#orderSearch").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#orderTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}