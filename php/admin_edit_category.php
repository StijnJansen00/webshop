<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $categoryID = htmlspecialchars($_POST['categoryID']);
            $categoryName = htmlspecialchars($_POST['editCategoryName']);
            $image = file_get_contents($_FILES['editCategoryImage']['tmp_name']);

            if (!empty($image)){
                $editCategory = $conn->prepare("UPDATE category SET categoryName = ?, categoryImg = ? WHERE categoryID = ?");
                $editCategory->execute([$categoryName, $image, $categoryID]);
            } else {
                $editCategory = $conn->prepare("UPDATE category SET categoryName = ? WHERE categoryID = ?");
                $editCategory->execute([$categoryName, $categoryID]);
            }

            $_SESSION['message'] = 'Categorie gewijzigd';
            header('Location: ../admin_dashboard?adminPage=categories');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}