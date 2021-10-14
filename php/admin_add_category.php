<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $categoryName = htmlspecialchars($_POST['categoryName']);
            $image = file_get_contents($_FILES['categoryImage']['tmp_name']);

            $checkCategory = $conn->prepare("SELECT * FROM category WHERE categoryName = ?");
            $checkCategory->execute([$categoryName]);

            if ($checkCategory->rowCount() === 0) {
                $addCategory = $conn->prepare("INSERT INTO category SET categoryName = ?, categoryImg = ?");
                $addCategory->execute([$categoryName, $image]);

                $_SESSION['message'] = 'Categorie toegevoegd';
                header('Location: ../admin_dashboard?adminPage=categories');
            } else {
                $_SESSION['message'] = 'Categorie bestaat al';
                header('Location: ../admin_dashboard?adminPage=categories');
            }
        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}