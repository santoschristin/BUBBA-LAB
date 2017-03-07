<?php 


	require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
						



	
	require('C:\xampp\htdocs\APPDEV\production\dbcontroller.php');
	$db_handle = new DBController();
	
	$query="select  refs.STATUSCODE, refs.STATUSDESCRIPTION, pod.PURCHASEORDERNO,po.DATE,po.STATUSCODE, po.PURCHASEORDERNO, m.MATERIALCODE, pod.MATERIALCODE, rs.SUPPLIERID, m.SUPPLIERID, rs.SUPPLIERNAME
							from purchaseorders po LEFT JOIN ref_status refs on refs.STATUSCODE = po.STATUSCODE
												RIGHT join purchaseorderdetails pod on pod.PURCHASEORDERNO = po.PURCHASEORDERNO
												RIGHT join materials m on m.MATERIALCODE = pod.MATERIALCODE
												RIGHT join ref_suppliers rs on rs.SUPPLIERID = m.SUPPLIERID
							 GROUP BY pod.PURCHASEORDERNO"	;
							 
	$result = $db_handle->runQuery($query);
	
	
	$header = $db_handle->runQuery($query);
	
	$header = array('Date', 'Supplier', 'Purchase Order No.', 'Status');
	
	require('C:\xampp\htdocs\APPDEV\production\fpdf181\fpdf.php');
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12);		
	foreach($header as $heading) {
		foreach($heading as $column_heading)
			$pdf->Cell(90,12,$column_heading,1);
	}
	foreach($result as $row) {
		$pdf->SetFont('Arial','',12);	
		$pdf->Ln();
		foreach($row as $column)
			$pdf->Cell(90,12,$column,1);
	}
	$pdf->Output();
	
	
	

?>