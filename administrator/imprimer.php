<?php

require ('../includes/fpdf17/fpdf.php');
//A4 width :219mm
//default margin : 10mm each side
//writable horizontal :219-(10*2)=189mm
if (isset($_GET['nom']) ) {

  $get_id = htmlspecialchars($_GET['nom']);
  $get_type = $_GET['type'];
  $get_date = htmlspecialchars($_GET['date']);
  $get_note = htmlspecialchars($_GET['note']);
    $get_raison= htmlspecialchars($_GET['raison']);
}

 



$pdf = new FPDF ('p','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->cell(190,5,'',0,1);
$pdf->SetFont('Arial','B',25);
$pdf->cell(190,40,'                     Demande d abscence',0,1);
//set font to arial,bold,14pt
$pdf->SetFont('Arial','',12);
$pdf->cell(49,8,'Nom complet ',1,0);
$pdf->cell(49,8,$get_id,1,1);
$pdf->cell(49,8,'Type ',1,0);

$pdf->cell(49,8,$get_type,1,1);
$pdf->cell(49,8,'raison de maladie ',1,0);
$pdf->cell(49,8,$get_raison,1,0);
$pdf->cell(70,8,'                     Date : '.$get_date,0,1);
$pdf->Image("../logo_impression.png",40,0,130,10);

$pdf->cell(200,19,'',0,1);
$pdf->cell(49,8,'Commentaire :',1,1);
$pdf->cell(200,19,'',0,1);
//comment
$pdf->SetFont('Arial','B',14);

$pdf->cell(50,30,$pdf->Write(8,$get_note),0,1);

$pdf->SetFont('Arial','',12);
$pdf->cell(200,19,'',0,1);
$pdf->cell(49,15,'Dicision :',0,1);
$pdf->SetFont('Arial','',16);
$pdf->cell(49,8,'                     Accepter ',0,0);$pdf->cell(10,8,'',0,0);$pdf->cell(5,5,'',1,1);
$pdf->cell(5,5,'',0,1);
$pdf->cell(49,8,'                     Refuser ',0,0);$pdf->cell(10,8,'',0,0);$pdf->cell(5,5,'',1,1);
$pdf->SetFont('Arial','',12);

$pdf->cell(100,19,'                                                                                                      signature :',0,1);
$pdf->Output();
?>
