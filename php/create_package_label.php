<?php

class CreatePackageLabel extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../img/logo4YouOffice.png', 22, 15, 63);
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

// Instanciation of inherited class
$pdf = new CreatePackageLabel();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Set Info further of the side
$pdf->SetX(20);
$pdf->SetFont('Arial', '', 20);
// Line break
$pdf->Ln(5);
// Invoice Nr
$pdf->Cell(80, 15, 'Pakbon: #' . $invoiceNr, 0, 0, 'C');
// Font back to Arial Normal Size 10
$pdf->SetFont('Arial', '', 10);
// Line break
$pdf->Ln(6);
// Set Text back
$pdf->Cell(160);
// Date Invoice
$pdf->Cell(10, 5, 'Pakbondatum:  ' . $date, 0, 2, 'R');
$pdf->Cell(10, 5, 'Referentie:  ' . $reference, 0, 2, 'R');
// Line break
$pdf->Ln(3);
// Set Text back
$pdf->Cell(160);
// Line break
$pdf->Ln(5);
// Set Info further of the side
$pdf->SetX(20);
// Set Info further of the side
$pdf->SetX(20);
// Product Table
// Set Font Bold
$pdf->SetFont('Arial', 'B', 10);
// Heading Of the table
$pdf->Cell(20, 6, 'Aantal', 0, 0, 'L');
$pdf->Cell(50, 6, 'Product Nr', 0, 0, 'L');
$pdf->Cell(100, 6, 'Product', 0, 0, 'L');
// Heading Of the table end
// Line break
$pdf->Ln(10);
// Set Font Normal
$pdf->SetFont('Arial', '', 10);

foreach ($_SESSION['cart'] as $id => $res) {
    $getProductInfo = $conn->prepare("SELECT * FROM product WHERE productID=:id");
    $getProductInfo->execute([
        ":id" => $id
    ]);
    $result = $getProductInfo->fetch();

    $pdf->SetX(20);
    $pdf->Cell(20, 8, $res['quantity'], 'T,B', 0, 'L');
    $pdf->Cell(50, 8, $result['productNumber'], 'T,B', 0, 'L');
    $pdf->Cell(100, 8, $result['brand'] . ' ' . $result['productName'], 'T,B', 0, 'L');
    $pdf->Ln(8);
}

// Line break
$pdf->Ln(20);
// Set Info further of the side
$pdf->SetX(20);
// Text
$pdf->MultiCell(180, 5, 'Heeft u een vraag? Neem dan contact met ons op via 4YouOffice.nl of bel ons op 055 - 204 0808', 0, 'L', 0);
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

$filePath = '../uploads/';
$filename = 'pakbon-' . $invoiceNr;
$file = $filename;

$pdf->Output($filePath . $file . '.pdf', 'F');

