<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $categoryID = htmlspecialchars($_POST['categoryID']);

            $addCategory = $conn->prepare("DELETE FROM category WHERE categoryID = ?");
            $addCategory->execute([$categoryID]);

            $_SESSION['message'] = 'Categorie is verwijderd';
            header('Location: ../admin_dashboard?adminPage=categories');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}