<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $loginID = $_POST['loginID'];
            $deleteOffer = $conn->prepare("DELETE FROM login WHERE loginID = ?");
            $deleteOffer->execute([$loginID]);

            $_SESSION['message'] = 'Account is verwijderd';
            header('Location: ../head_dashboard?headPage=adminUsers');

        }
    }
} else {
    header('Location: 404');
}