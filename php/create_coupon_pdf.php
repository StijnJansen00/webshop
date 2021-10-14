<?php

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
$pdf->Cell(80, 15, 'Bestelling: #' . $invoiceNr, 0, 0, 'C');
// Font back to Arial Normal Size 10
$pdf->SetFont('Arial', '', 10);
// Line break
$pdf->Ln(6);
// Set Text back
$pdf->Cell(160);
// Date Invoice
$pdf->Cell(10, 5, 'Besteldatum:  ' . $date, 0, 2, 'R');
$pdf->Ln(8);
// Set Info further of the side
$pdf->SetX(15);
// Dear Client
$pdf->Cell(15, 5, 'Beste meneer/mevrouw ' . $surname . ',', 0, 0, 'L');
// Line break
$pdf->Ln(8);
// Set Info further of the side
$pdf->SetX(15);
// Text
$pdf->MultiCell(160, 5, 'Bedankt voor jouw bestelling bij 4You(r)Office.nl', 0, 'L', 0);
// Line break
$pdf->Ln(3);
// Set Info further of the side
$pdf->SetX(15);
// Text
$pdf->MultiCell(160, 5, 'Wij vinden jouw mening belangrijk! Wilt u ons laten weten wat u van onze dienstverlening vindt.', 0, 'L', 0);
// Line break
$pdf->Ln(1);
// Set Info further of the side
$pdf->SetX(15);
// Text
$pdf->MultiCell(160, 5, 'Als dank hiervoor krijgt u bij uw volgende bestelling 5% korting.', 0, 'L', 0);
// Line break
$pdf->Ln(3);
// Set Info further of the side
$pdf->SetX(15);
// Text
$pdf->MultiCell(160, 5, 'Mocht er onverhoopt toch iets niet naar uw wens zijn, stuur dan (gerust) een mail naar: contact@4youoffice.nl of bel naar: +31 (0)55 204 0808', 0, 'L', 0);
// Line break
$pdf->Ln(5);
// Set Info further of the side
$pdf->SetX(15);
// Text Bold
$pdf->SetFont('Arial', 'B', 12);
// Text
$pdf->MultiCell(180, 5, 'Kortingscode: ' . $couponCode, 0, 'L', 0);
// Line break
$pdf->Ln(5);
// Set Info further of the side
$pdf->SetX(15);
// Text Normal
$pdf->SetFont('Arial', '', 10);
// Text
$pdf->MultiCell(160, 5, 'Met vriendelijke groet,', 0, 'L', 0);
// Line break
$pdf->Ln(4);
// Set Info further of the side
$pdf->SetX(15);
// Text
$pdf->MultiCell(160, 5, '4YouOffice', 0, 'L', 0);

$filePath = '../uploads/';
$filename = 'cp-' . $invoiceNr;
$file = $filename;

$pdf->Output($filePath . $file . '.pdf', 'F');

