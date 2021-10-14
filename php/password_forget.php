<?php
include 'db.php';
session_start();

if (isset($_POST['submit'])) {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    $checkUserExists = $conn->prepare("SELECT * FROM login l INNER JOIN `user` u ON u.loginID = l.loginID WHERE l.username = ? AND u.email = ?");
    $checkUserExists->execute([$username, $email]);

    if ($checkUserExists->rowCount() > 0) {
        $login = $checkUserExists->fetch();

        function random_chars_generate($chars)
        {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($data), 0, $chars);
        }

        $password = random_chars_generate(10);

        $updatePassword = $conn->prepare("UPDATE login SET password = ? WHERE loginID = ?");
        $updatePassword->execute([password_hash($password, PASSWORD_DEFAULT), $login['loginID']]);

        include 'mail_password_send.php';

        $_SESSION['message'] = 'Er is een mail verstuurd met uw wachtwoord.';
        header('Location: ../login?login=login');
    } else {
        $_SESSION['message'] = 'Er bestaat geen account met dit email adres en gebruikersnaam';
        header('Location: ../password_forget');
    }


} else {
    header('Location: ../404');
}