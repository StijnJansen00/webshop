<?php
include "db.php";
session_start();

if (isset($_POST['submit'])) {
    $orderID = $_POST['orderID'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    $updateOrder = $conn->prepare("UPDATE `order` SET orderStatus = ? WHERE orderID = ?");
    $updateOrder->execute(['Ingepakt', $orderID]);

    include "packOrderMail.php";

    $_SESSION['message'] = 'Bestelling ingepakt';

    header("Location: ../admin_order_overview?orderID=$orderID");
}