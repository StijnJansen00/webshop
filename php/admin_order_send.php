<?php
include "db.php";
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $orderID = htmlspecialchars($_POST['orderID']);

        $selectInfo = $conn->prepare("
            SELECT *
            FROM `order` o 
            INNER JOIN `user` u ON u.userID = o.userID
            WHERE o.orderID = ?
        ");
        $selectInfo->execute([$orderID]);
        $result = $selectInfo->fetch();

        if ($result['sender'] === 'PostNL') {
            $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ? WHERE orderID = ?");
            $updateOrder->execute(['Verzonden', $orderID]);
        } else if ($result['sender'] === '4YouOffice') {
            $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ? WHERE orderID = ?");
            $updateOrder->execute(['Verzonden', $orderID]);
        }

        include "mail_order_send.php";

        $_SESSION['message'] = 'Bestelling verzonden';
        header("Location: ../admin_order_overview?orderID=$orderID");
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}