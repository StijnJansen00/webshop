<?php
session_start();

$id = $_POST['id'];
$action = $_POST['action'];

if ($action === 'plus') {
    $_SESSION['cart'][$id]['quantity']++;
    echo "plus";
}

if ($action === 'minus') {
    $_SESSION['cart'][$id]['quantity']--;
    if ($_SESSION['cart'][$id]['quantity'] === '0' || $_SESSION['cart'][$id]['quantity'] === 0) {
        unset($_SESSION['cart'][$id]);
        $_SESSION['message'] = "Item verwijderd";
        echo "delete";
    }
    echo "min";
}

if ($action === 'delete') {
    unset($_SESSION['cart'][$id]);
    $_SESSION['message'] = "Item verwijderd";
    echo "delete";
}