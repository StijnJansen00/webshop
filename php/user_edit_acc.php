<?php
include 'db.php';
session_start();

if (isset($_SESSION['login']) && $_SESSION['role'] === 'user') {

    $info = explode(',', htmlspecialchars($_POST['info']));

    $userID = htmlspecialchars($_POST['login']);
    $street = $info[0];
    $number = $info[1];
    $zipcode = $info[2];
    $city = $info[3];
    $phone = $info[4];
    $company = $info[5];
    $kvk = $info[6];

        $updateUser = $conn->prepare("
            UPDATE `user`
            SET street=:street,
                number=:number,
                zipcode=:zipcode,
                city=:city,
                phone=:phone,
                company=:company,
                kvk=:kvk
            WHERE userID=:id");
        $updateUser->execute([
            ":street" => $street,
            ":number" => $number,
            ":zipcode" => $zipcode,
            ":city" => $city,
            ":phone" => $phone,
            ":company" => $company,
            ":kvk" => $kvk,
            ":id" => $userID
        ]);

        echo 'true';

}
