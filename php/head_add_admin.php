<?php
include 'db.php';
session_start();

if (isset($_SESSION['login']) && $_SESSION['role'] === 'head') {

    $username = htmlspecialchars($_POST['adminUserName']);
    $password = htmlspecialchars($_POST['adminUserPassword']);
    $repeatPassword = htmlspecialchars($_POST['adminUserRepeatPassword']);
    $signature = str_replace(PHP_EOL, '<br>', htmlspecialchars($_POST['signature']));

    if ($password === $repeatPassword) {

        $checkUsernameRegister = $conn->prepare('SELECT * FROM `login` WHERE username = ?');
        $checkUsernameRegister->execute([$username]);
        $result = $checkUsernameRegister->fetch(PDO::FETCH_ASSOC);

        if ($checkUsernameRegister->rowCount() === 0) {
            $role = "admin";

            $addUserRegister = $conn->prepare("INSERT INTO login SET username = ?, password = ?, `role` = ?, signature = ?");
            $addUserRegister->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role, $signature]);

            $_SESSION['message'] = "Admin Toegevoegd";
        } else {
            $_SESSION['message'] = "Gebruikersnaam bestaat al";
        }

    } else {
        $_SESSION['message'] = "Wachtwoorden komen niet overeen";
    }

    header('Location: ../head_dashboard?headPage=adminUsers');
} else {
    header('Location: ../404');
}