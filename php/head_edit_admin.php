<?php
include "db.php";
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'head') {

        $login = htmlspecialchars($_POST['login']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $repeatPassword = htmlspecialchars($_POST['repeatPassword']);

        if (!empty($password)) {
            if ($password === $repeatPassword) {
                $updatePassword = $conn->prepare("UPDATE login SET username = ?, password = ? WHERE loginID = ?");
                $updatePassword->execute([$username, password_hash($password, PASSWORD_DEFAULT), $login]);

                $_SESSION['message'] = 'Admin gegevens zijn aangepast';
            } else {
                $_SESSION['message'] = 'Wachtwoorden zijn niet hetzelfde';
            }
        } else {
            $updatePassword = $conn->prepare("UPDATE login SET username = ? WHERE loginID = ?");
            $updatePassword->execute([$username, $login]);

            $_SESSION['message'] = 'Admin gegevens zijn aangepast';
        }

        header('Location: ../head_dashboard?headPage=adminUsers');
    } else {
        header('Location: 404');
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}