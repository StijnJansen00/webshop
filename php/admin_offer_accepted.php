<?php
include 'db.php';
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {
        $offerID = $_POST['offerID'];
        $date = date("Y-m-d");

        $setInvoiceNumber = $conn->prepare("SELECT orderNumber FROM `order` ORDER BY orderID DESC LIMIT 1");
        $setInvoiceNumber->execute();
        $resultInvoice = $setInvoiceNumber->fetch();
        $invoiceNr = (int)$resultInvoice['orderNumber'];
        $invoiceNr++;

        $getOfferInfo = $conn->prepare("SELECT * FROM offer WHERE offerID = ?");
        $getOfferInfo->execute([$offerID]);
        $offerInfo = $getOfferInfo->fetch();

        $selectOfferproducts = $conn->prepare("SELECT * FROM offer_product WHERE offerID = ?");
        $selectOfferproducts->execute([$offerID]);

        $addCompanyInfo = $conn->prepare("INSERT INTO `user` SET `name` = ?, surname = ?, email = ?, street = ?, `number` = ?, zipcode = ?, city = ?, company = ?");
        $addCompanyInfo->execute([$offerInfo['offerName'], $offerInfo['offerSurname'], $offerInfo['offerEmail'],$offerInfo['offerStreet'],$offerInfo['offerStrNumber'],$offerInfo['offerZipcode'],$offerInfo['offerCity'],$offerInfo['offerCompany']]);
        $userID = $conn->lastInsertId();

        $addOrder = $conn->prepare("
            INSERT INTO `order`
            SET orderNumber = ?,
                orderDate = ?,
                paymentStatus = ?,
                orderStatus = ?,
                userID = ?,
                offerID = ?,
                streetSend = ?,
                numberSend = ?,
                zipcodeSend = ?,
                citySend = ?");
        $addOrder->execute([
            $invoiceNr,
            $date,
            'open',
            'Nog betalen',
            $userID,
            $offerID,
            $offerInfo['offerStreet'],
            $offerInfo['offerStrNumber'],
            $offerInfo['offerZipcode'],
            $offerInfo['offerCity']
        ]);
        $orderID = $conn->lastInsertId();

        foreach ($selectOfferproducts as $product){
            $addProductToOrder = $conn->prepare("INSERT INTO order_product SET orderID = ?, productID = ?, amount = ?");
            $addProductToOrder->execute([$orderID, $product['productID'], $product['amount']]);
        }

        $acceptOffer = $conn->prepare("UPDATE offer SET offerAccepted = ? WHERE offerID = ?");
        $acceptOffer->execute([true, $offerID]);

        $_SESSION['message'] = 'Offerte goedgekeurd';
        header("Location: ../admin_offer_overview?offerNr=$offerID");

    }
}