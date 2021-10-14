<?php
include 'db.php';
session_start();
$info = explode(',', htmlspecialchars($_POST['info']));

$username = $info[0];
$password = $info[1];

$checkUsernameRegister = $conn->prepare('SELECT * FROM `login` WHERE username = ?');
$checkUsernameRegister->execute([$username]);
$result = $checkUsernameRegister->fetch(PDO::FETCH_ASSOC);

if ($checkUsernameRegister->rowCount() === 0) {
    $role = "user";

    $addUserRegister = $conn->prepare("INSERT INTO login SET username = ?, password = ?, `role` = ?");
    $addUserRegister->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role]);

    $loginID = $conn->lastInsertId();

    if (strpos(' ', $info[6])) {
        $phone = str_replace(' ', '+', $info[6]);
    } else {
        $phone = $info[6];
    }

    $company = $info[11] ?? NULL;
    $kvk = $info[12] ?? NULL;

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
                        kvk = ?
                ");
    $addUser->execute([
        $loginID,
        $info[3],
        $info[4],
        $info[5],
        $info[7],
        $info[8],
        $info[10],
        $info[9],
        $phone,
        $company,
        $kvk
    ]);

    $_SESSION['login'] = true;
    $_SESSION['loginID'] = $loginID;
    $_SESSION['role'] = 'user';

    echo 'true';
} else {
    echo 'Gebruikersnaam bestaat al';
}
