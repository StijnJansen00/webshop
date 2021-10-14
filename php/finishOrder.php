<?php
include "db.php";
session_start();

if (isset($_POST['submit'])) {
    $orderID = $_POST['orderID'];

    $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ? WHERE orderID = ?");
    $updateOrder->execute(['Bezorgd', $orderID]);

    $_SESSION['message'] = 'Bestelling Bezorgd / Afgerond';

    header("Location: ../admin_order_overview?orderID=$orderID");
}