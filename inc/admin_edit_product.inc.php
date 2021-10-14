<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_GET['product'])) {

            $productID = $_GET['product'];

            $getProductInfo = $conn->prepare("
            SELECT * 
            FROM product p 
            INNER JOIN filter_product fp ON fp.productID = p.productID
            INNER JOIN filter f ON fp.filterID = f.filterID
            INNER JOIN category c ON c.categoryID = p.categoryID 
            WHERE p.productID = ?
            ");
            $getProductInfo->execute([$productID]);
            $result = $getProductInfo->fetch();

            ?>
            <title>Wijzig Product</title>
            <div class="container p-3">

                <a class="text-decoration-none text-main" href="admin_dashboard?adminPage=products">Terug</a>
                
                <div class="card border border-main mx-auto" style="max-width: 40rem">
                    <div class="card-body">
                        <h5 class="card-title">Wijzig <?= $result['productName'] ?></h5>
                        <form action="php/admin_edit_product.php" method="post" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="number" min="0" class="form-control"
                                       name="productEditNumber"
                                       id="productEditNumber" value="<?= $result['productNumber'] ?>" required>
                                <label for="productEditNumber">Product Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="productEditName" id="productEditName"
                                       value="<?= $result['productName'] ?>"
                                       required>
                                <label for="productEditName">Naam</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" min="0.00" step=".01" class="form-control"
                                       name="productEditPriceExcl"
                                       id="productEditPriceExcl" value="<?= $result['priceExcl'] ?>" required>
                                <label for="productEditPriceExcl">Prijs Excl</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" min="0.00" step=".01" class="form-control"
                                       name="productPricePurchase" id="productPricePurchase"
                                       value="<?= $result['pricePurchase'] ?>" required>
                                <label for="productPricePurchase">Prijs Inkoop</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" min="0" max="100" value="<?= $result['sale'] ?>"
                                       class="form-control"
                                       name="productEditSale" id="productEditSale" required>
                                <label for="productEditSale">Korting %</label>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                <textarea id="productEditDescription" class="form-control" style="height: 6rem"
                                          name="productEditDescription" required><?= $result['description'] ?>
                                </textarea>
                                    <label for="productEditDescription">Beschrijving</label>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" min="0" class="form-control" name="productEditSupply"
                                       id="productEditSupply"
                                       value="<?= $result['supply'] ?>" required>
                                <label for="productEditSupply">Voorraad</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"
                                       name="productEditEan"
                                       id="productEditEan" value="<?= $result['ean'] ?>" required>
                                <label for="productEditEan">EAN</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="productEditBrand" id="productEditBrand"
                                       value="<?= $result['brand'] ?>" required>
                                <label for="productEditBrand">Merk</label>
                            </div>
                            <div class="form-group mb-3">
                                <label for="productEditCategory">Categorie</label>
                                <select class="form-select form-select-lg border border-second" name="productEditCategory"
                                        id="productEditCategory">
                                    <option value="<?= $result['categoryID'] ?>"><?= $result['categoryName'] ?></option>
                                    <?php
                                    $categories = $conn->prepare("SELECT * FROM category WHERE categoryID <> ?");
                                    $categories->execute([$result['categoryID']]);

                                    foreach ($categories as $category) {
                                        ?>
                                        <option value="<?= $category['categoryID'] ?>"><?= $category['categoryName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="productEditFilters">Filters</label>
                                <select class="form-select form-select-lg border border-second" size="6"
                                        id="productEditFilters"
                                        name="productEditFilters[]" multiple
                                        aria-label="Filters">
                                    <option value="<?= $result['filterID'] ?>" selected><?= $result['name'] ?></option>
                                    <?php
                                    foreach ($getProductInfo as $result2) {
                                        echo '<option value="' . $result2['filterID'] . '" selected>' . $result2['name'] . '</option>';
                                    }

                                    $getProductFilters = $conn->prepare("SELECT filterID FROM filter_product WHERE productID = ?");
                                    $getProductFilters->execute([$result['productID']]);

                                    $sql = "SELECT * FROM filter ";
                                    $execute = [];
                                    $check = 'WHERE';

                                    foreach ($getProductFilters as $t) {
                                        $sql .= $check . ' filterID != ? ';
                                        $execute[] = array_push($execute, $t['filterID']);
                                        array_pop($execute);

                                        $check = 'AND';
                                    }
                                    $getAllFilters = $conn->prepare($sql);
                                    $getAllFilters->execute($execute);

                                    foreach ($getAllFilters as $r) {
                                        echo '<option value="' . $r['filterID'] . '">' . $r['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="productEditImage">Foto</label>
                                <input type="file" class="form-control" name="productEditImage" id="productEditImage">
                            </div>
                            <?php
                            if ($result['showInclPrice']) {
                                ?>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="showIncl" id="showIncl" checked>
                                    <label class="form-check-label" for="showIncl">
                                        Incl BTW prijs weergeven
                                    </label>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="showIncl" id="showIncl">
                                    <label class="form-check-label" for="showIncl">
                                        Incl BTW prijs weergeven
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="productID" value="<?= $result['productID'] ?>">
                            <button type="submit" name="submit" value="submit" class="btn btn-main">Opslaan</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}