<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        ?>
        <div class="container p-3">

            <h2 class="text-center text-second mb-3">Nieuwe Offerte</h2>

            <div class="card border border-second mx-auto p-3" style="max-width: 50rem">
                <div class="card-body">
                    <form action="php/admin_add_offer.php" method="post">

                        <div class="row">
                            <div class="col-12 mb-3">
                                <select class="form-select border-second" name="user"
                                        aria-label="Gebruikers" style="height: calc(3.5rem + 2px)">
                                    <option value="">Selecteer Gebruiker</option>
                                    <?php
                                    $getUsers = $conn->prepare("SELECT * FROM `user`");
                                    $getUsers->execute();

                                    foreach ($getUsers as $u) {
                                        ?>
                                        <option value="<?= $u['userID'] ?>"><?= $u['company'] . ' - ' . $u['name'] . ' ' . $u['surname'] . ' - ' . $u['zipcode'] . ' ' . $u['number'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="newUser" id="newUserCheck"
                                   onclick="showCreateUser()">
                            <label class="form-check-label" for="newUserCheck">
                                Gebruiker Aanmaken
                            </label>
                        </div>

                        <hr class="mb-3 mt-0">

                        <div class="hide" id="createUser">
                            <div class="row">
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="text" class="form-control" name="companyName"
                                           id="floatingCompanyName" placeholder="Bedrijfsnaam">
                                    <label for="floatingCompanyName">Bedrijfsnaam</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="number" min="10000000" class="form-control" name="kvk" id="floatingKvK"
                                           placeholder="KvK">
                                    <label for="floatingKvK">KvK</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="text" class="form-control" name="name" id="floatingName"
                                           placeholder="Naam">
                                    <label for="floatingName">Naam</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="text" class="form-control" name="surname" id="floatingSurname"
                                           placeholder="Acternaam">
                                    <label for="floatingSurname">Acternaam</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="email" class="form-control" name="email" id="floatingEmail"
                                           placeholder="Email">
                                    <label for="floatingEmail">Email</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating mb-3">
                                    <input type="tel" class="form-control" name="phone" id="floatingPhone"
                                           placeholder="Tel">
                                    <label for="floatingPhone">Tel</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-8 form-floating mb-3">
                                    <input type="text" class="form-control" name="street" id="floatingStreet"
                                           placeholder="Straat">
                                    <label for="floatingStreet">Straat</label>
                                </div>
                                <div class="col-12 col-md-4 form-floating mb-3">
                                    <input type="number" class="form-control" name="number" id="floatingNumber"
                                           placeholder="Huisnummer">
                                    <label for="floatingNumber">Huisnummer</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-8 form-floating mb-3">
                                    <input type="text" class="form-control" name="city" id="floatingCity"
                                           placeholder="Plaats">
                                    <label for="floatingCity">Plaats</label>
                                </div>
                                <div class="col-12 col-md-4 form-floating mb-3">
                                    <input type="text" class="form-control" name="zipcode" id="floatingZipcode"
                                           placeholder="Postcode">
                                    <label for="floatingZipcode">Postcode</label>
                                </div>
                            </div>
                            <hr class="mb-3 mt-0">
                        </div>

                        <div id="offerProducts">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <select class="form-select border-second" name="products[productID][]"
                                            aria-label="Producten" dir="rtl"
                                            style="height: calc(3.5rem + 2px)">
                                        <?php
                                        $selectAllProducts = $conn->prepare("SELECT * FROM product");
                                        $selectAllProducts->execute();

                                        foreach ($selectAllProducts as $product) {
                                            ?>
                                            <option value="<?= $product['productID'] ?>"><?= $product['productName'] ?>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&euro;<?= $product['priceExcl'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3 form-floating mb-3">
                                    <input type="number" class="form-control" name="products[amount][]"
                                           id="floatingAmount" placeholder="Aantal" required>
                                    <label for="floatingAmount">Aantal</label>
                                </div>
                                <div class="col-6 col-md-3 form-floating mb-3">
                                    <input type="number" step=".01" min="0" class="form-control"
                                           name="products[price][]"
                                           id="floatingPriceExcl" placeholder="Prijs">
                                    <label for="floatingPriceExcl">Prijs</label>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-3 mt-0">

                        <div class="row row-cols-1 row-cols-md-2 mb-3">
                            <div class="col row mb-3">
                                <div class="col-2 fs-2" style="padding-top: 0.4rem;">
                                    &euro;
                                </div>
                                <div class="col-10 form-floating mb-3">
                                    <input type="number" step=".01" min="0" class="form-control" name="priceTotal"
                                           id="floatingPriceTotal" placeholder="Totaal Prijs">
                                    <label for="floatingPriceTotal">Totaal Prijs</label>
                                </div>
                            </div>
                            <div class="col row mb-3">
                                <div class="col-8 pt-3">
                                    <h5 class="text-second text-end">Producten</h5>
                                </div>
                                <div class="col-4 pt-2 text-center">
                                    <button type="button" class="btn" id="addProductToOffer">
                                        <i class="fs-5 bi-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="customEmail" id="message"
                                   onclick="showCustomEmail()">
                            <label class="form-check-label" for="message">
                                Eigen bericht maken
                            </label>
                        </div>

                        <div class="show" id="emailMessageBlockStandard">
                            <h5 class="card-title mb-3">Email bericht</h5>
                            <p>
                                Geachte heer/mevrouw {ACHTERNAAM}
                            </p>
                            <p>
                                Hartelijk dank voor uw offerte aanvraag. Met genoegen bieden wij u vrijblijvend onze
                                prijsopgave aan. Deze treft u in de bijlage aan. Heeft u vragen of opmerkingen naar
                                aanleiding van deze offerte, neem dan gerust contact met mij op.
                            </p>
                            <p>
                                {HANDTEKENING}
                            </p>
                        </div>

                        <div class="hide" id="emailMessageBlock">
                            <h5 class="card-title mb-3">Email bericht</h5>
                            <p>
                                Geachte heer/mevrouw {ACHTERNAAM}
                            </p>
                            <textarea class="w-100 mb-3" name="emailMessage" id="emailMessage" rows="10"
                                      aria-label="Email"></textarea>
                            <p>
                                Met vriendelijke groeten,
                                <br>
                                {HANDTEKENING}
                            </p>
                        </div>

                        <button class="btn btn-main" type="submit" name="submit"
                                onclick="return confirm('Kloppen de gegevens?')">
                            Offerte Aanmaken
                        </button>

                    </form>
                </div>
            </div>
        </div>

        <script>
            $(function () {
                $('#addProductToOffer').click(function () {
                    var newDiv = $('<div class="row">' +
                        '<div class="col-12 col-md-6 mb-3">' +
                        '<select class="form-select border-second" name="products[productID][]" aria-label="Producten" dir="rtl" style="height: calc(3.5rem + 2px)">' +
                        '<?php $selectAllProducts = $conn->prepare("SELECT * FROM product");?>' +
                        '<?php $selectAllProducts->execute();?>' +
                        '<?php foreach ($selectAllProducts as $product) {?>' +
                        '<option value="<?= $product['productID'] ?>"><?= $product['productName']?>&nbsp;&nbsp;&nbsp;&nbsp;&euro;<?= $product['priceExcl'] ?></option>' +
                        '<?php } ?>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-6 col-md-3 form-floating mb-3">' +
                        '<input type="number" class="form-control" name="products[amount][]" id = "floatingAmount" placeholder = "Aantal" required > ' +
                        '<label for="floatingAmount">Aantal</label>' +
                        '</div>' +
                        '<div class="col-6 col-md-3 form-floating mb-3">' +
                        '<input type="number" step=".01" min="0" class="form-control" name="products[price][]" id="floatingPriceExcl" placeholder="Prijs">' +
                        '<label for="floatingPriceExcl">Prijs</label>' +
                        '</div></div></div>');
                    $('#offerProducts').append(newDiv);
                });
            });

            function showCreateUser() {
                let checkbox = document.getElementById('newUserCheck')
                let user = document.getElementById("createUser")

                if (checkbox.checked) {
                    if (user.classList.contains('hide')) {
                        user.classList.remove("hide")
                        user.classList.add("show")
                    }
                } else {
                    if (user.classList.contains('show')) {
                        user.classList.remove("show")
                        user.classList.add("hide")
                    }
                }
            }
        </script>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}
