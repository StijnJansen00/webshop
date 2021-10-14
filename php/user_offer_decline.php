<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'user') {
        if (isset($_POST["submit"])) {
            $offerID = htmlspecialchars($_POST['offerID']);

            if (htmlspecialchars($_POST['reason']) === 'other'){
                $reason = 'Anders, namelijk ' . $_POST['otherReason'];
            } else if (htmlspecialchars($_POST['reason']) === 'price') {
                $reason = 'Te duur';
            } else if (htmlspecialchars($_POST['reason']) === 'wrong') {
                $reason = 'Klopt niet';
            }

            $offerSigned = $conn->prepare("UPDATE offer SET offerAccepted = ?, offerDecline = ? WHERE offerID = ?");
            $offerSigned->execute(['-1', $reason, $offerID]);

            $selectUser = $conn->prepare("SELECT * FROM `user` u INNER JOIN offer f ON f.userID = u.userID WHERE u.userID = ? AND f.offerID = ?");
            $selectUser->execute([$_SESSION['userID'], $offerID]);
            $info = $selectUser->fetch();

//            include 'mail_offer_send_declined.php';

            $_SESSION['message'] = 'Offerte geweigerd';
            header("Location: ../user_offer_overview?offer=$offerID");
        } else {
            header("Location: ../404");
        }
    } else {
        header("Location: ../404");
    }
} else {
    header("Location: ../404");
}