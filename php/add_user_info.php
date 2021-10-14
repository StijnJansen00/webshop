<?php
include 'db.php';
session_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['company'])) {
        $company = htmlspecialchars($_POST['company']);
    } else {
        $company = '';
    }
    if (isset($_POST['kvk'])) {
        $kvk = htmlspecialchars($_POST['kvk']);
    } else {
        $kvk = '';
    }

    $checkEmail = $conn->prepare('SELECT * FROM `user` WHERE email = ?');
    $checkEmail->execute([htmlspecialchars($_POST['email'])]);
    $result = $checkEmail->fetch(PDO::FETCH_ASSOC);

    if ($checkEmail->rowCount() === 0) {

        $addUser = $conn->prepare("
            INSERT INTO `user` 
            SET loginID = ?,
                `name` = ?,
                surname = ?,
                email = ?,
                street = ?,
                `number` = ?,
                zipcode = ?,
                city = ?,
                phone = ?,
                company = ?,
                kvk = ?");
        $addUser->execute([
            $_SESSION['loginID'],
            htmlspecialchars($_POST['name']),
            htmlspecialchars($_POST['surname']),
            htmlspecialchars($_POST['email']),
            htmlspecialchars($_POST['street']),
            htmlspecialchars($_POST['number']),
            htmlspecialchars($_POST['zipcode']),
            htmlspecialchars($_POST['city']),
            htmlspecialchars($_POST['phone']),
            $company,
            $kvk
        ]);

        $_SESSION['login'] = true;
        header('Location: ../user_acc');
    } else {
        $_SESSION['message'] = 'Er is al een account met dit email adres';
        header('Location: ../register');
    }

} else {
    header('Location: ../404');
}