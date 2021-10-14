<?php
include "db.php";
session_start();

$backpack = $_POST['backpack'];
$cover = $_POST['cover'];
$label = $_POST['label'];
$agenda = $_POST['agenda'];
$etui = $_POST['etui'];
$pen = $_POST['pen'];
$pencil = $_POST['pencil'];
$ruler = $_POST['ruler'];
$geoRuler = $_POST['geoRuler'];
$paper = $_POST['paper'];
$stitcher = $_POST['stitcher'];

function random_chars_generate($chars)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($data), 0, $chars);
}

$packageNumber = random_chars_generate(20);

if ($backpack !== 'noBackpack') {
    $addBackpack = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addBackpack->execute([$packageNumber, $backpack, '1']);

    $_SESSION['cart'][$backpack] = [
        "quantity" => '1'
    ];
}
if ($cover !== 'noCover') {
    $addCover = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addCover->execute([$packageNumber, $cover, '1']);

    $_SESSION['cart'][$cover] = [
        "quantity" => '1'
    ];
}
if ($label !== 'noLabel') {
    $addLabel = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addLabel->execute([$packageNumber, $label, '1']);

    $_SESSION['cart'][$label] = [
        "quantity" => '1'
    ];
}
if ($agenda !== 'noAgenda') {
    $addAgenda = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addAgenda->execute([$packageNumber, $agenda, '1']);

    $_SESSION['cart'][$agenda] = [
        "quantity" => '1'
    ];
}
if ($etui !== 'noEtui') {
    $addEtui = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addEtui->execute([$packageNumber, $etui, '1']);

    $_SESSION['cart'][$etui] = [
        "quantity" => '1'
    ];
}
if ($pen !== 'noPen') {
    $addPen = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addPen->execute([$packageNumber, $pen, '1']);

    $_SESSION['cart'][$pen] = [
        "quantity" => '1'
    ];
}
if ($pencil !== 'noPencil') {
    $addPencil = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addPencil->execute([$packageNumber, $pencil, '1']);

    $_SESSION['cart'][$pencil] = [
        "quantity" => '1'
    ];
}
if ($ruler !== 'noRuler') {
    $addRuler = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addRuler->execute([$packageNumber, $ruler, '1']);

    $_SESSION['cart'][$ruler] = [
        "quantity" => '1'
    ];
}
if ($geoRuler !== 'noGeoRuler') {
    $addGeoRuler = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addGeoRuler->execute([$packageNumber, $geoRuler, '1']);

    $_SESSION['cart'][$geoRuler] = [
        "quantity" => '1'
    ];
}
if ($paper !== 'noPaper') {
    $addPaper = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addPaper->execute([$packageNumber, $paper, '1']);

    $_SESSION['cart'][$paper] = [
        "quantity" => '1'
    ];
}
if ($stitcher !== 'noStitcher') {
    $addStitcher = $conn->prepare("INSERT INTO package SET packageNumber = ?, productID = ?, amount = ?");
    $addStitcher->execute([$packageNumber, $stitcher, '1']);

    $_SESSION['cart'][$stitcher] = [
        "quantity" => '1'
    ];
}

echo 'true';
