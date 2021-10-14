<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $productSale = htmlspecialchars($_POST['productSale']);
            $productID = htmlspecialchars($_POST['productID']);

            $editSale = $conn->prepare("UPDATE product SET sale = ? WHERE productID = ?");
            $editSale->execute([$productSale, $productID]);

            $_SESSION['message'] = 'Korting gewijzigd';
            header('Location: ../admin_dashboard?adminPage=products');

        } else {
            header('Location: 404');
        }
    } else {
        header('Location: 404');
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}