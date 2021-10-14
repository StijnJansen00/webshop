<?php
include "php/db.php";
?>
<title>Maak je pakket</title>
<!--Header-->
<div class="container-fluid p-0">
    <div class="header mb-3" style="background: url('img/header-package.webp') no-repeat right 50% bottom 35%;">
        <div class="text align-middle">
            <div class="container">
                <h3 class="font-monospace text-uppercase">
                    Maak je eigen schoolpakket
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="container p-3">

    <form action="">

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingBackpack">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseBackpack" aria-expanded="true" aria-controls="collapseBackpack">
                        Kies je Rugzak
                    </button>
                </h2>
                <div id="collapseBackpack" class="accordion-collapse collapse show" aria-labelledby="headingBackpack"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectBackpacks = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Rugtas' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectBackpacks->execute();

                            foreach ($selectBackpacks as $backpack) {
                                $suggestedPrice = number_format((float)$backpack['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$backpack['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second backpack mb-3"
                                         onclick="selectBackpack(this.id)" id="<?= $backpack['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($backpack['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $backpack['brand'] ?></span>
                                                <br>
                                                <?= $backpack['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $backpack['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($backpack['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($backpack['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $backpack['sale'] . '% Korting!</div>';
                                            }
                                            if ($backpack['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $backpack['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second backpack active mx-auto mb-3"
                                 onclick="selectBackpack(this.id)" id="noBackpack" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Rugtas
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseCovers"
                                aria-expanded="true" aria-controls="collapseCovers">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCovers">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseCovers" aria-expanded="false" aria-controls="collapseCovers">
                        Kies je Rekbare Kaften
                    </button>
                </h2>
                <div id="collapseCovers" class="accordion-collapse collapse" aria-labelledby="headingCovers"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectCovers = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Kaften' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectCovers->execute();

                            foreach ($selectCovers as $cover) {
                                $suggestedPrice = number_format((float)$cover['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$cover['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second cover mb-3"
                                         onclick="selectCover(this.id)" id="<?= $cover['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($cover['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $cover['brand'] ?></span>
                                                <br>
                                                <?= $cover['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $cover['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($cover['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($cover['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $cover['sale'] . '% Korting!</div>';
                                            }
                                            if ($cover['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $cover['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second backpack active mx-auto mb-3"
                                 onclick="selectCovers(this.id)" id="noCovers" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Kaften
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseBackpack"
                                aria-expanded="true" aria-controls="collapseBackpack">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseLabel"
                                aria-expanded="true" aria-controls="collapseLabel">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingLabel">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseLabel" aria-expanded="false" aria-controls="collapseLabel">
                        Kies je Label
                    </button>
                </h2>
                <div id="collapseLabel" class="accordion-collapse collapse" aria-labelledby="headingLabel"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectLabels = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Etiket' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectLabels->execute();

                            foreach ($selectLabels as $label) {
                                $suggestedPrice = number_format((float)$label['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$label['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second label mb-3"
                                         onclick="selectLabel(this.id)" id="<?= $label['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($label['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $label['brand'] ?></span>
                                                <br>
                                                <?= $label['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $label['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($label['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($label['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $label['sale'] . '% Korting!</div>';
                                            }
                                            if ($label['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $label['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second backpack active mx-auto mb-3"
                                 onclick="selectLabel(this.id)" id="noLabel" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Etiketten
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseCovers"
                                aria-expanded="true" aria-controls="collapseCovers">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseAgenda"
                                aria-expanded="true" aria-controls="collapseAgenda">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAgenda">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseAgenda" aria-expanded="false" aria-controls="collapseAgenda">
                        Kies je Agenda
                    </button>
                </h2>
                <div id="collapseAgenda" class="accordion-collapse collapse" aria-labelledby="headingAgenda"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectAgenda = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Agenda' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectAgenda->execute();

                            foreach ($selectAgenda as $agenda) {
                                $suggestedPrice = number_format((float)$agenda['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$agenda['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second agenda mb-3" onclick="selectAgenda(this.id)"
                                         id="<?= $agenda['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($agenda['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $agenda['brand'] ?></span>
                                                <br>
                                                <?= $agenda['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $agenda['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($agenda['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($agenda['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $agenda['sale'] . '% Korting!</div>';
                                            }
                                            if ($agenda['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $agenda['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second agenda active mx-auto mb-3"
                                 onclick="selectAgenda(this.id)" id="noAgenda" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Agenda
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseLabel"
                                aria-expanded="true" aria-controls="collapseLabel">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEtui"
                                aria-expanded="true" aria-controls="collapseEtui">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEtui">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseEtui" aria-expanded="false" aria-controls="collapseEtui">
                        Kies je Etui
                    </button>
                </h2>
                <div id="collapseEtui" class="accordion-collapse collapse" aria-labelledby="headingEtui"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectEtui = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Etui' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectEtui->execute();

                            foreach ($selectEtui as $etui) {
                                $suggestedPrice = number_format((float)$etui['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$etui['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second etui mb-3" onclick="selectEtui(this.id)"
                                         id="<?= $etui['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($etui['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $etui['brand'] ?></span>
                                                <br>
                                                <?= $etui['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $etui['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($etui['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($etui['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $etui['sale'] . '% Korting!</div>';
                                            }
                                            if ($etui['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $etui['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second etui active mx-auto mb-3"
                                 onclick="selectEtui(this.id)" id="noEtui" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Etui
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseAgenda"
                                aria-expanded="true" aria-controls="collapseAgenda">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePen"
                                aria-expanded="true" aria-controls="collapsePen">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePen" aria-expanded="false" aria-controls="collapsePen">
                        Kies je Pen
                    </button>
                </h2>
                <div id="collapsePen" class="accordion-collapse collapse" aria-labelledby="headingPen"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectPen = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Pen' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectPen->execute();

                            foreach ($selectPen as $pen) {
                                $suggestedPrice = number_format((float)$pen['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$pen['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second pen mb-3" onclick="selectPen(this.id)"
                                         id="<?= $pen['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($pen['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $pen['brand'] ?></span>
                                                <br>
                                                <?= $pen['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $pen['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($pen['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($pen['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $pen['sale'] . '% Korting!</div>';
                                            }
                                            if ($pen['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $pen['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second pen active mx-auto mb-3"
                                 onclick="selectPen(this.id)" id="noPen" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Pen
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEtui"
                                aria-expanded="true" aria-controls="collapseEtui">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePencil"
                                aria-expanded="true" aria-controls="collapsePencil">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPencil">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePencil" aria-expanded="false" aria-controls="collapsePencil">
                        Kies je Potlood
                    </button>
                </h2>
                <div id="collapsePencil" class="accordion-collapse collapse" aria-labelledby="headingPencil"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectPencil = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Potlood' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectPencil->execute();

                            foreach ($selectPencil as $pencil) {
                                $suggestedPrice = number_format((float)$pencil['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$pencil['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second pencil mb-3" onclick="selectPencil(this.id)"
                                         id="<?= $pencil['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($pencil['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $pencil['brand'] ?></span>
                                                <br>
                                                <?= $pencil['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $pencil['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($pencil['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($pencil['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $pencil['sale'] . '% Korting!</div>';
                                            }
                                            if ($pencil['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $pencil['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second pen active mx-auto mb-3"
                                 onclick="selectPencil(this.id)" id="noPencil" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Potlood
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePen"
                                aria-expanded="true" aria-controls="collapsePen">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRuler"
                                aria-expanded="true" aria-controls="collapseRuler">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingRuler">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseRuler" aria-expanded="false" aria-controls="collapseRuler">
                        Kies je Liniaal
                    </button>
                </h2>
                <div id="collapseRuler" class="accordion-collapse collapse" aria-labelledby="headingRuler"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectRuler = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Liniaal' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectRuler->execute();

                            foreach ($selectRuler as $ruler) {
                                $suggestedPrice = number_format((float)$ruler['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$ruler['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second ruler mb-3" onclick="selectRuler(this.id)"
                                         id="<?= $ruler['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($ruler['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $ruler['brand'] ?></span>
                                                <br>
                                                <?= $ruler['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $ruler['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($ruler['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($ruler['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $ruler['sale'] . '% Korting!</div>';
                                            }
                                            if ($ruler['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $ruler['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second pen active mx-auto mb-3"
                                 onclick="selectRuler(this.id)" id="noRuler" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Liniaal
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePencil"
                                aria-expanded="true" aria-controls="collapsePencil">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseGeoRuler"
                                aria-expanded="true" aria-controls="collapseGeoRuler">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGeoRuler">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseGeoRuler" aria-expanded="false" aria-controls="collapseGeoRuler">
                        Kies je Geodriehoek
                    </button>
                </h2>
                <div id="collapseGeoRuler" class="accordion-collapse collapse" aria-labelledby="headingGeoRuler"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectGeoRuler = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Geodriehoek' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectGeoRuler->execute();

                            foreach ($selectGeoRuler as $geoRuler) {
                                $suggestedPrice = number_format((float)$geoRuler['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$geoRuler['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second geoRuler mb-3" onclick="selectGeoRuler(this.id)"
                                         id="<?= $geoRuler['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($geoRuler['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $geoRuler['brand'] ?></span>
                                                <br>
                                                <?= $geoRuler['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $geoRuler['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($geoRuler['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($geoRuler['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $geoRuler['sale'] . '% Korting!</div>';
                                            }
                                            if ($geoRuler['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $geoRuler['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second pen active mx-auto mb-3"
                                 onclick="selectGeoRuler(this.id)" id="noGeoRuler" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Geodriehoek
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRuler"
                                aria-expanded="true" aria-controls="collapseRuler">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePaper"
                                aria-expanded="true" aria-controls="collapsePaper">
                            Volgende
                        </button>
                        <button class="btn btn-second" type="button" onclick="addPackage()">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPaper">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePaper" aria-expanded="false" aria-controls="collapsePaper">
                        Kies je Papier
                    </button>
                </h2>
                <div id="collapsePaper" class="accordion-collapse collapse" aria-labelledby="headingPaper"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectPaper = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Papier' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectPaper->execute();

                            foreach ($selectPaper as $paper) {
                                $suggestedPrice = number_format((float)$paper['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$paper['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second paper mb-3" onclick="selectPaper(this.id)"
                                         id="<?= $paper['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($paper['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $paper['brand'] ?></span>
                                                <br>
                                                <?= $paper['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $paper['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($paper['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($paper['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $paper['sale'] . '% Korting!</div>';
                                            }
                                            if ($paper['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $paper['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second pen active mx-auto mb-3"
                                 onclick="selectPaper(this.id)" id="noPaper" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Papier
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseGeoRuler"
                                aria-expanded="true" aria-controls="collapseGeoRuler">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseStitcher"
                                aria-expanded="true" aria-controls="collapseStitcher">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingStitcher">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseStitcher" aria-expanded="false" aria-controls="collapseStitcher">
                        Kies je Snelhechter
                    </button>
                </h2>
                <div id="collapseStitcher" class="accordion-collapse collapse" aria-labelledby="headingStitcher"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center mb-3">
                            <?php
                            $selectStitcher = $conn->prepare("
                                SELECT *
                                FROM product p
                                INNER JOIN filter_product fp ON fp.productID = p.productID
                                INNER JOIN filter f ON f.filterID = fp.filterID
                                WHERE f.name = 'Snelhechter' AND p.supply <> 0
                                ORDER BY p.priceExcl
                            ");
                            $selectStitcher->execute();

                            foreach ($selectStitcher as $stitcher) {
                                $suggestedPrice = number_format((float)$stitcher['suggestedPrice'], 2, ',', '.');
                                $suggestedPrice = str_replace('.', ',', $suggestedPrice);
                                $priceExcl = number_format((float)$stitcher['priceExcl'], 2, ',', '.');
                                $priceIncl = (int)$priceExcl * 1.21;
                                $priceExcl = str_replace('.', ',', $priceExcl);
                                ?>
                                <div class="col" id="productInfo">
                                    <div class="card border border-second stitcher mb-3" onclick="selectStitcher(this.id)"
                                         id="<?= $stitcher['productID'] ?>">
                                        <div class="card-body">
                                            <p class="text-center">
                                                <img loading="lazy" style="height: 5rem;" alt=""
                                                     src="data:image/png;base64,<?= base64_encode($stitcher['img']) ?>">
                                            </p>
                                            <div class="fs-6 title">
                                                <span class="fw-bold fs-5"><?= $stitcher['brand'] ?></span>
                                                <br>
                                                <?= $stitcher['productName'] ?>
                                            </div>
                                            <div class="fw-light">
                                                <small>#<?= $stitcher['productNumber'] ?></small>
                                            </div>
                                            <div class="row row-cols-1">
                                                <?php
                                                if ($stitcher['showInclPrice']) {
                                                    ?>
                                                    <div class="col fs-3 fw-bold">
                                                        &euro;<?= number_format((float)$priceIncl, 2, ',', '.') ?>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <small class="priceText mb-0">
                                                            &euro;<?= number_format((float)$priceExcl, 2, ',', '.') ?> Excl.
                                                        </small>
                                                    </div>
                                                    <div class="w-100">
                                                        <p class="mb-0">Prijs is incl BTW</p>
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
                                            if ($stitcher['sale'] !== '0') {
                                                echo '<div class="fs-4 text-danger">Nu ' . $stitcher['sale'] . '% Korting!</div>';
                                            }
                                            if ($stitcher['supply'] <= 10) {
                                                ?>
                                                <p class="mb-0">
                                                    <small class="priceText text-danger">Nog maar <?= $stitcher['supply'] ?> op voorraad!</small>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="card border border-second pen active mx-auto mb-3"
                                 onclick="selectStitcher(this.id)" id="noStitcher" style="max-width: 15rem">
                                <div class="card-body text-center">
                                    Geen Snelhechter
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-second" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePaper"
                                aria-expanded="true" aria-controls="collapsePaper">
                            Terug
                        </button>
                        <button class="btn btn-second" type="button" onclick="addPackage()">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>