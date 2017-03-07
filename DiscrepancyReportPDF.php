<?php
require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
session_start(); 					
require('C:\xampp\htdocs\APPDEV\production\fpdf181\fpdf.php');



class PDF extends FPDF
{
function Footer()
{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();

$toWord = " to ";

date_default_timezone_set("Asia/Manila");
$tDate=date("F j, Y, g:i a");



$pdf->SetAutoPageBreak(false);

$pdf->Image('LOGO.png',60,10,-180);

$pdf->setXY(50, 15);
$pdf->setFont("times","B","25");
$pdf->Cell(100, 60, "Inventory Discrepancy Report ","C");

$pdf->setXY(64, 26);
$pdf->setFont("times","B","16");
$pdf->Cell(140, 60, "from  " .$_SESSION["startDate"] .$toWord .$_SESSION["endDate"] );

$pdf->setXY(60, 35);
$pdf->setFont("times","B","14");
$pdf->Cell(180, 60, "Generated on: ".$tDate);
 
//table header
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->setFont("times","B","12");
$pdf->setXY(10, 80);
$pdf->Cell(50, 10, "Date", 1, 0, "C", 1);
$pdf->Cell(48, 10, "Material Name", 1, 0, "C", 1);
$pdf->Cell(35, 10, "New Quantity", 1, 0, "C", 1);
$pdf->Cell(30, 10, "Old Quantity", 1, 0, "C", 1);
$pdf->Cell(25, 10, "Discrepancy", 1, 0, "C", 1);




$y = $pdf->GetY();
$x = 10;
$pdf->setXY($x, $y);
 
$sql="select c.DATE, m.MATERIALNAME,c.NEWQUANTITY,c.OLDQUANTITY
                   from CALIBRATIONS c join MATERIALS m on m.MATERIALCODE=c.MATERIALCODE
				where m.MATERIALCODE=c.MATERIALCODE";
	 
	$result=mysqli_query($dbc,$sql)or die("Error: ".mysqli_error($dbc));

	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	
	$answer = $row['OLDQUANTITY'] - $row['NEWQUANTITY'];
	
	$pdf->Cell(50, 10, $row['DATE'], 1,0,"C");
	$pdf->Cell(48, 10, $row['MATERIALNAME'], 1,0,"C");
	$pdf->Cell(35, 10, $row['OLDQUANTITY'], 1,0,"C");
	$pdf->Cell(30, 10,  $row['NEWQUANTITY'], 1,0,"C");
	$pdf->Cell(25, 10,  $answer, 1,0,"C");
	
	$y += 10;
	
	 
	
	if ($y > 240)
	{
		
		
		$pdf->AddPage();
		$y = 20;
		
	}
	
	$pdf->setXY($x, $y);
	}

	
$pdf->setXY(75, 240);
$pdf->Cell(100, 40, "---------- END OF REPORT ----------");
		
$pdf->Output();
?>