<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $offerID = htmlspecialchars($_POST['offerID']);
            $deleteOffer = $conn->prepare("DELETE FROM offer WHERE offerID = ?");
            $deleteOffer->execute([$offerID]);

            $_SESSION['message'] = 'Offerte is verwijderd';
            header('Location: ../admin_dashboard?adminPage=offers');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}