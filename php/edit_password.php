<?php
require "db.php";
session_start();

$loginID = htmlspecialchars($_POST['login']);
$oldPassword = htmlspecialchars($_POST['old']);
$newPassword = htmlspecialchars($_POST['new']);


$checkPassword = $conn->prepare('SELECT * FROM login WHERE loginID = ?');
$checkPassword->execute([$loginID]);
$result = $checkPassword->fetch(PDO::FETCH_ASSOC);

if ($checkPassword->rowCount() > 0 && password_verify($oldPassword, $result['password'])) {
    $updatePassword = $conn->prepare("UPDATE login SET password = ? WHERE loginID = ?");
    $updatePassword->execute([password_hash($newPassword, PASSWORD_DEFAULT), $loginID]);

    echo 'true';
} else {
    echo "Wachtwoord komt niet overeen met het oude wachtwoord";
}
