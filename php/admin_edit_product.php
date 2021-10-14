<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (!empty($_POST['productEditFilters'])) {

            $productID = htmlspecialchars($_POST['productID']);
            $productNumber = htmlspecialchars($_POST['productEditNumber']);
            $name = htmlspecialchars($_POST['productEditName']);
            $priceExcl = htmlspecialchars($_POST['productEditPriceExcl']);
            $pricePurchase = htmlspecialchars($_POST['productPricePurchase']);
            $sale = htmlspecialchars($_POST['productEditSale']);
            $desc = htmlspecialchars($_POST['productEditDescription']);
            $supply = htmlspecialchars($_POST['productEditSupply']);
            $ean = htmlspecialchars($_POST['productEditEan']);
            $brand = htmlspecialchars($_POST['productEditBrand']);
            $category = htmlspecialchars($_POST['productEditCategory']);
            $showIncl = htmlspecialchars($_POST['showIncl']);
            $image = file_get_contents($_FILES['productEditImage']['tmp_name']);
            $filters = $_POST['productEditFilters'];

            if ($showIncl === 'on'){
                $showI = '1';
            } else {
                $showI = '0';
            }

            if (!empty($image)) {
                $editProduct = $conn->prepare("
                    UPDATE product
                    SET productNumber = ?,
                        productName = ?,
                        priceExcl = ?,
                        pricePurchase = ?,
                        sale = ?,
                        img = ?,
                        description = ?,
                        supply = ?,
                        ean = ?,
                        brand = ?,
                        categoryID = ?,
                        showInclPrice = ?
                    WHERE productID = ?");
                $editProduct->execute([
                    $productNumber,
                    $name,
                    $priceExcl,
                    $pricePurchase,
                    $sale,
                    $image,
                    $desc,
                    $supply,
                    $ean,
                    $brand,
                    $category,
                    $showI,
                    $productID
                ]);
            } else {
                $editProduct = $conn->prepare("
                    UPDATE product
                    SET productNumber = ?,
                        productName = ?,
                        priceExcl = ?,
                        pricePurchase = ?,
                        sale = ?,
                        description = ?,
                        supply = ?,
                        ean = ?,
                        brand = ?,
                        categoryID = ?,
                        showInclPrice = ?
                    WHERE productID = ?");
                $editProduct->execute([
                    $productNumber,
                    $name,
                    $priceExcl,
                    $pricePurchase,
                    $sale,
                    $desc,
                    $supply,
                    $ean,
                    $brand,
                    $category,
                    $showI,
                    $productID
                ]);
            }

            $removeOldFilters = $conn->prepare("DELETE FROM filter_product WHERE productID = ?");
            $removeOldFilters->execute([$productID]);

            foreach ($filters as $filter) {
                $addFilters = $conn->prepare("INSERT INTO filter_product SET filterID = ?, productID = ?");
                $addFilters->execute([$filter, $productID]);
            }

            $_SESSION['message'] = 'Product gewijzigd';
            header('Location: ../admin_dashboard?adminPage=products');

        } else {
            $_SESSION['message'] = 'Er zijn geen filter(s) geselecteerd';
            header('Location: ../admin_edit_product?product=' . $_POST['productID']);
        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}