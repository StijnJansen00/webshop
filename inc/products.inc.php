<?php
include 'php/db.php';

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

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];

    $sql = 'SELECT * 
            FROM product p 
            INNER JOIN filter_product fp ON fp.productID = p.productID 
            INNER JOIN filter f ON f.filterID = fp.filterID 
            INNER JOIN category ctg ON ctg.categoryID = p.categoryID 
            WHERE p.supply <> 0 ';

    if (!empty($_GET['search'])) {
        $search = htmlspecialchars($_GET['search']);
        $search = "%$search%";
        $sql .= "AND p.productName LIKE ? ";

        $execute = [$search];
        $sql .= 'AND ctg.categoryName = ? ';

        $execute[] = array_push($execute, $_GET['sort']);
        array_pop($execute);
    } else {
        $sql .= 'AND ctg.categoryName = ? ';
        $execute = [$_GET['sort']];
    }

    $selectPrice = $conn->prepare("SELECT max(priceExcl) AS priceMax FROM product");
    $selectPrice->execute();
    $price = $selectPrice->fetch();

    $priceMin = "0";
    $priceMax = ceil($price['priceMax']);

    $sqlFilters = " SELECT *
                    FROM filter f
                    INNER JOIN category_filter cf ON cf.filterID = f.filterID
                    INNER JOIN category ctg ON ctg.categoryID = cf.categoryID ";
    $selectedFilter = [];

    $sqlBrands = "  SELECT p.brand
                    FROM product p
                    INNER JOIN category AS ctg ON ctg.categoryID = p.categoryID ";
    $selectedBrand = [];

    if (isset($_POST['submit'])) {

        if ($_POST['submit'] === 'filter') {
            if (!empty($_POST['priceMin']) && !empty($_POST['priceMax'])) {
                $sql .= 'AND priceExcl > ? AND priceExcl < ? ';

                $execute[] = array_push($execute, $_POST['priceMin']);
                array_pop($execute);
                $execute[] = array_push($execute, $_POST['priceMax']);
                array_pop($execute);

                $priceMin = (float)$_POST['priceMin'];
                $priceMax = (float)$_POST['priceMax'];
            }

            if (!empty($_POST['brand'])) {
                $check = ' AND';
                $checkBrand = 'WHERE ';
                $sqlBrands = '  SELECT p.brand
                                FROM product p
                                INNER JOIN category AS ctg ON ctg.categoryID = p.categoryID ';

                foreach ($_POST['brand'] as $brandName) {
                    $sql .= $check . ' p.brand = ? ';
                    $check = 'OR';
                    $execute[] = array_push($execute, $brandName);
                    array_pop($execute);

                    $sqlBrands .= $checkBrand . 'p.brand != ? ';
                    $selectedBrand[] = array_push($selectedBrand, $brandName);
                    array_pop($selectedBrand);

                    $checkBrand = 'AND ';
                }
                $sqlBrands .= 'AND ctg.categoryName = ? GROUP BY p.brand ';
                $selectedBrand[] = array_push($selectedBrand, $_GET['sort']);
                array_pop($selectedBrand);
            } else {
                $sqlBrands .= 'WHERE ctg.categoryName = ? GROUP BY p.brand ';
                $selectedBrand[] = array_push($selectedBrand, $_GET['sort']);
                array_pop($selectedBrand);
            }

            if (!empty($_POST['filter'])) {
                $check = 'AND';
                $checkFilter = 'WHERE ';
                $sqlFilters = " SELECT *
                            FROM filter f
                            INNER JOIN category_filter cf ON cf.filterID = f.filterID
                            INNER JOIN category ctg ON ctg.categoryID = cf.categoryID ";
                foreach ($_POST['filter'] as $filterID) {
                    $sql .= $check . ' fp.filterID = ? ';
                    $check = 'OR';
                    $execute[] = array_push($execute, $filterID);
                    array_pop($execute);

                    $sqlFilters .= $checkFilter . 'f.filterID != ? ';
                    $selectedFilter[] = array_push($selectedFilter, $filterID);
                    array_pop($selectedFilter);

                    $checkFilter = 'AND ';
                }
                $sqlFilters .= 'AND ctg.categoryName = ?';
                $selectedFilter[] = array_push($selectedFilter, $_GET['sort']);
                array_pop($selectedFilter);
            } else {
                $sqlFilters .= 'WHERE ctg.categoryName = ?';
                $selectedFilter[] = array_push($selectedFilter, $_GET['sort']);
                array_pop($selectedFilter);
            }

            if (!empty($_POST['sale'])) {
                $sql .= 'AND p.sale > 0 ';
            }

            if (!empty($_POST['sort'])) {
                if ($_POST['sort'] === 'nameAsc') {
                    $sortProducts = 'ORDER BY p.productName ASC ';
                } else if ($_POST['sort'] === 'nameDesc') {
                    $sortProducts = 'ORDER BY p.productName DESC ';
                } else if ($_POST['sort'] === 'priceAsc') {
                    $sortProducts = 'ORDER BY p.priceExcl ASC ';
                } else if ($_POST['sort'] === 'priceDesc') {
                    $sortProducts = 'ORDER BY p.priceExcl DESC ';
                }
            }

        } else if ($_POST['submit'] === 'reset') {
            unset($_POST);

            $sqlBrands .= 'WHERE ctg.categoryName = ? GROUP BY p.brand ';
            $selectedBrand[] = array_push($selectedBrand, $_GET['sort']);
            array_pop($selectedBrand);

            $sqlFilters .= 'WHERE ctg.categoryName = ? ';
            $selectedFilter[] = array_push($selectedFilter, $_GET['sort']);
            array_pop($selectedFilter);
        }
    } else {
        if (!strpos($sql, 'GROUP BY f.name AND p.productName ')) {
            $sql .= ' GROUP BY p.productName ';
        }

        $sqlBrands .= 'WHERE ctg.categoryName = ? GROUP BY p.brand ';
        $selectedBrand[] = array_push($selectedBrand, $_GET['sort']);
        array_pop($selectedBrand);

        $sqlFilters .= 'WHERE ctg.categoryName = ? ';
        $selectedFilter[] = array_push($selectedFilter, $_GET['sort']);
        array_pop($selectedFilter);
    }
    $sql .= $sortProducts;

    $getTotalProducts = $conn->prepare("
        SELECT COUNT(p.productID) AS total
        FROM product p
        INNER JOIN category ctg ON ctg.categoryID = p.categoryID
        WHERE ctg.categoryName = ?");
    $getTotalProducts->execute([$_GET['sort']]);
    $total = $getTotalProducts->fetch();
    $productCount = $total['total'];

    $results_per_page = 12;
    $productPage = $_GET["productPage"] ?? 1;
    $start = ($productPage - 1) * $results_per_page;
    $totalPages = ceil($productCount / $results_per_page);

    $sql .= "LIMIT $start , $results_per_page";

    $selectAllFilters = $conn->prepare($sqlFilters);
    $selectAllFilters->execute($selectedFilter);

    $selectAllBrands = $conn->prepare($sqlBrands);
    $selectAllBrands->execute($selectedBrand);

    $getAllProducts = $conn->prepare($sql);
    $getAllProducts->execute($execute);
    ?>
    <title><?= $_GET['sort'] ?></title>
    <!--Header-->
    <div class="container-fluid p-0">
        <div class="header mb-3" style="background: url('img/header-products.webp') no-repeat right 50% bottom 43%;">
            <div class="text align-middle">
                <div class="container">
                    <h2 class="font-monospace text-uppercase">
                        <?= $_GET['sort'] ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-3">
        <div class="row mb-3">
            <div class="col-lg-3 col-sm-6">
                <form action="" method="get">
                    <button class="btn text-main" type="submit">Terug</button>
                </form>
            </div>
            <div class="col-lg-3 col-sm-6">
                <button type="button" class="btn fw-normal font-monospace pt-2" data-bs-toggle="modal"
                        data-bs-target="#filterModal">
                    Filter <i class="bi bi-layers"></i>
                </button>
            </div>
            <div class="col-lg-6 col-sm-12">
                <form action="" method="get">
                    <input type="hidden" name="sort" value="<?= $_GET['sort'] ?>">
                    <input type="hidden" name="productPage" value="<?= $_GET['productPage'] ?>">
                    <input type="search" class="form-control" id="productSearch" name="search"
                           placeholder="Zoek tussen <?= $_GET['sort'] ?> spullen"
                           aria-label="Search" value="<?php if (isset($_GET['search'])) {
                        echo $_GET['search'];
                    } ?>">
                </form>
            </div>
        </div>

        <div class="row row-cols-1 products">
            <?php
            foreach ($getAllProducts as $product) {
                $suggestedPrice = number_format((float)$product['suggestedPrice'], 2, ',', '.');
                $priceExcl = $product['priceExcl'];
                $priceIncl = $priceExcl * 1.21;
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
                                    <input type="hidden" name="sort" value="<?= $_GET['sort'] ?>">
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

                            <form class="mt-1" action="" method="post">
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

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item <?php if ($productPage <= 1) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link" href="?sort=<?= $sort ?>&productPage=1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item <?php if ($productPage <= 1) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link" href="<?php if ($productPage <= 1) {
                        echo '#';
                    } else {
                        echo "?sort=$sort&productPage=" . ($productPage - 1);
                    } ?>">
                        Vorige
                    </a>
                </li>
                <li class="page-item <?php if ($productPage >= $totalPages) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link" href="<?php if ($productPage >= $totalPages) {
                        echo '#';
                    } else {
                        echo "?sort=$sort&productPage=" . ($productPage + 1);
                    } ?>">
                        Volgende
                    </a>
                </li>
                <li class="page-item <?php if ($productPage >= $totalPages) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link" href="?sort=<?= $sort ?>&productPage=<?= $totalPages ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border border-main">
                <div class="modal-header border-bottom border-main">
                    <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">

                        <div class="fw-bold fs-4">Sorteer</div>
                        <div class="input-group mb-3">
                            <select class="form-select border border-main" name="sort" aria-label="Sorteren">
                                <option selected>Sorteer</option>
                                <option value="nameAsc">Naam (A-Z)</option>
                                <option value="nameDesc">Naam (Z-A)</option>
                                <option value="priceAsc">Prijs Oplopend</option>
                                <option value="priceDesc">Prijs Aflopend</option>
                            </select>
                        </div>

                        <div class="fw-bold fs-4">Prijs</div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="priceMin" value="<?= $priceMin ?>"
                                           min="0.00" max="<?= $priceMax ?>" step="0.01" id="priceMin" placeholder="Min.">
                                    <label for="priceMin">Min.</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="priceMax" value="<?= $priceMax ?>"
                                           min="0.00" max="<?= $priceMax ?>" step="0.01" id="priceMax" placeholder="Max.">
                                    <label for="priceMax">Max.</label>
                                </div>
                            </div>
                        </div>

                        <div class="fw-bold fs-4">Merk</div>
                        <?php
                        if (isset($_POST['brand'])) {
                            foreach ($_POST['brand'] as $selectedB) {
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="brand[]"
                                           value="<?= $selectedB ?>" id="brand" checked>
                                    <label class="form-check-label" for="brand">
                                        <?= $selectedB ?>
                                    </label>
                                </div>
                                <?php
                            }
                        }

                        foreach ($selectAllBrands as $brand) {
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="brand[]"
                                       value="<?= $brand['brand'] ?>" id="brand">
                                <label class="form-check-label" for="brand">
                                    <?= $brand['brand'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="fw-bold fs-4">Categorie</div>
                        <?php
                        if (isset($_POST['filter'])) {
                            foreach ($_POST['filter'] as $selectedF) {
                                $getFilterName = $conn->prepare("SELECT `name` FROM filter WHERE filterID = ?");
                                $getFilterName->execute([$selectedF]);
                                $res = $getFilterName->fetch();
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="filter[]"
                                           value="<?= $selectedF ?>" id="filter" checked>
                                    <label class="form-check-label" for="filter">
                                        <?= $res['name'] ?>
                                    </label>
                                </div>
                                <?php
                            }
                        }

                        foreach ($selectAllFilters as $filters) {
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="filter[]"
                                       value="<?= $filters['filterID'] ?>" id="filter">
                                <label class="form-check-label" for="filter">
                                    <?= $filters['name'] ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="fw-bold fs-4">Sale</div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sale" id="brand">
                            <label class="form-check-label" for="brand">
                                SALE
                            </label>
                        </div>

                        <button class="btn btn-main my-2" type="submit" name="submit" value="filter">Toepassen</button>
                        <button class="btn btn-secondary my-2" type="submit" name="submit" value="reset">Reset</button>
                    </form>
                </div>

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

    $getAllCategories = $conn->prepare("SELECT * FROM category WHERE categoryName <> 'Pakket'");
    $getAllCategories->execute();
    ?>
    <title>Categorieën</title>
    <!--Header-->
    <div class="container-fluid p-0">
        <div class="header mb-3" style="background: url('img/header-categories.webp') no-repeat right 50% bottom 32%;">
            <div class="text align-middle">
                <div class="container">
                    <h2 class="font-monospace text-uppercase">
                        Categorieën
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-3">
        <div class="row row-cols-2 row-cols-sm-5 justify-content-center text-center text-main py-3">
            <?php
            foreach ($getAllCategories as $resultCategory) {
                ?>
                <div class="col my-2">
                    <a href="products?sort=<?= $resultCategory['categoryName'] ?>&productPage=1"
                       class="text-decoration-none">
                        <img loading="lazy" class="mb-1"
                             style="height: 3rem"
                             src="data:image/svg+xml;base64,<?= base64_encode($resultCategory['categoryImg']) ?>"
                             alt="afbeelding <?= $resultCategory['categoryName'] ?>">
                        <br>
                        <?= $resultCategory['categoryName'] ?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
