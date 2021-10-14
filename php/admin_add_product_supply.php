<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $supply = htmlspecialchars($_POST['productSupply']);
            $id = htmlspecialchars($_POST['productIDSupply']);

            $addFilter = $conn->prepare("UPDATE product SET supply = (supply + ?) WHERE productID = ?");
            $addFilter->execute([$supply, $id]);

            $_SESSION['message'] = 'Voorraad toegevoegd';
            header('Location: ../admin_dashboard?adminPage=products');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}
