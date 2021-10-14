<?php
include 'php/db.php';
?>
<title>Winkelwagen</title>
<!--Header-->
<div class="container-fluid p-0">
    <div class="header mb-3" style="background: url('img/header-cart.webp') no-repeat right 50% bottom 48%;">
        <div class="text align-middle">
            <div class="container">
                <h2 class="font-monospace text-uppercase">
                    Winkelwagen
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="container p-3">

    <?php
    if (!empty($_SESSION['cart'])) {
        ?>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="cart_items">
                    <?php
                    $totalExcl = 0;
                    $totalIncl = 0;

                    foreach ($_SESSION['cart'] as $id => $res) {
                        $getCartProducts = $conn->prepare("SELECT * FROM product WHERE productID = ?");
                        $getCartProducts->execute([$id]);
                        $result = $getCartProducts->fetch();

                        if (isset($_POST['quantity'])) {
                            $quantityID = $_POST['productID'];
                            $quantity[$quantityID] = $_POST['quantity'];
                            $_SESSION['cart'][$quantityID]['quantity'] = $quantity[$quantityID];
                        } else {
                            $quantity[$id] = $res['quantity'];
                        }

                        if ($result['sale'] > 0) {
                            $sale = ($result['priceExcl'] / 100) * $result['sale'];
                            $p = $result['priceExcl'] - $sale;
                            $excl = $p * $res['quantity'];
                            $priceExcl = $result['priceExcl'] - $sale;
                        } else {
                            $excl = $result['priceExcl'] * $res['quantity'];
                            $priceExcl = $result['priceExcl'];
                        }
                        $incl = $excl * 1.21;

                        ?>
                        <ul class="border border-second">
                            <li class="cart_item clearfix">
                                <div class="row row-cols-3 row-cols-sm-6 justify-content-around">
                                    <div class="col cart_item_image p-0">
                                        <img loading="lazy" class="p-0"
                                             src="data:image/png;base64,<?= base64_encode($result['img']) ?>">
                                    </div>
                                    <div class="col pt-4 px-0">
                                        <?= $result['brand'] ?>
                                        <div class="cart_item_text pt-2">
                                            <?= $result['productName'] ?>
                                        </div>
                                    </div>
                                    <?php
                                    if ($result['sale'] > 0) {
                                        ?>
                                        <div class="col pt-4 px-0" style="max-width: 4rem;">
                                            <div class="cart_item_title">SALE</div>
                                            <div class="text-main pt-2">
                                                <?= $result['sale'] ?>%
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        echo '<div class="col" style="max-width: 4rem;"></div>';
                                    }
                                    ?>
                                    <div class="col pt-4 px-0" style="max-width: 8rem;">
                                        <div class="cart_item_title text-center">Aantal</div>
                                        <div class="quantity buttons_added">
                                            <form action="" method="post">
                                                <div class="text-center pt-2" id="quantity<?= $id ?>">
                                                    <?= $res['quantity'] ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 p-0">
                                                        <input type="hidden" name="id" value="<?= $id ?>">
                                                        <input type="hidden" name="action" value="plus">
                                                        <button type="button" class="btn green"
                                                                onclick="deleteProduct(<?= $id ?>, 'plus', <?= $priceExcl ?>, <?= $result['supply'] ?>)">
                                                            <i class="bi bi-plus text-main"
                                                               style="font-size: 1.2rem;"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-4 p-0">
                                                        <input type="hidden" name="id" value="<?= $id ?>">
                                                        <input type="hidden" name="action" value="minus">
                                                        <button type="button" class="btn green"
                                                                onclick="deleteProduct(<?= $id ?>, 'minus', <?= $priceExcl ?>, <?= $result['supply'] ?>)">
                                                            <i class="bi bi-dash text-main"
                                                               style="font-size: 1.2rem;"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-4 p-0">
                                                        <input type="hidden" name="id" value="<?= $id ?>">
                                                        <input type="hidden" name="action" value="minus">
                                                        <button type="button" class="btn green"
                                                                onclick="deleteProduct(<?= $id ?>, 'delete', <?= $priceExcl ?>, <?= $result['supply'] ?>)">
                                                            <i class="bi bi-trash text-danger"
                                                               style="font-size: 1.2rem;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col pt-4 px-0" style="max-width: 5rem;">
                                        <div class="cart_item_title">Excl. BTW</div>
                                        <div class="cart_item_text pt-2" id="excl<?= $id ?>">
                                            €<?= number_format((float)$excl, 2, ',', '') ?>
                                        </div>
                                    </div>
                                    <div class="col pt-4 px-0" style="max-width: 5rem;">
                                        <div class="cart_item_title">Incl. BTW</div>
                                        <div class="cart_item_text pt-2" id="incl<?= $id ?>">
                                            €<?= number_format((float)$incl, 2, ',', '') ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <?php
                        $totalExcl += $excl;
                    }
                    $totalIncl = $totalExcl * 1.21;
                    if ($totalIncl <= 65) {
                        $sendPrice = 6.95;
                    } else {
                        $sendPrice = '0.00';
                    }
                    $totalIncl += $sendPrice;
                    ?>
                </div>
                <div class="text-end mx-auto my-2 px-2">
                    <div class="text-right">
                        <div class="order_total_title">Totaal Excl. BTW:</div>
                        <div class="order_total_amount" id="totalExcl">
                            €<?= number_format((float)$totalExcl, 2, '.', '') ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="order_total_title">Verzendkosten:</div>
                        <div class="order_total_amount" id="sendPrice">
                            €<?= $sendPrice ?>
                        </div>
                    </div>
                    <div class="ms-auto" style="max-width: 14rem;">
                        <hr>
                    </div>
                    <div class="text-right">
                        <div class="order_total_title">Totaal Incl. BTW:</div>
                        <div class="order_total_amount" id="totalIncl">
                            €<?= number_format((float)$totalIncl, 2, '.', '') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 offset-lg-1">
                <button type="submit" id="btnInfo" class="show my-2 btn btn-main" onclick="showInfo()">
                    Gegevens Invullen
                </button>
            </div>
            <?php
            $totalE = $totalExcl + $sendPrice;
            ?>
        </div>
        <div class="hide my-3" id="orderInfo">
            <div class="col-12 col-md-8 mx-auto">
                <h4 class="red mb-3">Verzend Gegevens</h4>

                <form action="" method="post" id="orderInfoForm">
                    <input type="hidden" name="checked" id="checked" value="false">
                    <?php
                    if (!isset($_SESSION['login'])) {
                        ?>
                        <div class="row ms-2 mb-3" style="max-width: 15rem;">
                            <div class="col form-check">
                                <input class="form-check-input" type="radio" name="companyOrder" value="business"
                                       id="business" onclick="companyInfo()" checked>
                                <label class="form-check-label" for="business">
                                    Zakelijk
                                </label>
                            </div>
                            <div class="col form-check">
                                <input class="form-check-input" type="radio" name="companyOrder" value="private"
                                       id="private" onclick="companyInfo()">
                                <label class="form-check-label" for="private">
                                    Particulier
                                </label>
                            </div>
                        </div>
                        <div class="show" id="companyInfo">
                            <div class="row">
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="text" class="form-control" name="companyName" id="CompanyName"
                                           placeholder="bedrijfsnaam" required>
                                    <label for="CompanyName">Bedrijfsnaam</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="number" min="0" class="form-control" name="kvk" id="KvK"
                                           placeholder="KvK" required>
                                    <label for="KvK">KvK</label>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="Name" placeholder="Naam"
                                       required>
                                <label for="Name">Naam</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="surname" id="Surname"
                                       placeholder="Achternaam"
                                       required>
                                <label for="Surname">Achternaam</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="Email" placeholder="Email"
                                       required>
                                <label for="Email">Email</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="phone" id="Phone" placeholder="Mobiel"
                                       required>
                                <label for="Phone">Tel</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="street" id="Street"
                                       placeholder="Straat" required>
                                <label for="Street">Straat</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="number" id="StrNumber"
                                       placeholder="Huis Nr + Hs" required>
                                <label for="Number">Huis Nr + Hs</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="city" id="City" placeholder="Plaats"
                                       required>
                                <label for="City">Plaats</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="zipcode" id="Zipcode"
                                       placeholder="Postcode" required>
                                <label for="Zipcode">Postcode</label>
                            </div>
                        </div>
                        <?php
                    } else {

                        $selectSendInfoUser = $conn->prepare("SELECT * FROM user u INNER JOIN login l ON l.loginID = u.loginID WHERE l.loginID = ?");
                        $selectSendInfoUser->execute([$_SESSION['loginID']]);
                        $resultUserSelect = $selectSendInfoUser->fetch();

                        if (!empty($resultUserSelect['company']) && !empty($resultUserSelect['kvk'])) {
                            ?>
                            <div class="row">
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="text" class="form-control" name="companyName" id="CompanyName"
                                           value="<?= $resultUserSelect['company'] ?>" required>
                                    <label for="CompanyName">Bedrijfsnaam</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="number" min="0" class="form-control" name="kvk" id="KvK"
                                           value="<?= $resultUserSelect['kvk'] ?>" required>
                                    <label for="KvK">KvK</label>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="row">
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="text" class="form-control" name="companyName" id="CompanyName"
                                           placeholder="bedrijfsnaam">
                                    <label for="CompanyName">Bedrijfsnaam</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="number" min="0" class="form-control" name="kvk" id="KvK"
                                           placeholder="KvK">
                                    <label for="KvK">KvK</label>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="Name"
                                       value="<?= $resultUserSelect['name'] ?>" required>
                                <label for="Name">Naam</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="surname" id="Surname"
                                       value="<?= $resultUserSelect['surname'] ?>" required>
                                <label for="Surname">Achternaam</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="Email"
                                       value="<?= $resultUserSelect['email'] ?>" required>
                                <label for="Email">Email</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="phone" id="Phone"
                                       value="<?= $resultUserSelect['phone'] ?>" required>
                                <label for="Phone">Tel</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="street" id="Street"
                                       value="<?= $resultUserSelect['street'] ?>" required>
                                <label for="Street">Straat</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="number" id="StrNumber"
                                       value="<?= $resultUserSelect['number'] ?>" required>
                                <label for="StrNumber">Huis Nr + Hs</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="city" id="City"
                                       value="<?= $resultUserSelect['city'] ?>" required>
                                <label for="City">Plaats</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="zipcode" id="Zipcode"
                                       value="<?= $resultUserSelect['zipcode'] ?>" required>
                                <label for="Zipcode">Postcode</label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input mx-1" type="checkbox" name="addressCheck"
                                   id="addressInfo"
                                   onclick="showDiffAddress()">
                            <label class="form-check-label" for="addressInfo">
                                Factuur adres is anders dan verzend adres
                            </label>
                        </div>
                    </div>

                    <div class="hide" id="diffAddress">
                        <h4 class="red my-2">Factuur Gegevens</h4>

                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="invoiceName" id="InvoiceName"
                                       placeholder="Naam">
                                <label for="InvoiceName">Naam</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="invoiceSurname" id="InvoiceSurname"
                                       placeholder="Achternaam">
                                <label for="InvoiceSurname">Achternaam</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-floating mb-3">
                                <input type="text" class="form-control" name="invoicePhone" id="InvoicePhone"
                                       placeholder="Mobiel">
                                <label for="InvoicePhone">Tel</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="invoiceStreet" id="InvoiceStreet"
                                       placeholder="Straat">
                                <label for="InvoiceStreet">Straat</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="invoiceNumber" id="InvoiceNumber"
                                       placeholder="Huis Nr + Hs">
                                <label for="InvoiceNumber">Huis Nr + Hs</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="invoiceCity" id="InvoiceCity"
                                       placeholder="Plaats">
                                <label for="InvoiceCity">Plaats</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="invoiceZipcode" id="InvoiceZipcode"
                                       placeholder="Postcode">
                                <label for="InvoiceZipcode">Postcode</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-lg-6">
                            <p class="m-0">Referentie toevoegen aan uw bestelling?</p>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="reference" id="reference"
                                       placeholder="Referentie">
                                <label for="reference">Referentie</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <p class="m-0">Heeft u een kortingscode?</p>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="coupon" id="coupon"
                                       placeholder="Kortingscode">
                                <label for="coupon">Kortingscode</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="totalExcl" id="priceExcl"
                           value="<?= number_format((float)$totalE, 2, '.', '') ?>">

                    <button class="btn btn-main" type="button" onclick="checkCartInfo()">Door naar betalen</button>
                </form>

            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="container p-3">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <div class="fs-4 py-2">Uw winkelwagen is leeg</div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
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