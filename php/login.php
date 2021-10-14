<?php
require "db.php";
session_start();

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $checkLogin = $conn->prepare('SELECT * FROM `login` WHERE username = ?');
    $checkLogin->execute([$username]);
    $result = $checkLogin->fetch(PDO::FETCH_ASSOC);

    if ($checkLogin->rowCount() > 0 && password_verify($password, $result['password'])) {
        if ($result['role'] === 'head') {
            $_SESSION['login'] = true;
            $_SESSION['loginID'] = $result['loginID'];
            $_SESSION['role'] = 'head';

            header("Location: ../head_dashboard?headPage=adminUsers");
        } else if ($result['role'] === 'admin') {
            $_SESSION['login'] = true;
            $_SESSION['loginID'] = $result['loginID'];
            $_SESSION['role'] = 'admin';

            header("Location: ../admin_dashboard?adminPage=orders");
        } else if ($result['role'] === 'user') {
            $_SESSION['login'] = true;
            $_SESSION['loginID'] = $result['loginID'];
            $_SESSION['role'] = 'user';

            header("Location: ../user_acc");
        }
    } else {
        $_SESSION['message'] = "Gebruikersnaam en/of wachtwoord onjuist";
        header("Location: ../login?login=login");
    }
} else {
    header("Location: ../404");
}
