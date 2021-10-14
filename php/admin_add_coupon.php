<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        if (isset($_POST['submit'])) {

            function random_chars_generate($chars)
            {
                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
                return substr(str_shuffle($data), 0, $chars);
            }

            $value = htmlspecialchars($_POST['value']);
            $coupon = random_chars_generate(10);
            $x = '0';
            $y = '0';

            if ($_POST['eur'] === 'eur') {
                $x = '1';
            }

            if ($_POST['oneTime']){
                $y = '1';
            }

            $addCoupon = $conn->prepare("INSERT INTO coupon SET coupon = ?, oneTime = ?, endDate = ?, `value` = ?, eur = ?");
            $addCoupon->execute([$coupon, $y, $_POST['endDate'], $value, $x]);

            $_SESSION['message'] = 'Coupon toegevoegd';
            header('Location: ../admin_dashboard?adminPage=coupons');
        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}