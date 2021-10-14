<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $selectOffers = $conn->prepare("
            SELECT * 
            FROM offer f 
            INNER JOIN `user` u ON u.userID = f.userID 
            INNER JOIN orderNumbers AS `on` ON on.orderNumbersID = f.offerNumber
            ORDER BY offerNumber DESC");
        $selectOffers->execute();
        ?>
        <title>Offertes</title>
        <div class="hide container-fluid table-responsive border border-main mb-3 px-5" id="CRUD_Offers" style="max-width: 80rem;">

            <div class="container">
                <h4 class="mb-2">Offerte Overzicht</h4>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3">
                        <form action="admin_offer_create" method="post">
                            <button type="submit" class="btn btn-second">
                                Offerte Aanmaken
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3">
                        <input type="search" class="form-control" id="offerSearch" placeholder="Zoek Offerte"
                               aria-label="Search">
                    </div>
                </div>
            </div>

            <div class="table-scroll" style="height: 30rem">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Offerte Nummer</th>
                        <th>Datum</th>
                        <th>Bedrijf</th>
                        <th>Ontvanger</th>
                        <th>Adres</th>
                        <th class="text-center">*</th>
                    </tr>
                    </thead>
                    <tbody id="offerTable">
                    <?php
                    foreach ($selectOffers as $offer) {
                        $reminder = '';

                        if ($offer['offerAccepted'] === '0') {
                            if (strtotime($offer['offerDate']) < strtotime('-21 days') && !$offer['reminder21']) {
                                $reminder = '21';
                                include 'php/mail_reminder_send.php';

                                $updateReminder = $conn->prepare("UPDATE offer SET reminder21 = ? WHERE offerID = ?");
                                $updateReminder->execute([true, $offer['offerID']]);
                            } else if (strtotime($offer['offerDate']) < strtotime('-14 days') && !$offer['reminder14']) {
                                $reminder = '14';
                                include 'php/mail_reminder_send.php';

                                $updateReminder = $conn->prepare("UPDATE offer SET reminder14 = ? WHERE offerID = ?");
                                $updateReminder->execute([true, $offer['offerID']]);
                            } else if (strtotime($offer['offerDate']) < strtotime('-8 days') && !$offer['reminder8']) {
                                $reminder = '8';
                                include 'php/mail_reminder_send.php';

                                $updateReminder = $conn->prepare("UPDATE offer SET reminder8 = ? WHERE offerID = ?");
                                $updateReminder->execute([true, $offer['offerID']]);
                            }
                        }

                        if ($offer['offerAccepted'] === '-1') {
                            echo '<tr class="align-middle" style="background-color: rgba(255, 0, 0, 0.25);">';
                            echo '<td><i class="bi bi-x"></i> Geweigerd</td>';
                        } else if ($offer['offerAccepted']) {
                            echo '<tr class="align-middle" style="background-color: rgba(100, 187, 154, 0.25);">';
                            echo '<td><i class="bi bi-check"></i> Goed</td>';
                        } else {
                            echo '<tr class="align-middle" style="background-color: rgba(13, 202, 240, 0.25);">';
                            echo '<td><i class="bi bi-x"></i> Open</td>';
                        }
                        ?>
                        <td><?= $offer['numb'] ?></td>
                        <td><?= $offer['offerDate'] ?></td>
                        <td><?= $offer['company'] ?></td>
                        <td><?= $offer['name'] . ' ' . $offer['surname'] ?></td>
                        <td><?= $offer['street'] . ' ' . $offer['number'] . ' ' . $offer['zipcode'] . ' ' . $offer['city'] ?></td>
                        <td>
                            <div class="row">
                                <form class="col-4" action="admin_offer_overview" method="get">
                                    <input type="hidden" value="<?= $offer['offerID'] ?>" name="offerNr">
                                    <button type="submit" class="btn btn-main">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </form>
                                <?php
                                if (!$offer['offerAccepted']) {
                                    ?>
                                    <form class="col-4" action="php/admin_delete_offer.php" method="post">
                                        <input type="hidden" value="<?= $offer['offerID'] ?>" name="offerID">
                                        <button type="submit" name="submit" class="btn btn-danger"
                                                onclick="return confirm(`Weet je zeker dat je deze offerte wilt verwijderen?`);">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </td>
                        <?php
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            $(document).ready(function () {
                $("#offerSearch").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#offerTable tr").filter(function () {
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