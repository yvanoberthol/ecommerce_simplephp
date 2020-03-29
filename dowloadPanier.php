<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Pdf.php';

$pdf = new Pdf();
// Titres des colonnes
$header = array('Produit', 'Prix unitaire', utf8_decode('Quantité'), 'Montant');
// Chargement des données
$pdf->SetTitle('Votre facture');
$pdf->SetMargins(20,30);
$pdf->SetAuthor($_SESSION['client']['nom']);
$pdf->SetDisplayMode('fullpage','single');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->entete();
$pdf->Ln(15);
$pdf->FancyTable($header, $pdf->LoadData());
$pdf->Output('I','facture');