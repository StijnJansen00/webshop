<?php
require "class/PrintLabel.class.php";

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

//        $checkObj = new PrintLabel();
//        $check = $checkObj->checkPrintFolder();

        ?>
        <title>Admin Dashboard</title>
        <div class="container-fluid mb-3" style="max-width: 80rem;">

            <h1>Admin Dashboard</h1>

            <div class="row row-cols-2 row-cols-lg-6 row-cols-md-3 row-cols-sm-3 justify-content-center">
                <div class="col my-2">
                    <div class="card border-2 border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Bestellingen
                            </h5>
                            <a class="btn btn-second" href="?adminPage=orders">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border-2 border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Producten
                            </h5>
                            <a class="btn btn-second" href="?adminPage=products">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border-2 border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Filters
                            </h5>
                            <a class="btn btn-second" href="?adminPage=filters">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border-2 border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Categorieën
                            </h5>
                            <a class="btn btn-second" href="?adminPage=categories">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border-2 border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Offertes
                            </h5>
                            <a class="btn btn-second" href="?adminPage=offers">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border-2 border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Coupons
                            </h5>
                            <a class="btn btn-second" href="?adminPage=coupons">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php
        include 'admin_orders.inc.php';
        include 'admin_products.inc.php';
        include 'admin_filters.inc.php';
        include 'admin_categories.inc.php';
        include 'admin_offers.inc.php';
        include 'admin_coupons.inc.php';


        if ($_GET['adminPage'] === 'products') {
            echo '<script>showProductsCRUD()</script>';
        } else if ($_GET['adminPage'] === 'filters') {
            echo '<script>showFiltersCRUD()</script>';
        } else if ($_GET['adminPage'] === 'categories') {
            echo '<script>showCategories()</script>';
        } else if ($_GET['adminPage'] === 'orders') {
            echo '<script>showOrders()</script>';
        } else if ($_GET['adminPage'] === 'offers') {
            echo '<script>showOffers()</script>';
        } else if ($_GET['adminPage'] === 'coupons') {
            echo '<script>showCoupons()</script>';
        }

    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}