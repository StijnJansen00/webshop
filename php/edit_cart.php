<?php
session_start();

$id = htmlspecialchars($_POST['id']);
$action = htmlspecialchars($_POST['action']);
$supply = htmlspecialchars($_POST['supply']);

if ($action === 'plus') {
    if ($_SESSION['cart'][$id]['quantity'] < $supply) {
        $_SESSION['cart'][$id]['quantity']++;
        echo "plus";
    } else {
        echo "limit";
    }
}

if ($action === 'minus') {
    $_SESSION['cart'][$id]['quantity']--;
    if ($_SESSION['cart'][$id]['quantity'] === '0' || $_SESSION['cart'][$id]['quantity'] === 0) {
        unset($_SESSION['cart'][$id]);
        $_SESSION['message'] = "Item verwijderd";
        echo "delete";
        die();
    }
    echo "min";
}

if ($action === 'delete') {
    unset($_SESSION['cart'][$id]);
    $_SESSION['message'] = "Item verwijderd";
    echo "delete";
}