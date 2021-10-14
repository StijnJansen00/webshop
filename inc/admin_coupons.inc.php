<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $selectCoupons = $conn->prepare("SELECT * FROM coupon");
        $selectCoupons->execute();

        ?>
        <div class="hide container border border-main mb-3 px-5" id="CRUD_Coupons">

            <h4 class="my-2">Coupons Overzicht</h4>

            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <button type="button" class="btn btn-second" data-bs-toggle="modal"
                            data-bs-target="#addCouponModal">
                        Coupon Toevoegen
                    </button>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <input type="search" class="form-control" id="couponSearch" placeholder="Zoek Coupon"
                           aria-label="Search">
                </div>
            </div>

            <div class="table-scroll" style="height: 30rem; max-width: 40rem;">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Eenmalig</th>
                        <th>Waarde</th>
                        <th>Verloopt op</th>
                        <th class="text-end">*</th>
                    </tr>
                    </thead>
                    <tbody id="couponTable">
                    <?php
                    $date = date("Y-m-d");
                    foreach ($selectCoupons as $coupon) {
                        if ($date > $coupon['endDate']) {
                            $deleteCoupon = $conn->prepare("DELETE FROM coupon WHERE couponID = ?");
                            $deleteCoupon->execute([$coupon['couponID']]);
                        }

                        if ($coupon['oneTime'] === '1') {
                            $one = 'Ja';
                        } else {
                            $one = 'Nee';
                        }
                        ?>
                        <tr class="align-middle">
                            <td><?= $coupon['coupon'] ?></td>
                            <td><?= $one ?></td>
                            <td>
                                <?php
                                if ($coupon['eur'] === '1') {
                                    echo $coupon['value'] . ' &euro;';
                                } else {
                                    echo $coupon['value'] . ' %';
                                }
                                ?>
                            </td>
                            <td><?= $coupon['endDate'] ?></td>
                            <td>
                                <form class="col text-end" action="php/admin_delete_coupon.php" method="post">
                                    <input type="hidden" name="couponID" value="<?= $coupon['couponID'] ?>">
                                    <button type="submit" name="submit" class="btn btn-danger"
                                            onclick="return confirm(`Weet je zeker dat je deze coupon wilt verwijderen?`);">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModal"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCouponModal">Coupon Toevoegen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="php/admin_add_coupon.php" method="post">
                                <div class="form-floating mb-3">
                                    <input type="number" min="0" class="form-control" name="value" id="value"
                                           placeholder="Waarde" required>
                                    <label for="value">Waarde</label>
                                </div>
                                <div class="row ms-2 mb-3" style="max-width: 15rem;">
                                    <div class="col form-check">
                                        <input class="form-check-input" type="checkbox" name="oneTime" id="oneTime">
                                        <label class="form-check-label" for="oneTime">
                                            Eenmalig
                                        </label>
                                    </div>
                                    <div class="col row" style="max-width: 10rem;">
                                        <div class="col form-check">
                                            <input class="form-check-input" type="radio" name="eur" value="per" id="per"
                                                   checked>
                                            <label class="form-check-label" for="per">
                                                %
                                            </label>
                                        </div>
                                        <div class="col form-check">
                                            <input class="form-check-input" type="radio" name="eur" value="eur"
                                                   id="eur">
                                            <label class="form-check-label" for="eur">
                                                &euro;
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="endDate">Eind Datum</label>
                                    <input class="form-control" type="date" name="endDate" id="endDate">
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-main">
                                    Maak Code
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $("#couponSearch").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#couponTable tr").filter(function () {
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