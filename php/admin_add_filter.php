<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['filterName']);

            $checkFilter = $conn->prepare("SELECT * FROM filter WHERE name = ?");
            $checkFilter->execute([$name]);

            if ($checkFilter->rowCount() === 0) {
                $addFilter = $conn->prepare("INSERT INTO filter SET `name` = ?");
                $addFilter->execute([$name]);

                $_SESSION['message'] = 'Filter toegevoegd';
                header('Location: ../admin_dashboard?adminPage=filters');
            } else {
                $_SESSION['message'] = 'Filter bestaat al';
                header('Location: ../admin_dashboard?adminPage=filters');
            }
        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}