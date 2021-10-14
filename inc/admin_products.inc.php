<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $products = $conn->prepare("SELECT * FROM product p INNER JOIN category c ON c.categoryID = p.categoryID");
        $products->execute();

        ?>
        <div class="hide container-fluid border border-main mb-3" id="CRUD_Products">

            <div class="container">
                <h4 class="my-2">Producten Overzicht</h4>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3">
                        <button type="button" class="btn btn-second" data-bs-toggle="modal"
                                data-bs-target="#addProductModal">
                            Product Toevoegen
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3">
                        <input type="search" class="form-control" id="productSearch" placeholder="Zoek Producten"
                               aria-label="Search">
                    </div>
                </div>
            </div>

            <div class="table-scroll mb-5" style="height: 25rem">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Naam</th>
                        <th>Prijs Excl.</th>
                        <th>Prijs Inkoop</th>
                        <th>Categorie</th>
                        <th class="text-center" style="width: 5rem">Incl</th>
                        <th class="text-center" style="width: 5rem">%</th>
                        <th style="width: 10rem">Beschrijving</th>
                        <th class="text-center" style="width: 5rem">Vooraad</th>
                        <th>EAN</th>
                        <th>Merk</th>
                        <th>IMG</th>
                        <th class="text-center">*</th>
                    </tr>
                    </thead>
                    <tbody id="productTable">
                    <?php
                    foreach ($products as $product) {
                        $priceExcl = number_format((float)$product['priceExcl'], 2, ',', '.');
                        $priceExcl = str_replace('.', ',', $priceExcl);

                        if ($product['showInclPrice']) {
                            $showIncl = 'Ja';
                        } else {
                            $showIncl = 'Nee';
                        }
                        ?>
                        <tr class="align-middle">
                            <td><?= $product['productNumber'] ?></td>
                            <td><?= $product['productName'] ?></td>
                            <td>&euro;<?= $priceExcl ?></td>
                            <td>&euro;<?= $product['pricePurchase'] ?></td>
                            <td><?= $product['categoryName'] ?></td>
                            <td class="text-center" style="width: 5rem"><?= $showIncl ?></td>
                            <td class="text-center" style="width: 5rem"><?= $product['sale'] ?>%</td>
                            <td style="text-overflow: ellipsis; overflow: hidden; width: 10rem; height: 1rem; white-space: nowrap;">
                                <?= $product['description'] ?>
                            </td>
                            <td class="text-center" style="width: 5rem"><?= $product['supply'] ?></td>
                            <td><?= $product['ean'] ?></td>
                            <td><?= $product['brand'] ?></td>
                            <td>
                                <img loading="lazy" style="height: 3rem;"
                                     src="data:image/png;base64,<?= base64_encode($product['img']) ?>"
                                     alt="">
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-4">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#editProductSale"
                                                data-bs-saleInfo="<?= $product['productID'] ?>, <?= $product['productName'] ?>, <?= $product['sale'] ?>">
                                            <i class="bi bi-percent"></i>
                                        </button>
                                    </div>
                                    <form class="col-4" action="admin_edit_product" method="get">
                                        <input type="hidden" value="<?= $product['productID'] ?>" name="product">
                                        <button type="submit" class="btn btn-main">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                    <form class="col-4" action="php/admin_delete_product.php" method="post">
                                        <input type="hidden" value="<?= $product['productID'] ?>" name="productID">
                                        <button type="submit" name="submit" class="btn btn-main"
                                                onclick="return confirm(`Weet je zeker dat je dit product wilt verwijderen?`);">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>


            <div class="container mb-3">
                <h4 class="my-2">Product Voorraad&nbsp;&nbsp;<&nbsp;&nbsp;15</h4>
                <?php
                $productsSupply = $conn->prepare("SELECT * FROM product WHERE supply <= 15");
                $productsSupply->execute();

                if ($productsSupply->rowCount() > 0) {
                ?>
                <div class="table-scroll mb-3" style="height: 20rem">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Naam</th>
                            <th>Vooraad</th>
                            <th>EAN</th>
                            <th>Merk</th>
                            <th>IMG</th>
                            <th>*</th>
                        </tr>
                        </thead>
                        <tbody id="productSupplyTable">
                        <?php
                        foreach ($productsSupply as $supply) {
                            $priceExcl = number_format((float)$supply['priceExcl'], 2, ',', '.');
                            $priceExcl = str_replace('.', ',', $priceExcl);
                            ?>
                            <tr class="align-middle">
                                <td><?= $supply['productNumber'] ?></td>
                                <td><?= $supply['productName'] ?></td>
                                <td><?= $supply['supply'] ?></td>
                                <td><?= $supply['ean'] ?></td>
                                <td><?= $supply['brand'] ?></td>
                                <td>
                                    <img loading="lazy" style="height: 3rem;"
                                         src="data:image/png;base64,<?= base64_encode($supply['img']) ?>"
                                         alt="">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-second" data-bs-toggle="modal"
                                            data-bs-target="#editProductSupply"
                                            data-bs-supplyInfo="<?= $supply['productID'] ?>, <?= $supply['productName'] ?>">
                                        <i class="bi bi-inboxes"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        ?>
                        <div class="text-second">
                            <p>Er zijn geen producten met een voorraad minder dan 15</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>


            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModal"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border border-main">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModal">Product Toevoegen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="php/admin_add_product.php" method="post" enctype="multipart/form-data">
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col form-floating mb-3">
                                        <input type="number" min="0" class="form-control" name="productNumber"
                                               id="productNumber"
                                               placeholder="Product Nummer" required>
                                        <label for="productNumber">Product Nummer</label>
                                    </div>
                                    <div class="col form-floating mb-3">
                                        <input type="text" class="form-control" name="productName" id="productName"
                                               placeholder="Naam"
                                               required>
                                        <label for="productName">Naam</label>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col form-floating mb-3">
                                        <input type="number" min="0.00" step=".01" class="form-control"
                                               name="productPriceExcl"
                                               id="productPriceExcl"
                                               placeholder="Prijs Excl" required>
                                        <label for="productPriceExcl">Prijs Excl</label>
                                    </div>
                                    <div class="col form-floating mb-3">
                                        <input type="number" min="0.00" step=".01" class="form-control"
                                               name="productPricePurchase"
                                               id="productPricePurchase"
                                               placeholder="Prijs Inkoop" required>
                                        <label for="productPricePurchase">Prijs Inkoop</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" min="0.00" step=".01" class="form-control"
                                           name="productPriceSuggested"
                                           id="productPriceSuggested"
                                           placeholder="Voorgestelde Prijs" required>
                                    <label for="productPriceSuggested">Voorgestelde Prijs</label>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" min="0" max="100" value="0" class="form-control"
                                               name="productSale"
                                               id="productSale"
                                               placeholder="Korting %" required>
                                        <label for="productSale">Korting %</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" min="0" class="form-control" name="productSupply"
                                               id="productSupply"
                                               placeholder="Voorraad"
                                               required>
                                        <label for="productSupply">Voorraad</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                <textarea id="productDescription" class="form-control" placeholder="Beschrijving"
                                          style="height: 6rem"
                                          name="productDescription" required></textarea>
                                        <label for="productDescription">Beschrijving</label>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col form-floating mb-3">
                                        <input type="number" class="form-control"
                                               name="productEan"
                                               id="productEan" placeholder="EAN"
                                               required>
                                        <label for="productEan">EAN</label>
                                    </div>
                                    <div class="col form-floating mb-3">
                                        <input type="text" class="form-control" name="productBrand" id="productBrand"
                                               placeholder="Merk" required>
                                        <label for="productBrand">Merk</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="productCategory">Categorie</label>
                                    <select class="form-select form-select-lg border border-second"
                                            name="productCategory"
                                            id="productCategory">
                                        <?php
                                        $categories = $conn->prepare("SELECT * FROM category");
                                        $categories->execute();

                                        foreach ($categories as $category) {
                                            ?>
                                            <option value="<?= $category['categoryID'] ?>"><?= $category['categoryName'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="productFilters">Filters</label>
                                    <select class="form-select form-select-lg border border-second" size="5"
                                            id="productFilters"
                                            name="productFilters[]" multiple
                                            aria-label="Filters">
                                        <?php
                                        $filters = $conn->prepare("SELECT * FROM filter");
                                        $filters->execute();

                                        foreach ($filters as $filter) {
                                            ?>
                                            <option value="<?= $filter['filterID'] ?>"><?= $filter['name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="productImage">Foto</label>
                                    <input type="file" class="form-control" name="productImage" id="productImage">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="showIncl" id="showIncl">
                                    <label class="form-check-label" for="showIncl">
                                        Incl BTW prijs weergeven
                                    </label>
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-main">Toevoegen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editProductSale" tabindex="-1" aria-labelledby="editProductSaleLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductSaleLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="php/admin_edit_product_sale.php" method="post">
                                <div class="form-floating mb-3">
                                    <input type="number" min="0" max="100" step="1" class="form-control"
                                           name="productSale" id="editProductSale" value="" required>
                                    <label for="editProductSale">Korting %</label>
                                    <input type="hidden" name="productID" id="productID">
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-main">Opslaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editProductSupply" tabindex="-1" aria-labelledby="editProductSupplyLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductSupplyLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="php/admin_add_product_supply.php" method="post">
                                <div class="form-floating mb-3">
                                    <input type="number" min="1" step="1" class="form-control" value="1"
                                           name="productSupply" id="editProductSupply" required>
                                    <label for="editProductSupply">Voorraad</label>
                                    <input type="hidden" name="productIDSupply" id="productIDSupply">
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-second">Toevoegen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            let editProductSale = document.getElementById('editProductSale')

            editProductSale.addEventListener('show.bs.modal', function (event) {

                let button = event.relatedTarget
                let productInfo = button.getAttribute('data-bs-saleInfo')
                let info = productInfo.split(',')
                let title = editProductSale.querySelector('.modal-title')
                let sale = editProductSale.querySelector('.modal-body #editProductSale')
                let productID = editProductSale.querySelector('.modal-body #productID')

                title.textContent = 'Wijzig Sale ' + info[1]
                productID.value = info[0]
                sale.value = info[2]
            })

            let editProductSupply = document.getElementById('editProductSupply')

            editProductSupply.addEventListener('show.bs.modal', function (event) {

                let button = event.relatedTarget
                let productInfo = button.getAttribute('data-bs-supplyInfo')
                let info = productInfo.split(',')
                let title = editProductSupply.querySelector('.modal-title')
                let productID = editProductSupply.querySelector('.modal-body #productIDSupply')

                title.textContent = 'Wijzig Voorraad ' + info[1]
                productID.value = info[0]
            })

            $(document).ready(function () {
                $("#productSearch").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#productTable tr").filter(function () {
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