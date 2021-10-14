<?php
include "php/db.php";

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
    header('Refresh: 0; url= ');
}
?>
<title>Pakketten</title>
<!--Header-->
<div class="container-fluid p-0">
    <div class="header mb-3" style="background: url('img/header-package.webp') no-repeat right 50% bottom 35%;">
        <div class="text align-middle">
            <div class="container">
                <h3 class="font-monospace text-uppercase">
                    Pakketten
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="container text-justify p-3">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aut autem culpa dignissimos enim in maiores modi, natus
    repudiandae voluptates. Accusamus alias facilis ipsa optio quasi voluptatibus! At atque cum expedita in, inventore
    magni. Aperiam debitis fuga hic nobis optio. Adipisci consequatur ducimus error ex fuga quas rerum saepe soluta.
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti dicta dolorem, eveniet explicabo, harum iusto
    libero minima natus perferendis ratione reiciendis sequi, sunt tempore ullam velit veritatis voluptatum?
    Consequatur, eligendi.
</div>

<div class="container p-3">

    <h3>Kant en Klaar</h3>

    <div class="row row-cols-1 products">
        <?php
        $getAllProducts = $conn->prepare("
                SELECT * 
                FROM product p 
                INNER JOIN category c ON c.categoryID = p.categoryID
                WHERE c.categoryID = '15'
            ");
        $getAllProducts->execute();

        foreach ($getAllProducts as $product) {
            $suggestedPrice = number_format((float)$product['suggestedPrice'], 2, ',', '.');
            $priceExcl = $product['priceExcl'];
            $priceIncl = (int)$priceExcl * 1.21;
            ?>
            <hr class="text-second" style="opacity: 1">
            <div class="card border-0 mb-2">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img loading="lazy" class="img-fluid rounded-start"
                             alt="<?= $product['brand'] . ' - ' . $product['productName'] ?>"
                             src="data:image/png;base64,<?= base64_encode($product['img']) ?>">
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="card-body py-0">
                            <form action="productSpecs" method="get">
                                <input type="hidden" name="product" value="<?= $product['productID'] ?>">
                                <input type="hidden" name="package" value="<?= $product['productID'] ?>">
                                <button class="btn text-start w-100 p-0" type="submit">
                                    <p class="fw-bold fs-5 mb-0">
                                        <?= $product['brand'] . ' - ' . $product['productName'] ?>
                                    </p>
                                    <p class="fw-light mb-0">
                                        #<?= $product['productNumber'] ?>
                                    </p>
                                    <p>
                                        <?= $product['description'] ?>
                                    </p>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <small class="priceText text-decoration-line-through">&euro;<?= $suggestedPrice ?></small>
                                    </div>
                                    <div class="col">
                                        <small class="priceText font-monospace">Per stuk</small>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($product['showInclPrice']) {
                                ?>
                                <div class="col fs-3 fw-bold">
                                    &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                </div>
                                <div class="col mb-0">
                                    <small class="priceText mb-0">
                                        &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                    </small>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col fs-3 fw-bold">
                                    &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?>
                                </div>
                                <div class="col mb-0">
                                    <small class="priceText mb-0">
                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?> Incl.
                                    </small>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if ($product['sale'] !== '0') {
                            echo '<div class="fs-4 text-danger">Nu ' . $product['sale'] . '% Korting!</div>';
                        }
                        if ($product['supply'] <= 10) {
                            ?>
                            <p class="mb-0">
                                <small class="priceText text-danger">
                                    Nog <?= $product['supply'] ?> op voorraad!
                                </small>
                            </p>
                            <?php
                        }
                        ?>

                        <form action="" method="post">
                            <input type="hidden" name="productID" value="<?= $product['productID'] ?>">
                            <div class="quantity buttons_added">
                                <div class="row text-center">
                                    <div class="col-9">
                                        <div class="row justify-content-center">
                                            <div class="col m-0 ms-2 p-0">
                                                <input class="minus btn w-100" type="button" value="-">
                                            </div>
                                            <div class="col px-1">
                                                <input class="form-control input-text qty text w-100" type="number"
                                                       step="1" min="1" max="<?= $product['supply'] ?>"
                                                       name="quantity" value="1" aria-label>
                                            </div>
                                            <div class="col m-0 me-2 p-0">
                                                <input class="plus btn w-100" type="button" value="+">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 p-0">
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
            <?php
        }
        ?>
        <hr class="text-second" style="opacity: 1">
    </div>

</div>

<div class="container p-3">
    <h3>Zelf samenstellen</h3>
    <div class="row row-cols-2 row-cols-sm-4 text-center text-main py-3">
        <div class="col my-2">
            <a href="school_package" class="text-decoration-none">
                <img loading="lazy" class="my-2" src="img/archive.svg" height="75" alt="">
                <br>
                Schoolpakket
            </a>
        </div>
<!--        <div class="col my-2">-->
<!--            <a href="office_package" class="text-decoration-none">-->
<!--                <img loading="lazy" class="my-2" src="img/archive.svg" height="75" alt="">-->
<!--                <br>-->
<!--                Kantoorpakket-->
<!--            </a>-->
<!--        </div>-->
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