<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            $couponID = htmlspecialchars($_POST['couponID']);

            $deleteCoupon = $conn->prepare("DELETE FROM coupon WHERE couponID = ?");
            $deleteCoupon->execute([$couponID]);

            $_SESSION['message'] = 'Coupon is verwijderd';
            header('Location: ../admin_dashboard?adminPage=coupons');

        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}