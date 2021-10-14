<?php
include "php/db.php";

if (isset($_GET['product'])) {

    if (isset($_POST['addCart'])) {
        $productID = $_POST['productID'];
        $quantity = $_POST['quantity'];
        if ($quantity > 0) {
            $new = $_SESSION['cart'][$productID]['quantity'] + $quantity;

            $_SESSION['cart'][$productID] = array(
                "quantity" => $new
            );

            $_SESSION['message'] = 'Toegevoegd aan winkelwagen';
        }
    }

    if (!empty($_SESSION['message'])) {
        echo '<script>toastr.info("' . $_SESSION['message'] . '")</script>';
        unset($_SESSION['message']);
    }

    $getProductInfo = $conn->prepare("SELECT * FROM product WHERE productID = ?");
    $getProductInfo->execute([$_GET['product']]);

    $productResult = $getProductInfo->fetch();

    $priceExcl = $productResult['priceExcl'];
    $priceIncl = $priceExcl * 1.21;
    ?>
    <title><?= $productResult['productName'] ?></title>
    <div class="container p-3">

        <?php
        if (isset($_GET['sort'])) {
            ?>
            <form action="products" method="get">
                <input type="hidden" name="sort" value="<?= $_GET['sort'] ?>">
                <button class="btn text-main p-0" type="submit">Terug</button>
            </form>
            <?php
        } else if (isset($_GET['package'])) {
            ?>
            <a class="text-main text-decoration-none" href="packages">Terug</a>
            <?php
        } else if (isset($_GET['order'])) {
            ?>
            <form action="user_order_overview" method="post">
                <input type="hidden" name="order" value="<?= $_GET['order'] ?>">
                <button class="btn text-main p-0" type="submit">Terug</button>
            </form>
            <?php
        } else if (isset($_GET['offer'])) {
            ?>
            <form action="user_offer_overview" method="post">
                <input type="hidden" name="offer" value="<?= $_GET['offer'] ?>">
                <button class="btn text-main p-0" type="submit">Terug</button>
            </form>
            <?php
        }
        ?>

        <h3 class="fw-bold"><?= $productResult['brand'] . ' - ' . $productResult['productName'] ?></h3>

        <div class="row row-cols-1 row-cols-md-2">

            <div class="col">
                <img loading="lazy" class="p-2"
                     style="max-width: 25rem"
                     src="data:image/png;base64,<?= base64_encode($productResult['img']) ?>"
                     alt="">
            </div>
            <div class="col">

                <h5 class="text-main">
                    #<?= $productResult['productNumber'] ?>
                </h5>

                <div>
                    Adviesprijs: <span
                            class="text-decoration-line-through text-reset">&euro;<?= $productResult['suggestedPrice'] ?></span>
                    <br>
                    <span class="fs-3 fw-normal">&euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?></span>
                </div>
                <p class="mb-0">
                    <small class="priceText mb-0">&euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?> Incl.
                        BTW</small>
                </p>

                <?php
                if (!empty($productResult['sale'])) {
                    ?>
                    <h4 class="text-danger pb-2">
                        <?= $productResult['sale'] ?>% Korting
                    </h4>
                    <?php
                }
                ?>
                <?php
                if ($productResult['supply'] <= 10) {
                    ?>
                    <div class="mb-2">
                        <small class="priceText text-danger">Nog maar <?= $productResult['supply'] ?> op
                            voorraad!</small>
                    </div>
                    <?php
                }
                ?>
                <div class="mb-3">
                    EAN: <?= $productResult['ean'] ?>
                </div>
                <div>
                    <?= $productResult['description'] ?>
                </div>
                <form action="" method="post" style="max-width: 15rem;">
                    <input type="hidden" name="productID" value="<?= $productResult['productID'] ?>">
                    <div class="quantity buttons_added">
                        <div class="row text-center p-2">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-3 p-0 m-0">
                                        <input class="minus btn w-100" type="button" value="-">
                                    </div>
                                    <div class="col-5 px-1 m-0">
                                        <input class="form-control input-text qty text w-100" type="number"
                                               step="1" min="1" max="<?= $productResult['supply'] ?>" name="quantity"
                                               value="1" aria-label>
                                    </div>
                                    <div class="col-3 p-0 m-0">
                                        <input class="plus btn w-100" type="button" value="+">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-main" type="submit" name="addCart" value="addCart">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

    <script>
        function refresh_quantity_increments() {
            jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function (a, b) {
                var c = jQuery(b);
                c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
            })
        }

        String.prototype.getDecimals || (String.prototype.getDecimals = function () {
            var a = this,
                b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
        }), jQuery(document).ready(function () {
            refresh_quantity_increments()
        }), jQuery(document).on("updated_wc_div", function () {
            refresh_quantity_increments()
        }), jQuery(document).on("click", ".plus, .minus", function () {
            var a = jQuery(this).closest(".quantity").find(".qty"),
                b = parseFloat(a.val()),
                c = parseFloat(a.attr("max")),
                d = parseFloat(a.attr("min")),
                e = a.attr("step");
            b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
        });
    </script>
    <?php
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}