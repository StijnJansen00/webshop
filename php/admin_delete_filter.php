<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $filterID = htmlspecialchars($_POST['filterID']);

            $deleteFilter = $conn->prepare("DELETE FROM filter WHERE filterID = ?");
            $deleteFilter->execute([$filterID]);

            $_SESSION['message'] = 'Filter is verwijderd';
            header('Location: ../admin_dashboard?adminPage=filters');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}