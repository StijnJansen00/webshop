<?php
include 'db.php';
session_start();

if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
    if (isset($_POST['submit'])) {

        $productNumber = htmlspecialchars($_POST['productNumber']);
        $name = htmlspecialchars($_POST['productName']);
        $priceExcl = htmlspecialchars($_POST['productPriceExcl']);
        $pricePurchase = htmlspecialchars($_POST['productPricePurchase']);
        $priceSuggested = htmlspecialchars($_POST['productPriceSuggested']);
        $sale = htmlspecialchars($_POST['productSale']);
        $desc = htmlspecialchars($_POST['productDescription']);
        $supply = htmlspecialchars($_POST['productSupply']);
        $ean = htmlspecialchars($_POST['productEan']);
        $brand = htmlspecialchars($_POST['productBrand']);
        $category = htmlspecialchars($_POST['productCategory']);
        $filters = $_POST['productFilters'];
        $image = file_get_contents($_FILES['productImage']['tmp_name']);

        if ($_POST['showIncl'] === 'on'){
            $showI = '1';
        } else {
            $showI = '0';
        }

        $checkProductExists = $conn->prepare("SELECT productNumber FROM product WHERE productNumber = ?");
        $checkProductExists->execute([$productNumber]);

        if ($checkProductExists->rowCount() === 0) {
            $addProduct = $conn->prepare("
                INSERT INTO product
                    SET productNumber = ?,
                        productName = ?,
                        priceExcl = ?,
                        pricePurchase = ?,
                        suggestedPrice = ?,
                        sale = ?,
                        img = ?,
                        description = ?,
                        supply = ?,
                        ean = ?,
                        brand = ?,
                        categoryID = ?,
                        showInclPrice = ?");
            $addProduct->execute([
                $productNumber,
                $name,
                $priceExcl,
                $pricePurchase,
                $priceSuggested,
                $sale,
                $image,
                $desc,
                $supply,
                $ean,
                $brand,
                $category,
                $showI
            ]);
            $productID = $conn->lastInsertId();

            foreach ($filters as $filter) {
                $addFilterToProduct = $conn->prepare("INSERT INTO filter_product SET filterID = ?, productID = ?");
                $addFilterToProduct->execute([
                    $filter,
                    $productID
                ]);
            }

            $_SESSION['message'] = 'Product is toegevoegd';
        } else {
            $_SESSION['message'] = 'Product Nummer bestaat al';
        }
        header('Location: ../admin_dashboard?adminPage=products');

    }
} else {
    header('Location: ../404');
}