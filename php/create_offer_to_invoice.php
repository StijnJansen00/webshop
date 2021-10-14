<?php
$filePath = 'uploads/';
$filename = 'factuur-' . $order['numb'];
$file = $filename;

define('EURO', chr(128));

class CreateInvoice extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('img/logo4YouOffice.png', 22, 15, 63);
        // Info
        $this->SetFont('Arial', '', 22);
        $this->Cell(170);
        $this->Cell(1, 16, '', 0, 2);
        $this->Cell(10, 5, '4YouOffice', 0, 2, 'R');
        $this->SetFont('Arial', '', 10);
        $this->Cell(1, 5, '', 0, 2);
        $this->Cell(10, 6, 'Schumanpark 115', 0, 2, 'R');
        $this->Cell(10, 6, '7336 AS Apeldoorn', 0, 2, 'R');
        $this->Cell(10, 6, 'Telefoonnummer: 055 - 204 0808', 0, 2, 'R');
        $this->Cell(10, 6, 'BTW nummer: NL862629858B01', 0, 2, 'R');
        $this->Cell(10, 6, 'KVK nummer: 82854203', 0, 2, 'R');
        $this->Cell(10, 6, 'IBAN: NL79RABO0368709213', 0, 2, 'R');
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

try {
// Instanciation of inherited class
    $pdf = new CreateInvoice();

    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
// Line break
    $pdf->Ln(0);
// Set Info further of the side
    $pdf->SetX(20);
// Company Info
    $pdf->Cell(15, 5, 'Bedrijf: ' . $user['company'], 0, 2, 'L');
    $pdf->Cell(15, 5, $user['name'] . ' ' . $user['surname'], 0, 2, 'L');
    $pdf->Cell(15, 5, $user['phone'], 0, 2, 'L');
    $pdf->Cell(15, 5, $user['street'] . ' ' . $user['number'], 0, 2, 'L');
    $pdf->Cell(15, 5, $user['zipcode'] . '  ' . $user['city'], 0, 2, 'L');
    $pdf->Cell(15, 5, 'KvK: ' . $user['kvk'], 0, 2, 'L');
// Arial bold 15 for Invoice Nr
    $pdf->SetFont('Arial', '', 20);
// Line break
    $pdf->Ln(5);
// Invoice Nr
    $pdf->Cell(80, 15, 'Factuur: #' . $order['numb'], 0, 0, 'C');
// Font back to Arial Normal Size 10
    $pdf->SetFont('Arial', '', 10);
// Line break
    $pdf->Ln(3);
// Set Text back
    $pdf->Cell(160);
// Date Invoice
    $pdf->Cell(10, 5, 'Factuurdatum: ' . $date, 0, 2, 'R');
    $pdf->Cell(10, 5, 'Vervaldatum: ' . $untilDate, 0, 2, 'R');
// Line break
    $pdf->Ln(8);
// Set Info further of the side
    $pdf->SetX(20);
// Dear Client
    $pdf->Cell(15, 5, 'Beste ' . $user['name'] . ' ' . $user['surname'] . ',', 0, 0, 'L');
// Line break
    $pdf->Ln(8);
// Set Info further of the side
    $pdf->SetX(20);
// Text
    $pdf->MultiCell(160, 5, 'Bedankt voor uw bestelling. Hierbij uw factuur. Hieronder staan alle producten die u heeft besteld.', 0, 'L', 0);
// Line break
    $pdf->Ln(5);
// Set Info further of the side
    $pdf->SetX(20);
// Product Table
// Set Font Bold
    $pdf->SetFont('Arial', 'B', 10);
// Heading Of the table
    $pdf->Cell(20, 6, 'Aantal', 0, 0, 'L');
    $pdf->Cell(50, 6, 'Product', 0, 0, 'L');
    $pdf->Cell(20, 6, 'Datum', 0, 0, 'R');
    $pdf->Cell(35, 6, 'Bedrag Excl. BTW', 0, 0, 'R');
    $pdf->Cell(35, 6, 'Bedrag Incl. BTW', 0, 0, 'R');
// Heading Of the table end
// Line break
    $pdf->Ln(10);
// Set Arial Font Back
    $pdf->SetFont('Arial', '', 10);
// Auto Load for Products in Cart
    foreach ($offerInvoice as $res) {
        $getProductInfo = $conn->prepare("SELECT productNumber, productName FROM product WHERE productID = ?");
        $getProductInfo->execute([$res['productID']]);
        $result = $getProductInfo->fetch();

        $desc = $result['productNumber'] . ' ' . $result['productName'];
        $amount = $res['amount'];
        $excl = $res['offerProductPrice'] * $res['amount'];
        $incl = $excl * 1.21;

        $pdf->SetX(20);
        $pdf->Cell(20, 8, $amount, 'T,B', 0, 'L');
        $pdf->Cell(50, 8, $desc, 'T,B', 0, 'L');
        $pdf->Cell(20, 8, $date, 'T,B', 0, 'R');
        $pdf->Cell(35, 8, EURO . number_format((float)$excl, 2, '.', ''), 'T,B', 0, 'R');
        $pdf->Cell(35, 8, EURO . number_format((float)$incl, 2, '.', ''), 'T,B', 1, 'R');

        $priceExcl = $res['offerPriceTotal'];
    }

    $priceIncl = $priceExcl * 1.21;
    $btw = ($priceExcl / 100) * 21;

// Line break
    $pdf->Ln(8);
// Empty row
    $pdf->Cell(90, 6, '', 0, 0);
// Text excl BTW
    $pdf->Cell(60, 6, 'Totaalbedrag excl. BTW ' . EURO, 0, 0, 'R');
// Amount excl BTW
    $pdf->Cell(20, 6, number_format((float)$priceExcl, 2, '.', ''), 0, 1, 'R');
// Line break
    $pdf->Ln(1);
// Empty row
    $pdf->Cell(90, 6, '', 0, 0);
// Text BTW
    $pdf->Cell(60, 6, 'BTW hoog (21,0%) ' . EURO, 0, 0, 'R');
// Amount BTW
    $pdf->Cell(20, 6, number_format((float)$btw, 2, '.', ''), 0, 1, 'R');
// Push line inside
    $pdf->SetX(20);
// Draw Line
    $pdf->Cell(160, 0, '', 'T', 'C');
// Empty row
    $pdf->Cell(80, 6, '', 0, 0);
// Set Text Bold
    $pdf->SetFont('Arial', 'B', 10);
// Text Total Amount
    $pdf->Cell(60, 6, 'Totaalbedrag incl. BTW ' . EURO, 0, 0, 'R');
// Set Text Back
    $pdf->SetFont('Arial', '', 10);
// Total Amount
    $pdf->Cell(20, 6, number_format((float)$priceIncl, 2, '.', ''), 0, 1, 'R');
// Line break
    $pdf->Ln(8);
// Set Info further of the side
    $pdf->SetX(20);
// Text
    $pdf->MultiCell(160, 5, 'Heeft u een vraag? Neem dan contact met ons op via 4YouOffice.nl of bel ons op 055 - 204 0808', 0, 'L', 0);
// Line break
    $pdf->Ln(8);
// Set Info further of the side
    $pdf->SetX(20);
// Text
    $pdf->MultiCell(160, 5, 'Met vriendelijke groet,', 0, 'L', 0);
// Line break
    $pdf->Ln(4);
// Set Info further of the side
    $pdf->SetX(20);
// Text
    $pdf->MultiCell(160, 5, 'Klantenservice 4YouOffice', 0, 'L', 0);

    $pdf->Output($filePath . $file . '.pdf', 'F');

} catch (Exception $e) {
    echo '<pre>', print_r($e, true), '</pre>';
//        unlink($orderInvoice);
}

//echo '<pre>', print_r($pdf, true), '</pre>';
