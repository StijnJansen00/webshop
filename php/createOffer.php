<?php
//ob_start();

class CreateOffer extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../img/logoo4y.png', 22, 15, 63);
        // Info
        $this->SetFont('Arial', '', 22);
        $this->Cell(170);
        $this->Cell(1, 16, '', 0, 2);
        $this->Cell(10, 5, 'Office4You', 0, 2, 'R');
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
$pdf = new CreateOffer();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Line break
$pdf->Ln(0);
// Set Info further of the side
$pdf->SetX(20);
// Company Info
$pdf->Cell(15, 5, 'Bedrijf: ' . $_POST['companyName'], 0, 2, 'L');
$pdf->Cell(15, 5, $_POST['name'] . $_POST['surname'], 0, 2, 'L');
//    $pdf->Cell(15, 5, 'Test, 0, 2, 'L');
$pdf->Cell(15, 5, $_POST['street'] . $_POST['number'], 0, 2, 'L');
$pdf->Cell(15, 5, $_POST['zipcode'] . '  ' . $_POST['city'], 0, 2, 'L');
//    $pdf->Cell(15, 5, 'KvK: ' . $kvk, 0, 2, 'L');
// Arial bold 15 for Invoice Nr
$pdf->SetFont('Arial', '', 20);
// Line break
$pdf->Ln(2);
// Invoice Nr
$pdf->Cell(80, 15, 'Offerte: #' . $offerNr, 0, 0, 'C');
// Font back to Arial Normal Size 10
$pdf->SetFont('Arial', '', 10);
// Line break
$pdf->Ln(3);
// Set Text back
$pdf->Cell(160);
// Date Invoice
$pdf->Cell(10, 5, 'Offertedatum: ' . $date, 0, 2, 'R');
$pdf->Cell(10, 5, 'Vervaldatum: ' . $untilDate, 0, 2, 'R');
// Line break
$pdf->Ln(4);
// Set Info further of the side
$pdf->SetX(20);
// Dear Client
$pdf->Cell(15, 5, 'Beste ' . $_POST['name'] . ',', 0, 0, 'L');
// Line break
$pdf->Ln(8);
// Set Info further of the side
$pdf->SetX(20);
// Text
$pdf->MultiCell(160, 5, 'Bedankt voor het gesprek van vandaag. Zoals afgesproken doe ik u hierbij een offerte tegemoet gekomen. Wij zien uit naar de samenwerking!', 0, 'L', 0);
// Line break
$pdf->Ln(5);
// Set Info further of the side
$pdf->SetX(20);
// Product Table
// Set Font Bold
$pdf->SetFont('Arial', 'B', 10);
// Heading Of the table
$pdf->Cell(20, 6, 'Aantal', 0, 0, 'L');
$pdf->Cell(70, 6, 'Product', 0, 0, 'L');
$pdf->Cell(35, 6, 'Bedrag Excl. BTW', 0, 0, 'R');
$pdf->Cell(35, 6, 'Bedrag Incl. BTW', 0, 0, 'R');
// Heading Of the table end
// Line break
$pdf->Ln(10);
// Set Arial Font Back
$pdf->SetFont('Arial', '', 10);
// Auto Load for Products in Cart
for ($i = 0; $i < $x; $i++) {

    $getProductInfo = $conn->prepare("SELECT * FROM product WHERE productID = ?");
    $getProductInfo->execute([$_POST['products']['productID'][$i]]);
    $result = $getProductInfo->fetch();

    $salePrice = ($result['priceExcl'] / 100) * $result['sale'];
    $desc = $result['productNumber'] . ' ' . $result['productName'];
    $amount = $_POST['products']['amount'][$i];
    $excl = ($result['priceExcl'] - $salePrice) * $_POST['products']['amount'][$i];
    $incl = $excl * 1.21;

    $pdf->SetX(20);
    $pdf->Cell(20, 8, $amount, 'T,B', 0, 'L');
    $pdf->Cell(70, 8, $desc, 'T,B', 0, 'L');
    $pdf->Cell(35, 8, EURO . number_format((float)$excl, 2, '.', ''), 'T,B', 0, 'R');
    $pdf->Cell(35, 8, EURO . number_format((float)$incl, 2, '.', ''), 'T,B', 1, 'R');

    $priceExcl += $excl;
    $priceIncl += $incl;
}
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
$pdf->MultiCell(160, 5, 'Deze offerte is geldig tot ' . $untilDate . ', indien je akkoord gaat met deze offerte kun je deze getekend terugsturen of digitaal ondertekenen', 0, 'L', 0);
// Line break
$pdf->Ln(4);
// Set Info further of the side
$pdf->SetX(20);
// Text
$pdf->MultiCell(160, 5, 'Voor akkoord:', 0, 'L', 0);

// Line break
$pdf->Ln(2);
// Set Info further of the side
$pdf->SetX(20);
// Invoice Nr
$pdf->Cell(30, 5, 'Naam:', 0, 0, 'L');
// Text
$pdf->Cell(50, 5, '________________________', 0, 'L', 0);
// Set Text back
$pdf->Cell(55);
// Text
$pdf->Cell(30, -5, 'Bedrijf: ', 0, 'L', 0);
// Text
$pdf->Cell(30);
// Text
$pdf->Cell(50, 5, '________________________', 0, 'L', 0);
// Line break
$pdf->Ln(10);
// Set Info further of the side
$pdf->SetX(20);
// Invoice Nr
$pdf->Cell(30, 5, 'Datum:', 0, 0, 'L');
// Text
$pdf->Cell(50, 5, '________________________', 0, 'L', 0);
// Set Text back
$pdf->Cell(55);
// Text
$pdf->Cell(30, -5, 'Plaats: ', 0, 'L', 0);
// Text
$pdf->Cell(30);
// Text
$pdf->Cell(50, 5, '________________________', 0, 'L', 0);
// Line break
$pdf->Ln(8);
// Set Info further of the side
$pdf->SetX(20);
// Text
$pdf->Cell(50, 5, 'Handtekening:', 0, 'L', 0);
// Text
$pdf->Cell(30);
// Text
$pdf->Cell(50, 15, '', 1, 'L', 0);

$filePath = '../uploads/';
$filename = 'offerte-' . $offerNr;
$file = md5($filename);

$pdf->Output($filePath . $file . '.pdf', 'F');

//$pdf->Output('I');
//$pdf->Output('testOfferte.pdf', 'F');

