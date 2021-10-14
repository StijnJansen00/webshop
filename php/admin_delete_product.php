<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $productID = htmlspecialchars($_POST['productID']);

            $addFilter = $conn->prepare("DELETE FROM product WHERE productID = ?");
            $addFilter->execute([$productID]);

            $_SESSION['message'] = 'Product is verwijderd';
            header('Location: ../admin_dashboard?adminPage=products');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}