<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $signature = str_replace(PHP_EOL, '<br>', htmlspecialchars($_POST['signature']));

            $addFilter = $conn->prepare("UPDATE login SET signature = ? WHERE loginID = ?");
            $addFilter->execute([$signature, $_SESSION['loginID']]);

            $_SESSION['message'] = 'Handtekening gewijzigd';
            header('Location: ../admin_acc');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}