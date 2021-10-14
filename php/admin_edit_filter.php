<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $filterName = htmlspecialchars($_POST['filterName']);
            $filterID = htmlspecialchars($_POST['filterID']);

            $addFilter = $conn->prepare("UPDATE filter SET `name` = ? WHERE filterID = ?");
            $addFilter->execute([$filterName, $filterID]);

            $_SESSION['message'] = 'Filter gewijzigd';
            header('Location: ../admin_dashboard?adminPage=filters');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}