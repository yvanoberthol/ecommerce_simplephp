<?php
require 'Repositoire/LignePanierRepository.php';
require 'vendor/fpdf.php';
class Pdf extends FPDF
{
    private $montant = 0;
    private $montantTaxe = 0;
    function LoadData()
    {
        $bdConfig = new BD_config();
        $lignepanier_repository = new LignePanierRepository($bdConfig);
        $ligne_paniers = $lignepanier_repository->getALL($_SESSION['client']['id_client']);
        $datas = [];
        foreach($ligne_paniers as $line){
            $data[0] = $line['nom'];
            $data[1] = $line['prix_vente'];
            $data[2] = $line['quantite_com'];
            $data[3] = $line['sous_total'];
            $this->montant += $line['sous_total'];
            $this->montantTaxe += $line['sous_total'] * 5 / 100;
            $datas[] = $data;
        }
        return $datas;
    }

    function entete(){
        $this->SetFillColor(26,114,252);
        $this->SetTextColor(242,242,242);
        $this->SetDrawColor(26,114,252);
        $this->SetFont('Times','BI',30);
        $this->MultiCell(160,20,'INNOVA','LRTB','L',true);
        $this->Image('Assets/photos/Logo innova.png',65,30,12);
        $this->Ln(3);
    }


    // Tableau coloré
    function FancyTable($header, $data)
    {
        // Nom client
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',14);
        $this->Cell(20,10,utf8_decode('Nom: '),0,'R',true);
        $this->Cell(50,10,$_SESSION['client']['nom'],0,'L',false);
        $this->Cell(80,10,'INNOVA',0,'L',true);
        $this->Ln(5);
        // Prénom client
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',14);
        $this->Cell(20,10,utf8_decode('Prénom: '),0,'R',true);
        $this->Cell(50,10,$_SESSION['client']['prenom'],0,'L',false);
        $this->Cell(80,10,utf8_decode('Situé à Bonaberi,'),0,'L',true);
        $this->Ln(5);
        // Prénom client
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',14);
        $this->Cell(20,10,utf8_decode('Email: '),0,'R',true);
        $this->Cell(50,10,$_SESSION['client']['email'],0,'L',false);
        $this->Cell(80,10,utf8_decode('Face Ecole Playto'),0,'L',true);
        $this->Ln(15);

        // Restauration des couleurs et de la police
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Times','BI',20);
        $this->MultiCell(160,10,'Votre facture',0,'C',false);
        $this->Ln(3);

        // Couleurs, épaisseur du trait et police grasse
        $this->SetFillColor(135,181,253);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B',14);
        // En-tête
        $w = array(40, 35, 45, 40);
        for($i=0, $iMax = count($header); $i< $iMax; $i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauration des couleurs et de la police
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Données
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR',0,'C',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
            $this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
            $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Trait de terminaison
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln();
        $this->Cell($w[0],6,'','L',0,'C',false);
        $this->Cell($w[1],6,'','',0,'C',false);
        $this->Cell($w[2],6,'Montant Hors taxe','R',0,'C',false);
        $this->Cell($w[3],6,$this->montant,'LR',0,'R',$fill);
        $this->Ln();
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln();
        $this->Cell($w[0],6,'','L',0,'C',false);
        $this->Cell($w[1],6,'','',0,'C',false);
        $this->Cell($w[2],6,'Taxe (5%)','R',0,'C',false);
        $this->Cell($w[3],6,ceil($this->montantTaxe),'LR',0,'R',$fill);
        $this->Ln();
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln();
        $this->SetFont('','B');
        $this->Cell($w[0],6,'','L',0,'C',false);
        $this->Cell(30,6,'','',0,'C',false);
        $this->Cell(50,6,'Montant Total(FCFA)','R',0,'C',false);
        $this->Cell($w[3],6,$this->montant + ceil($this->montantTaxe) ,'LR',0,'R',$fill);
        $this->Ln();
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln();
        $this->SetFont('','I');
        $this->MultiCell(160,10,utf8_decode('Enregistré le '). date('d-m-yy'),0,'R',false);
        $this->Ln(3);
    }


}